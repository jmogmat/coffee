<template>
  <ul class="navbar-nav" v-if="loaded">
    <!-- Si el usuario está logueado -->
    <li class="nav-item dropdown" v-if="user">
      <a
          class="nav-link dropdown-toggle"
          href="#"
          id="userDropdown"
          role="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
      >
        {{ user.username || user.email }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="/logout">Cerrar sesión</a></li>
      </ul>
    </li>

    <!-- Si el usuario NO está logueado -->
    <template v-else>
      <li class="nav-item">
        <a class="btn btn-outline-light me-2 my-2 my-lg-0" href="/login">Iniciar sesión</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-warning my-2 my-lg-0" href="/register">Registrarse</a>
      </li>
    </template>
  </ul>
</template>

<script>
export default {
  name: 'UserMenu',
  data() {
    return {
      user: null,
      loaded: false,
    };
  },
  async mounted() {
    try {
      const res = await fetch('/api/current-user');
      this.user = res.ok ? await res.json() : null;
    } catch {
      this.user = null;
    }
    this.loaded = true;
  },
};
</script>

