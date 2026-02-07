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
    http_req_duration: ['p(95)<2000'],
  },
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const EMAIL = __ENV.USER_EMAIL || 'admin@inn.com';
const PASS = __ENV.USER_PASS || '12345678';
const TIPO_FALLBACK = __ENV.TIPO || '';

// Per-VU state (module-level persists per VU instance)
let loggedIn = false;
let csrfToken = null;
let tipo_item = TIPO_FALLBACK;

function extractCsrf(body) {
  let m = body.match(/name="_token" value="([^"]+)"/i);
  return m ? m[1] : null;
}

function ensureLogin() {
  if (loggedIn) return;
  let res = http.get(`${BASE}/login`);
  csrfToken = extractCsrf(res.body);
  check(csrfToken, { 'login token found': (t) => t !== null });

  let loginBody = `email=${encodeURIComponent(EMAIL)}&password=${encodeURIComponent(PASS)}&_token=${encodeURIComponent(csrfToken)}`;
  let loginRes = http.post(`${BASE}/login`, loginBody, {
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });
  check(loginRes, { 'login ok': (r) => r.status === 302 || r.status === 200 });

  // GET create page to obtain CSRF and tipo_item (use same session)
  res = http.get(`${BASE}/inventario/create`);
  csrfToken = extractCsrf(res.body) || csrfToken;
  let tipoMatch = res.body.match(/<option[^>]*value="([^"]+)"[^>]*>/i);
  if (tipoMatch) {
    tipo_item = tipoMatch[1];
  }
  check(tipo_item, { 'tipo_item found': (t) => t && t.length > 0 });

  loggedIn = true;
}

export default function () {
  ensureLogin();

  // Create inventory item using session + csrf persisted per VU
  let serial = `vu-${__VU}-iter-${__ITER}-${Date.now()}`;
  let body = `tipo_item=${encodeURIComponent(tipo_item)}`;
  body += `&marca=${encodeURIComponent('LoadMarca'+__VU)}`;
  body += `&modelo=${encodeURIComponent('LoadModelo'+__ITER)}`;
  body += `&numero_serial=${encodeURIComponent(serial)}`;
  body += `&cantidad=1`;
  body += `&_token=${encodeURIComponent(csrfToken)}`;

  let createRes = http.post(`${BASE}/inventario/store`, body, {
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  });

  // If we detect session expired / CSRF problem (419) or redirect to login, retry once
  if (createRes.status === 419 || (createRes.status === 302 && createRes.headers['Location'] && createRes.headers['Location'].includes('/login'))) {
    // reset login state and attempt to re-login once
    loggedIn = false;
    ensureLogin();
    createRes = http.post(`${BASE}/inventario/store`, body, {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    });
  }

  check(createRes, { 'create ok': (r) => r.status === 302 || r.status === 200 });

  sleep(1);
}
