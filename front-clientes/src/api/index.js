export async function getPerguntas() {
  const url = 'http://127.0.0.1:8000/api/perguntas';

  const response = await fetch(url, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
    },
  });

  if (response.status === 200) {
    const data = await response.json(); 

    if (!data || data.length === 0) {
      console.error('Não foi possível carregar as perguntas ou nenhum dado encontrado');
      return;
    }
    return data;
  }

  throw new Error('Erro ao carregar as perguntas');
}


export async function getRespostas() {
  const url = 'http://127.0.0.1:8000/api/respostas';

  try {
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
      },
    });

    // Verificar se a resposta foi bem-sucedida (status 200)
    if (response.ok) {
      const data = await response.json();
      return data; // Retorna os dados carregados
    } else {
      throw new Error(`Erro ao carregar as respostas: ${response.statusText}`);
    }
  } catch (error) {
    // Caso ocorra algum erro na requisição ou no processamento da resposta
    console.error('Erro de requisição ou ao processar as respostas:', error);
    throw error; // Relança o erro para o código que chamou essa função poder tratá-lo
  }
}

