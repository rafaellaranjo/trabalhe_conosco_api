# trabalhe_conosco_api

execute a migration com ´´´docker-compose exec php php migrate.php

execute a seed com ´´´docker-compose exec php php seed.php

Este projeto é de uma API basica para gerenciamento de vagas.

## Visão Geral

A API fornece endpoints para autenticação e criação de usuários, controle de vagas, com um CRUD completo podendo ordenar e alterar paginação, também um controle de candidatos, onde os mesmos podem se cadastrar e cadastrar-se em diversas vagas.

## Tecnologias Utilizadas

- PHP 8
- SQLite
- PHP Unit
- Nginx
- Docker

## Instalação e Uso com Docker

1. Clone este repositório:
   ```sh
   git clone https://github.com/rafaellaranjo/trabalhe_conosco_api

2. Instale as dependências:
   ```sh
   cd trabalhe_conosco_api
   
   composer install --no-dev

   # ou

   php composer.phar install --no-dev


3. Copie o arquivo .env.example e renomeie para .env e configure suas variáveis de ambiente.
    ```sh
    cp .env.example .env

4. Execute o aplicativo com Docker Compose:
   ```sh
   docker-compose build
   docker-compose up -d

5. A api estará disponível em http://localhost:8080.

## Endpoints

Pode acessar a documentação em http://localhost:8080/

- **POST /auth/signin**: Autenticar usuário.
- **GET /user**: Listar os usuários cadastrados.
- **GET /user/:id**: Obter perfil de um usuário.
- **POST /user**: Registrar um novo usuário.
- **PATCH /user/:id**: Atualizar dados de um usuário existente.
- **DELETE /user/:id**: Deletar um usuário.
- **DELETE /user**: Deletar usuários em massa.

- **GET /jobs**: Listar os vagas cadastradas.
- **GET /jobs/:id**: Obter detalhes de uma vaga.
- **POST /jobs**: Registrar uma nova vaga.
- **PATCH /jobs/:id**: Atualizar dados de uma vaga.
- **DELETE /jobs/:id**: Deletar uma vaga.
- **DELETE /jobs**: Deletar vagas em massa.

- **GET /candidates**: Listar os candidatos cadastrados.
- **GET /candidates/:id**: Obter perfil de um candidato.
- **POST /candidates**: Registrar um novo candidato.
- **PATCH /candidates/:id**: Atualizar dados de um candidato existente.
- **DELETE /candidates/:id**: Deletar um candidato.
- **DELETE /candidates**: Deletar candidatos em massa.

- **GET /candidate_job**: Listar os vagas de um candidato.
- **GET /candidate_job/:id**: Obter uma vagas de um candidato.
- **POST /candidate_job**: Cadastrar candidato em uma vaga.
- **PATCH /candidate_job/:id**: Atualizar dados de uma cadidatura para vaga.
- **DELETE /candidate_job/:id**: Deletar um cadidatura para vaga.
- **DELETE /candidate_job**: Deletar cadidaturas para vagas em massa.
