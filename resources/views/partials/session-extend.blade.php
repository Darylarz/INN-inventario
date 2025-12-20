<div id="session-extend-banner" style="display:none;position:fixed;right:20px;bottom:20px;z-index:9999;background:#111827;color:#fff;padding:12px 16px;border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.3);">
  <div style="display:flex;align-items:center;gap:12px;">
    <div>
      <strong>Sesión por expirar</strong>
      <div style="font-size:13px;opacity:.9">¿Deseas mantener la sesión activa?</div>
    </div>
    <div style="display:flex;gap:8px;margin-left:8px">
      <button id="btn-extend-session" style="background:#10b981;border:none;color:#fff;padding:8px 12px;border-radius:6px;cursor:pointer;">Mantener sesión</button>
      <button id="btn-logout-banner" style="background:transparent;border:1px solid #fff;color:#fff;padding:8px 12px;border-radius:6px;cursor:pointer;">Cerrar sesión</button>
    </div>
  </div>
</div>

<script>
(function(){
  const MAX_MIN = {{ config('session.lifetime', 15) }};
  const WARN_MIN = 1;
  const warnAt = (MAX_MIN - WARN_MIN) * 60 * 1000;
  const logoutAt = MAX_MIN * 60 * 1000;
  const banner = document.getElementById('session-extend-banner');
  const btnKeep = document.getElementById('btn-extend-session');
  const btnLogout = document.getElementById('btn-logout-banner');
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  let warnTimer, logoutTimer;

  function resetTimers(){
    clearTimeout(warnTimer); clearTimeout(logoutTimer);
    warnTimer = setTimeout(()=> banner.style.display = 'block', warnAt);
    logoutTimer = setTimeout(autoLogout, logoutAt);
  }

  async function doKeepAlive(){
    try {
      const res = await fetch('{{ route('session.keepalive') }}', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token },
        credentials: 'same-origin',
        body: JSON.stringify({})
      });
      if (res.ok) {
        banner.style.display = 'none';
        resetTimers();
      } else {
        window.location.href = '{{ route('login') }}';
      }
    } catch (e) {
      window.location.href = '{{ route('login') }}';
    }
  }

  // Intentar logout por fetch; si falla (419 u otro) redirigir al login
  async function doLogout(){
    try {
      const res = await fetch('{{ route('logout') }}', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token },
        credentials: 'same-origin',
        body: JSON.stringify({})
      });
      // si la respuesta no es 200 OK redirigir al login de todas formas
      window.location.href = '{{ route('login') }}';
    } catch (e) {
      window.location.href = '{{ route('login') }}';
    }
  }

  function autoLogout(){
    // no hacer submit del formulario: intentar logout por fetch y si no posible redirigir a login
    doLogout();
  }

  btnKeep.addEventListener('click', doKeepAlive);
  btnLogout.addEventListener('click', doLogout);
  ['mousemove','keydown','mousedown','touchstart','scroll'].forEach(e => window.addEventListener(e, resetTimers, {passive:true}));
  resetTimers();
})();
</script>