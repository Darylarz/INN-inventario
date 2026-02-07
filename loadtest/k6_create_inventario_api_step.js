import http from 'k6/http';
import { check, sleep } from 'k6';

// Steps can be customized via env var STEP_CONFIG as JSON, otherwise defaults used.
// Example: -e STEP_CONFIG='[{"duration":"2m","target":50},{"duration":"2m","target":150}]'
const DEFAULT_STAGES = [
  { duration: '2m', target: 50 },
  { duration: '2m', target: 100 },
  { duration: '2m', target: 200 },
  { duration: '2m', target: 400 },
  { duration: '1m', target: 0 },
];

let stages = DEFAULT_STAGES;
try {
  if (__ENV.STEP_CONFIG) stages = JSON.parse(__ENV.STEP_CONFIG);
} catch (e) {
  // ignore parse error and use defaults
}

export let options = {
  stages: stages,
};

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const API_KEY = __ENV.LOADTEST_API_KEY || '';
const TIPO = __ENV.TIPO || 'Computadoras';

export default function () {
  const payload = JSON.stringify({
    tipo_item: TIPO,
    marca: `STEP_Marca_${__VU}`,
    modelo: `STEP_Modelo_${__ITER}`,
    numero_serial: `step-${__VU}-${__ITER}-${Date.now()}`,
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

  // small sleep to allow many requests per VU but not fully saturate CPU on client
  sleep(0.1);
}
