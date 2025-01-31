<template>
  <div class="container">
    <div class="select-container">
      <label for="cliente-select">Escolha um Cliente:</label>
      <select id="cliente-select" @change="handleClienteSelect" v-model="selectedCliente">
        <option value="">Escolha um Nome</option>
        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
          {{ cliente.nome }}
        </option>
      </select>
    </div>

    <div v-if="selectedCliente && series.length > 0" class="chart-container">
      <apexchart 
        type="bar"
        height="350"
        :options="chartOptions"
        :series="series"
      ></apexchart>

      <div class="client-info">
        <h3>Informações do Cliente</h3>
        <p><strong>Nome:</strong> {{ clienteInfo.nome }}</p>
        <p><strong>Email:</strong> {{ clienteInfo.email }}</p>
        <p><strong>Telefone:</strong> {{ clienteInfo.telefone }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts';

export default {
  components: {
    apexchart: VueApexCharts
  },
  data() {
    return {
      clientes: [],
      selectedCliente: '',
      series: [],
      clienteInfo: { nome: '', email: '', telefone: '' }, // Armazena as informações do cliente
      chartOptions: {
        chart: {
          id: 'respostas-por-cliente',
          type: 'bar',
          zoom: {
            enabled: true,
            type: 'xy',
            zoomedArea: {
              fill: {
                color: '#90CAF9',
                opacity: 0.4,
              },
            },
          },
          toolbar: {
            show: true,
            tools: {
              zoomin: true,
              zoomout: true,
              pan: true,
              reset: true,
            },
            export: {
              csv: false,
              png: false,
            },
          },
        },
        xaxis: {
          categories: [],
          labels: {
            style: {
              colors: '#000',
              fontSize: '12px',
              fontWeight: 'bold',
            },
          },
          title: {
            text: 'Categorias',
            style: {
              fontSize: '14px',
              fontWeight: 'bold',
            },
          },
        },
        title: {
          text: 'Respostas por Cliente',
          align: 'center',
        },
        yaxis: {
          title: {
            text: 'Total de Respostas',
          },
        }
      }
    };
  },
  methods: {
    async fetchClientes() {
      const url = 'http://127.0.0.1:8000/api/clientes';
      try {
        const response = await fetch(url);
        const data = await response.json();
        this.clientes = data;
      } catch (error) {
        console.error('Erro ao carregar clientes:', error);
      }
    },

    async handleClienteSelect() {
      if (!this.selectedCliente) {
        this.series = [];
        this.chartOptions.xaxis.categories = [];
        this.clienteInfo = { nome: '', email: '', telefone: '' }; 
        return;
      }
      await this.fetchRespostasPorCliente(this.selectedCliente);
      await this.fetchClienteInfo(this.selectedCliente);
    },

    async fetchRespostasPorCliente(clienteId) {
      const url = `http://127.0.0.1:8000/api/respostas-por-cliente/${clienteId}`;
      try {
        const response = await fetch(url);
        const data = await response.json();
        this.prepareChart(data);
      } catch (error) {
        console.error('Erro ao buscar dados para o cliente:', error);
      }
    },

    async fetchClienteInfo(clienteId) {
      const url = `http://127.0.0.1:8000/api/clientes/${clienteId}`;
      try {
        const response = await fetch(url);
        const data = await response.json();
        this.clienteInfo = {
          nome: data.nome,
          email: data.email,
          telefone: data.telefone,
        };
      } catch (error) {
        console.error('Erro ao buscar informações do cliente:', error);
      }
    },

    prepareChart(data) {
      console.log(data);

      const seriesData = [];
      const xaxisCategories = [];

      data.categorias.forEach(categoria => {
        if (!xaxisCategories.includes(categoria.categoria)) {
          xaxisCategories.push(categoria.categoria);
        }
      });

      seriesData.push({
        name: data.cliente_nome,
        data: data.categorias.map(categoria => categoria.total_respostas)
      });

      this.series = seriesData;
      this.chartOptions.xaxis.categories = xaxisCategories;
    },
  },
  async mounted() {
    await this.fetchClientes();
  },
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  max-width: 800px;
  margin: 20px auto;
}

.select-container {
  margin-bottom: 20px;
  width: 100%;
  text-align: center;
}

#cliente-select {
  padding: 10px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid #ddd;
  width: 60%;
  max-width: 400px;
  transition: all 0.3s;
}

#cliente-select:focus {
  border-color: #007bff;
  outline: none;
}

.chart-container {
  width: 100%;
  text-align: center;
}

h2 {
  color: #333;
  font-family: Arial, sans-serif;
}

label {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
  display: inline-block;
}

.client-info {
  margin-top: 20px;
  text-align: left;
  font-size: 14px;
}

.client-info p {
  margin: 5px 0;
}

.client-info h3 {
  font-size: 18px;
  font-weight: bold;
}
</style>
