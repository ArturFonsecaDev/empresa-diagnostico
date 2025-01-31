<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'], // Permite todos os métodos (GET, POST, PUT, DELETE, etc.)
    'allowed_origins' => ['*'], // Adicione a URL do seu front-end
    'allowed_origins_patterns' => ['*'],
    'allowed_headers' => ['*'], // Permite todos os cabeçalhos
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // Configure como true se usar cookies/sessões
];

