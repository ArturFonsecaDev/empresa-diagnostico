<template>
  <q-page>
    <q-form @submit.prevent="submitForm" ref="form">
      <q-input
        v-model="cliente.nome"
        label="Nome"
        :rules="[val => !!val || 'Nome é obrigatório']"
        outlined
        lazy-rules
        autofocus
      />

      <q-input
        v-model="cliente.email"
        label="Email"
        :rules="[val => !!val || 'Email é obrigatório', val => /.+@.+\..+/.test(val) || 'Email inválido']"
        outlined
        lazy-rules
      />

      <q-input
        v-model="cliente.telefone"
        label="Telefone"
        :rules="[val => !!val || 'Telefone é obrigatório', val => /^\(?\d{2}\)?\s?\d{4,5}-\d{4}$/.test(val) || 'Telefone inválido']"
        outlined
        lazy-rules
        type="tel"
        v-mask="'(##) #####-####'"
      />

      <q-btn
        label="Cadastrar"
        type="submit"
        color="primary"
        class="q-mt-md button"
        :disable="sending"
        :loading="sending"
      >
        <template v-if="sending" v-slot:loading>
          <q-spinner />
        </template>
      </q-btn>
    </q-form>
  </q-page>
</template>

<script>
export default {
  name: "ClienteCadastroForm",
  data() {
    return {
      enviando: true,
      sending: false,
      cliente: {
        nome: "",
        email: "",
        telefone: "",
      },
      loading: false
    };
  },
  methods: {
    cleanPhoneNumber(phone) {
      return phone.replace(/\D/g, ''); // Remove qualquer coisa que não seja número
    },
    async submitForm() {
      this.sending = true;
      if (!this.$refs.form.validate()) {
        this.sending = false;
        return; // Se o formulário não for válido, não envia
      }
      const url = 'http://127.0.0.1:8000/api/clientes';

      try{
        const response = await fetch(url, {
          method: 'POST',
          headers: {
          'Content-Type': 'application/json'
          },
          body: JSON.stringify({
          nome: this.cliente.nome,
          email: this.cliente.email,
          telefone: this.cleanPhoneNumber(this.cliente.telefone),
          })
        });
        this.enviando = true;
        this.sending = true;
        if(response.status == 201) {
          this.enviando = false;
          const cliente = {
            id: (await response.json()).id,
            nome: this.cliente.nome,
            email: this.cliente.email,
            telefone: this.cliente.telefone,
          }
          this.$store.dispatch('atualizarClienteAtual', cliente);
          this.$router.push(`/perguntas`);
          this.sending = false;
      }
      else{
        this.loading = false;
        throw new Error('Não foi possível realizar o cadastro do cliente');
      }
      }catch(e){
        this.sending = false;
        this.enviando = false;
        alert('Erro ao cadastrar cliente');
        console.log(e);
      }
     
      
    }
  }
}

</script>

<style scoped>
.q-form {
  max-width: 400px;
  margin: auto;
  text-align: right;
}

</style>
