<template>
  <nav>
    <!-- otros enlaces -->
    <button @click="logout">Cerrar sesión</button>
  </nav>
</template>

<script>
import axios from 'axios';
export default {
  methods: {
    logout() {
      axios.post('/logout')
        .then(() => {
          this.$router.push('/login');
        })
        .catch(() => {
          // igual redirigir aunque falle
          this.$router.push('/login');
        });
    }
  }
};
</script>