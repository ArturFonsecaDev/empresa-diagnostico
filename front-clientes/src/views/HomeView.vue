<template>
  <div class="fundo-cadastro">
    <q-layout view="lHh Lpr lFf">
      <q-page-container class="q-page-container">
        <q-card style="width: 400px" class="q-pa-md">
          <img src="@/assets/douranovo1.svg">
          <q-card-section>
            <ClienteCadastroForm />
          </q-card-section>
        </q-card>
      </q-page-container>
    </q-layout>
  </div>
</template>

<script>
import ClienteCadastroForm from '../components/ClienteCadastroForm.vue';

export default {
  name: 'HomeView',
  components: {
    ClienteCadastroForm,
  },
};
</script>

<style scoped>
.fundo-cadastro {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: url('@/assets/fundo-cadastro.jpg');
  background-size: cover;
  background-position: center;
  overflow: hidden;
}

.q-page-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; 
  width: 100%;
  overflow: hidden;
}

.q-card {
  max-width: 400px;
  width: 100%;
  margin: 20px;
  display: flex;
  flex-direction: column;
  height: 450px;
  overflow: hidden;  /* Tira a o scroll de fundo */
}

img {
  width: 100px;
  height: 75px;
  margin: 0 auto;
}

.q-card-section {
  overflow-y: auto;
}

</style>
