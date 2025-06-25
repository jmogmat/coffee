<template>
  <ul class="navbar-nav">
    <li class="nav-item dropdown" :class="{ show: showDropdown }">
      <a
          class="nav-link dropdown-toggle"
          href="#"
          @click.prevent="toggleDropdown"
          :aria-expanded="showDropdown.toString()"
          id="userDropdown"
          role="button"
      >
        {{ user ? user.username || user.email : 'Usuario' }}
      </a>
      <ul
          class="dropdown-menu dropdown-menu-end"
          :class="{ show: showDropdown }"
          :aria-labelledby="user ? 'userDropdown' : 'authDropdown'"
      >
        <template v-if="user">
          <li><a class="dropdown-item" href="/logout">Cerrar sesión</a></li>
        </template>
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
  data() {
    return {
      user: null,
      showDropdown: false,
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    toggleDropdown() {
      this.showDropdown = !this.showDropdown;
    },
    fetchUser() {
      fetch('/api/current-user')
          .then((res) => (res.ok ? res.json() : null))
          .then((data) => {
            this.user = data;
          })
          .catch(() => {
            this.user = null;
          });
    },
  },
};
</script>

<style scoped>
/* Asegura que el dropdown quede visible correctamente */
.dropdown-menu.show {
  display: block;
  position: absolute;
}
</style>

