<template>
  <div class="fundo">
    <!-- Perguntas -->
    <q-form @submit.prevent="submitForm" v-if="isThereAnyPergunta && !respostasEnviadas">
      <div v-for="pergunta in perguntas" :key="pergunta.id" class="pergunta-container" :class="{ 'erro': erros.includes(pergunta.id) }">
        <h2>{{ pergunta.texto_pergunta }}</h2>
        <q-option-group
          v-if="getOpcoes(pergunta.id).length"
          v-model="respostasCliente[pergunta.id]"
          :options="getOpcoes(pergunta.id).map(resposta => ({ 
            label: resposta.texto_resposta, 
            value: resposta.id 
          }))"
        />
        <p v-if="erros.includes(pergunta.id)" class="mensagem-erro">Esta pergunta precisa ser respondida.</p>
        <hr />
      </div>
      <q-btn type="submit" color="primary" label="Enviar" class="button"/>
    </q-form>
    <!-- sem perguntas -->
    <div class="sem-pergunta" v-else-if="!respostasEnviadas">
      <h2>Nenhuma pergunta cadastrada</h2>
    </div>
    <!-- respostas enviadas -->
    <div class="respostas-enviadas" v-else>
      <h2>O seu Resultado é:</h2>
      <p><span class="verde">{{categoriaPredominante}}</span></p>
    </div>
  </div>
</template>

<script>
import { getPerguntas, getRespostas } from '@/api/index.js';
import { QForm, QOptionGroup, QBtn } from 'quasar';
import { mapGetters } from 'vuex';

export default {
  name: 'MeuFormulario',
  components: {
    QForm,
    QOptionGroup,
    QBtn,
  },
  data() {
    return {
      perguntas: [],
      respostas: [],
      respostasCliente: [],
      respostasEnviadas: false,
      categoriaPredominante: '',
      erros: [], // Armazena perguntas não respondidas
      loading: false
    };
  },
  methods: {
    getOpcoes(perguntaId) {
      return this.respostas.filter(
        (resposta) => resposta.pergunta_id === perguntaId
      );
    },
    async submitForm() {
      this.erros = [];
      this.respostasEnviadas = false;

      if (!this.getClienteAtual) {
        console.error('Cliente não encontrado');
        alert('Cliente não encontrado');
        return;
      }

      this.loading = true;

      // Valida se todas as perguntas foram respondidas
      this.perguntas.forEach((pergunta) => {
        if (!this.respostasCliente[pergunta.id]) {
          this.loading = false;
          this.erros.push(pergunta.id);
        }
      });

      if (this.erros.length > 0) {
        this.loading = false;
        alert('Por favor, responda todas as perguntas antes de enviar.');
        return;
      }

      let expected_body = Object.entries(this.respostasCliente)
        .map(([key, obj]) => {
          console.log(key);
          return {
          cliente_id: this.getClienteAtual.id,
          resposta_id: obj
          }
        });

      expected_body = {
        respostas: expected_body
      };

      console.warn('Respostas enviadas:', expected_body);
      const url = `http://127.0.0.1:8000/api/respostas-clientes`;
      const data = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(expected_body),
      });
      const response = await data.json();

      if (data.status !== 200) {
        this.loading = false;
        console.error('Erro ao enviar respostas:', response);
        alert('Erro ao enviar respostas');
        return;
      }
      console.log(response);

      this.categoriaPredominante = response.descricao_categoria;

      console.log('SUCESSO!!');
      this.respostasEnviadas = true;
      this.loading = false;
    },
  },
  computed: {
    ...mapGetters(['getClienteAtual']),
    isThereAnyPergunta() {
      return this.perguntas.length > 0;
    }
  },
  async mounted() {
    this.respostasCliente = [];
    try {
      const [dataPerguntas, dataRespostas] = await Promise.all([
        getPerguntas(),
        getRespostas(),
      ]);
      this.perguntas = dataPerguntas;
      this.respostas = dataRespostas;

      this.perguntas.forEach((pergunta) => {
        this.$set(this.respostasCliente, pergunta.id, null);
      });
    } catch (error) {
      console.error('Erro ao carregar os dados:', error);
    }
  },
};
</script>

<style scoped>
.fundo {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  background-color: white;
  padding: 20px;
}

.pergunta-container {
  margin-bottom: 20px;
  text-align: left;
}

h2 {
  font-size: 1.25rem;
  line-height: 2rem;
  font-weight: bold;
}

/* Estiliza perguntas com erro */
.erro {
  border: 2px solid red;
  padding: 10px;
  border-radius: 5px;
}

/* Mensagem de erro */
.mensagem-erro {
  color: red;
  font-size: 0.9rem;
  margin-top: 5px;
}

.respostas-enviadas {
  text-align: center;
  padding: 20px;
  background-color: rgba(0, 128, 0, 0.1); /* Fundo sutil para destacar a seção */
  border-radius: 10px;
  margin-top: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.respostas-enviadas h2 {
  font-size: 1.5rem;
  color: #2c3e50; /* Tom escuro para melhor contraste */
  margin-bottom: 15px;
}

.resultado-texto {
  font-size: 1.2rem;
  font-weight: bold;
  color: #333;
}

.verde {
  display: inline-block;
  background-color: #28a745;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
  font-weight: bold;
  font-size: 1.2rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

</style>
