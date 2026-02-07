import http from 'k6/http';
import { check, sleep } from 'k6';

// 5-minute stepped capacity test (default)
export let options = {
  stages: [
    { duration: '1m', target: 50 },
    { duration: '1m', target: 100 },
    { duration: '1m', target: 200 },
    { duration: '1m', target: 400 },
    { duration: '1m', target: 0 },
  ],
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const API_KEY = __ENV.LOADTEST_API_KEY || '';
const TIPO = __ENV.TIPO || 'Computadoras';

export default function () {
  const payload = JSON.stringify({
    tipo_item: TIPO,
    marca: `STEP5_Marca_${__VU}`,
    modelo: `STEP5_Modelo_${__ITER}`,
    numero_serial: `step5-${__VU}-${__ITER}-${Date.now()}`,
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

  sleep(0.1);
}
