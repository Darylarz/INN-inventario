import http from 'k6/http';
import { check, sleep } from 'k6';
import { Trend } from 'k6/metrics';

export let options = {
  vus: 5,
  iterations: 50,
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const EMAIL = __ENV.USER_EMAIL || 'admin@inn.com';
const PASS = __ENV.USER_PASS || '12345678';
const TIPO = __ENV.TIPO || '';

let csrfToken = null;
let tipo_item = TIPO;
let loggedIn = false;

const statusCounts = {};
const failures = [];
const reqDur = new Trend('req_duration_debug');

function extractCsrf(body) {
  let m = body.match(/name="_token" value="([^"]+)"/i);
  return m ? m[1] : null;
}

export default function () {
  if (!loggedIn) {
    let res = http.get(`${BASE}/login`);
    csrfToken = extractCsrf(res.body);

    let loginBody = `email=${encodeURIComponent(EMAIL)}&password=${encodeURIComponent(PASS)}&_token=${encodeURIComponent(csrfToken)}`;
    let loginRes = http.post(`${BASE}/login`, loginBody, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } });
    check(loginRes, { 'login ok': (r) => r.status === 302 || r.status === 200 });

    res = http.get(`${BASE}/inventario/create`);
    csrfToken = extractCsrf(res.body) || csrfToken;
    let tipoMatch = res.body.match(/<option[^>]*value="([^"]+)"[^>]*>/i);
    if (tipoMatch) tipo_item = tipoMatch[1];
    loggedIn = true;
  }

  let serial = `dbg-${__VU}-${__ITER}-${Date.now()}`;
  let body = `tipo_item=${encodeURIComponent(tipo_item)}`;
  body += `&marca=${encodeURIComponent('DbgMarca'+__VU)}`;
  body += `&modelo=${encodeURIComponent('DbgModelo'+__ITER)}`;
  body += `&numero_serial=${encodeURIComponent(serial)}`;
  body += `&cantidad=1`;
  body += `&_token=${encodeURIComponent(csrfToken)}`;

  let res = http.post(`${BASE}/inventario/store`, body, { headers: { 'Content-Type': 'application/x-www-form-urlencoded' } });
  reqDur.add(res.timings.duration);

  // count status codes
  statusCounts[res.status] = (statusCounts[res.status] || 0) + 1;

  if (!(res.status === 302 || res.status === 200)) {
    if (failures.length < 10) {
      failures.push({ status: res.status, body: res.body.slice(0, 2000) });
    }
  }

  check(res, { 'create ok': (r) => r.status === 302 || r.status === 200 });

  sleep(0.5);
}

export function handleSummary(data) {
  // print statusCounts and sample failures to console
  console.log('== STATUS COUNTS ==');
  for (let s in statusCounts) {
    console.log(`${s}: ${statusCounts[s]}`);
  }
  if (failures.length) {
    console.log('== SAMPLE FAILURES ==');
    failures.forEach((f, i) => {
      console.log(`-- failure #${i+1} status=${f.status}`);
      console.log(f.body);
    });
  }

  return {};
}
