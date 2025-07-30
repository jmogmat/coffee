<template>
  <section v-scroll-animate class="animate-from-left section-block">
  <div class="d-flex justify-content-between flex-column flex-lg-row text-center">
    <div class="div_text_index w-100 w-lg-50 d-flex flex-column justify-content-center align-items-center" style="height: 100%; min-height: 400px;">
      <h1 class="h1_title_intro mb-3">El comienzo de la magía</h1>
      <p class="p_info_coffee px-3" style="max-width: 90%;">
        Todo inicia con las bayas del cafeto, frutos rojos y brillantes que encierran en su interior los preciados granos de café. Una vez cosechadas en su punto óptimo de madurez, estas bayas son cuidadosamente procesadas para separar los granos.
      </p>
    </div>
    <div class="div_image_index w-100 w-lg-50 d-flex justify-content-center align-items-center">
      <img :src="imageBayas" alt="Bayas de cafe" width="800" height="500" class="img-fluid image_beans">
    </div>
  </div>
    <br>
  </section>
  <section v-scroll-animate class="animate-from-right section-block">
  <div class="d-flex justify-content-between flex-column flex-lg-row-reverse text-center">
    <div class="div_text_index w-100 w-lg-50 d-flex flex-column justify-content-center align-items-center" style="height: 100%; min-height: 400px;">
      <h1 class="h1_title_intro mb-3">El proceso del tueste</h1>
      <p class="p_info_coffee_2 px-3" style="max-width: 90%;">
        Tras el secado y el tueste, los granos se muelen y se someten al proceso de extracción, momento en el que el agua caliente entra en contacto con el café molido. Es aquí donde se libera su esencia: aceites, aromas y sabores únicos que dan vida a una bebida rica y compleja. La extracción no solo revela el carácter del grano, sino también la dedicación detrás de cada etapa del proceso.
      </p>
    </div>
    <div class="div_image_index w-100 w-lg-50 d-flex justify-content-center align-items-center">
      <img :src="imageToast" alt="Granos de cafe" width="800" height="500" class="img-fluid image_beans">
    </div>
  </div>
  </section>
</template>

<script>
import imageBayas from '@/images/bayas-cafe.jpg';
import imageToast from '@/images/toast_coffee.png';

export default {
  data() {
    return {
      imageBayas,
      imageToast
    };
  }
};
</script>