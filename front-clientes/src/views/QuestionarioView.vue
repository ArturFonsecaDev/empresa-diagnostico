<template>
  <div class="fundo">
    <q-card>
      <q-form @submit.prevent="submitForm">
        <div v-for="pergunta in perguntas" :key="pergunta.id" class="pergunta-container">
          <h2>{{ pergunta.texto_pergunta }}</h2>
          <div v-for="resposta in respostasFiltradas(pergunta.id)" :key="resposta.id" class="resposta-container">
            <button type="button" class="btn-resposta" :class="{ 'btn-active': isBtnActive}">{{ resposta.texto_resposta }}</button>
          </div>
            <hr>
        </div>
        <q-btn type="submit" color="primary" label="Enviar" />
      </q-form>
    </q-card>
  </div>
</template>

<script>
import { getPerguntas, getRespostas } from '@/api/index.js';

export default {
  data() {
    return {
      perguntas: [],
      respostas: [],
      respostasCliente: [],
      isBtnActive: false
    };
  },
  computed: {
    perguntasLength() {
      return this.perguntas.length;
    },
  },
  methods: {
    respostasFiltradas(perguntaId) {
      return this.respostas.filter(resposta => resposta.pergunta_id === perguntaId);
    },
    salvarResposta(resposta){
      this.respostasCliente.push(resposta);
    },
    submitForm() {
      console.log("Formulário enviado");
    },
    changeColor(){
      this.isBtnActive =!this.isBtnActive;
      this.$refs.btnSubmit.setDisabled(this.isBtnActive);
      setTimeout(() => {
        this.isBtnActive = false;
        this.$refs.btnSubmit.setDisabled(false);
      }, 3000);
    }
  },
  async mounted() {
    const [dataPerguntas, dataRespostas] = await Promise.all([getPerguntas(), getRespostas()]);
    this.perguntas = dataPerguntas;
    this.respostas = dataRespostas;
  }
};
</script>

<style scoped>
.fundo {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: url('@/assets/fundo-cadastro.jpg');
  background-size: cover;
  background-position: center;
  overflow: auto;
  padding: 20px;
}

.q-card {
  width: 800px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  border-radius: 10px;
  background-color: rgba(255, 255, 255, 0.9);
  padding: 20px;
  color: black;
  text-align: center;
}

.pergunta-container {
  margin-bottom: 20px;
  text-align: left;
}

.resposta-container {
  padding: 10px;
}

.btn-resposta {
  width: 4rem;
}

h2{
  font-size: 1.25rem;
  line-height: 2rem;
  font-weight: bold;
}

.btn-resposta {
  background-color: #027be3; /* Cor primária do Quasar */
  color: white; /* Cor do texto */
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-resposta:hover, .btn-active {
  background-color: #01279b; /* Cor mais escura no hover */
}


</style>
