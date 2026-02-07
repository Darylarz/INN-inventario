import http from 'k6/http';
import { check, sleep } from 'k6';

export let options = {
  stages: [
    { duration: '30s', target: 50 },
    { duration: '4m', target: 200 },
    { duration: '30s', target: 0 },
  ],
  thresholds: {
    http_req_duration: ['p(95)<3000'],
  },
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const API_KEY = __ENV.LOADTEST_API_KEY || '';
const TIPO = __ENV.TIPO || 'Computadoras';

export default function () {
  const payload = JSON.stringify({
    tipo_item: TIPO,
    marca: `API_Marca_${__VU}`,
    modelo: `API_Modelo_${__ITER}`,
    numero_serial: `api-${__VU}-${__ITER}-${Date.now()}`,
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

  sleep(0.2);
}
