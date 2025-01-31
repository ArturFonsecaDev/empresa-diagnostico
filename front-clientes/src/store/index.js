import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    clienteAtual: JSON.parse(localStorage.getItem('clienteAtual')) || {
      id: null,
      nome: 'não definido',
      email: '',
      telefone: ''
    },
    baseURL: 'http://127.0.0.1:8000'
  },
  getters: {
    // Para acessar o cliente atual em qualquer componente
    getClienteAtual(state) {
      return state.clienteAtual;
    },
    getBaseURL(state){
      return state.baseURL;
    }
  },
  mutations: {
    // Para definir o cliente atual
    SET_CLIENTE_ATUAL(state, cliente) {
      localStorage.setItem('clienteAtual', JSON.stringify(cliente));
      state.clienteAtual = cliente;
    },
  },
  actions: {
    // Ação para atualizar o cliente atual (pode ser chamada de qualquer componente)
    atualizarClienteAtual({ commit }, cliente) {
      commit('SET_CLIENTE_ATUAL', cliente);
    },
  },
  modules: {
  }
});
