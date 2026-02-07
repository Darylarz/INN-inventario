import http from 'k6/http';
import { check, sleep } from 'k6';

export let options = {
  stages: [
    { duration: '1m', target: 50 },
    { duration: '2m', target: 200 },
    { duration: '5m', target: 200 },
    { duration: '2m', target: 0 },
  ],
  thresholds: {
    http_req_duration: ['p(95)<2000'],
  },
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const EMAIL = __ENV.USER_EMAIL || 'test@example.com';
const PASS = __ENV.USER_PASS || 'password';

function extractCsrf(body) {
  let m = body.match(/name="_token" value="([^"]+)"/i);
  return m ? m[1] : null;
}

export default function () {
  // GET login page
  let res = http.get(`${BASE}/login`);
  let token = extractCsrf(res.body);
  if (!token) return;

  // POST login
  let loginBody = `email=${encodeURIComponent(EMAIL)}&password=${encodeURIComponent(PASS)}&_token=${encodeURIComponent(token)}`;
  let loginRes = http.post(`${BASE}/login`, loginBody, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } });
  if (!(loginRes.status === 302 || loginRes.status === 200)) return;

  // GET create
  res = http.get(`${BASE}/inventario/create`);
  let token2 = extractCsrf(res.body) || token;
  let tipoMatch = res.body.match(/<option[^>]*value="([^"]+)"[^>]*>/i);
  let tipo_item = tipoMatch ? tipoMatch[1] : (__ENV.TIPO || '');
  if (!tipo_item) return;

  // POST store
  let serial = `load-${__VU}-${__ITER}-${Date.now()}`;
  let body = `tipo_item=${encodeURIComponent(tipo_item)}`;
  body += `&marca=${encodeURIComponent('LoadMarca'+__VU)}`;
  body += `&modelo=${encodeURIComponent('LoadModelo'+__ITER)}`;
  body += `&numero_serial=${encodeURIComponent(serial)}`;
  body += `&cantidad=1`;
  body += `&_token=${encodeURIComponent(token2)}`;

  let createRes = http.post(`${BASE}/inventario/store`, body, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } });
  check(createRes, { 'create ok': (r) => r.status === 302 || r.status === 200 });

  sleep(0.5);
}
