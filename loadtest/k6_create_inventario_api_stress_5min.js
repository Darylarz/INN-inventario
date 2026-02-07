import http from 'k6/http';
import { check, sleep } from 'k6';

export let options = {
  // 5-minute stress test that ramps up to 1000 VUs then ramps down
  stages: [
    { duration: '1m', target: 100 },
    { duration: '1m', target: 300 },
    { duration: '1m', target: 600 },
    { duration: '1m', target: 1000 },
    { duration: '1m', target: 0 },
  ],
  // no strict thresholds for stress test; we'll inspect the exported summary
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const API_KEY = __ENV.LOADTEST_API_KEY || '';
const TIPO = __ENV.TIPO || 'Computadoras';

export default function () {
  const payload = JSON.stringify({
    tipo_item: TIPO,
    marca: `STRESS_Marca_${__VU}`,
    modelo: `STRESS_Modelo_${__ITER}`,
    numero_serial: `stress-${__VU}-${__ITER}-${Date.now()}`,
    cantidad: 1,
  });

  const headers = {
    'Content-Type': 'application/json',
    'X-API-KEY': API_KEY,
  };

  const res = http.post(`${BASE}/api/loadtest/inventario`, payload, { headers });
  check(res, {
    'status is 201': (r) => r.status === 201,
  });

  // minimal sleep to maximize request rate per VU
  sleep(0.05);
}
