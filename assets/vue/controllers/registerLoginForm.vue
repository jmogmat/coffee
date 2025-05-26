<script setup>
import { ref } from 'vue'

const username = ref('')
const email = ref('')
const password = ref('')

function submitForm() {
  // Acá podés manejar el envío de datos, por ejemplo con fetch o axios
  console.log('Formulario enviado:', {
    username: username.value,
    email: email.value,
    password: password.value,
  })

  // Limpiar formulario
  username.value = ''
  email.value = ''
  password.value = ''
}
</script>

<template>
  <div>
    <h2>Register and Login</h2>
    <form @submit.prevent="submitForm">
      <input type="text" v-model="username" placeholder="Usuario" />
      <input type="email" v-model="email" placeholder="Email" />
      <input type="password" v-model="password" placeholder="Contraseña" />
      <button type="submit">Registrar</button>
    </form>
  </div>
</template>

<style scoped>

</style>