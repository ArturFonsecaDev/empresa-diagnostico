# Projeto de Diagnóstico de Clientes

Este projeto tem como objetivo criar um sistema de diagnóstico para clientes, onde cada cliente preenche suas informações pessoais e responde a questões específicas. Os dados coletados são armazenados em um banco de dados **PostgreSQL** e exibidos em uma interface administrativa para análise. A interface inclui gráficos interativos que apresentam o total de respostas por categoria, além de informações detalhadas sobre o cliente.

## Tecnologias Utilizadas

- **Backend**: Laravel 10
- **Frontend**: Vue.js 2 com Vue CLI
- **Estilo e Componentes**: Quasar Framework
- **Gerenciamento de Estado**: Vuex
- **Roteamento**: Vue Router
- **Máscaras de Entrada**: Vue Mask
- **Gráficos**: ApexCharts
- **Banco de Dados**: PostgreSQL

## Funcionalidades

### Cliente
- Preenchimento de formulário com informações pessoais.
- Respostas às questões de diagnóstico.

### Área Administrativa
- Visualização de dados do cliente (nome, email, telefone, etc.).
- Exibição de gráficos interativos com as respostas por categoria.
- Organização de dados por cliente e categoria.

## Fluxo de Uso

1. **Cadastro do Cliente**: 
   O cliente preenche um formulário com suas informações (nome, email, telefone, etc.).
   
2. **Respostas ao Diagnóstico**: 
   O cliente responde a questões divididas por categorias.

3. **Armazenamento de Dados**: 
   As informações e respostas são enviadas para o backend, que as salva no banco de dados PostgreSQL.

4. **Visualização na Área Administrativa**: 
   Os administradores podem acessar o dashboard, onde:
   - Os dados do cliente são exibidos (nome, email, telefone).
   - Um gráfico de barras interativo mostra o número de respostas por categoria.
   - As informações são organizadas e podem ser filtradas por cliente.

5. **Análise e Acompanhamento**: 
   Os administradores utilizam os gráficos e os dados para análise e acompanhamento do diagnóstico do cliente.

## Pré-requisitos
- **Node.js**: Para rodar o frontend.
- **PHP**: Para rodar o backend Laravel.
- **Composer**: Para gerenciar dependências do Laravel.
- **PostgreSQL**: Para armazenar os dados.
