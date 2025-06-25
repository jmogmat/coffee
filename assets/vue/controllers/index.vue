<template>
  <ul class="navbar-nav">
    <li class="nav-item dropdown">
      <a
          class="nav-link dropdown-toggle"
          href="#"
          id="userDropdown"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
      >
        {{ user?.username || user?.email || 'Usuario/a' }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li v-if="user">
          <a class="dropdown-item" href="/logout">Cerrar sesión</a>
        </li>
        <template v-else>
          <li><a class="dropdown-item" href="/login">Iniciar sesión</a></li>
          <li><a class="dropdown-item" href="/register">Registrarse</a></li>
        </template>
      </ul>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'UserMenu',
  data() {
    return { user: null };
  },
  async mounted() {
    try {
      const res = await fetch('/api/current-user');
      this.user = res.ok ? await res.json() : null;
    } catch {
      this.user = null;
    }
  }
};
</script>
