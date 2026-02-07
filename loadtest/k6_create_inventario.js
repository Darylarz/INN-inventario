import http from 'k6/http';
import { check, sleep } from 'k6';

export let options = {
  stages: [
    { duration: '15s', target: 5 },
    { duration: '30s', target: 20 },
    { duration: '30s', target: 50 },
    { duration: '30s', target: 0 },
  ],
  thresholds: {
    http_req_duration: ['p(95)<1500'],
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
  // 1) GET login page to obtain CSRF token + session cookie
  let res = http.get(`${BASE}/login`);
  let token = extractCsrf(res.body);
  check(token, { 'login token found': (t) => t !== null });

  // 2) POST /login (form) to authenticate (session cookie kept automatically)
  let loginBody = `email=${encodeURIComponent(EMAIL)}&password=${encodeURIComponent(PASS)}&_token=${encodeURIComponent(token)}`;
  let loginRes = http.post(`${BASE}/login`, loginBody, {
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
  check(loginRes, { 'login ok': (r) => r.status === 302 || r.status === 200 });

  // 3) GET create page to extract CSRF and a valid tipo_item option
  res = http.get(`${BASE}/inventario/create`);
  let token2 = extractCsrf(res.body) || token;
  // try to find first option value for tipo_item
  let tipoMatch = res.body.match(/<option[^>]*value="([^"]+)"[^>]*>/i);
  let tipo_item = tipoMatch ? tipoMatch[1] : (__ENV.TIPO || '');
  check(tipo_item, { 'tipo_item found': (t) => t !== '' });

  // 4) POST create (store) with randomized data to avoid collisions
  let serial = `load-${__VU}-${__ITER}-${Date.now()}`;
  let body = `tipo_item=${encodeURIComponent(tipo_item)}`;
  body += `&marca=${encodeURIComponent('LoadMarca'+__VU)}`;
  body += `&modelo=${encodeURIComponent('LoadModelo'+__ITER)}`;
  body += `&numero_serial=${encodeURIComponent(serial)}`;
  body += `&cantidad=1`;
  body += `&_token=${encodeURIComponent(token2)}`;

  let createRes = http.post(`${BASE}/inventario/store`, body, {
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
  check(createRes, { 'create ok': (r) => r.status === 302 || r.status === 200 });

  sleep(1);
}
