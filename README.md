![Imagem do projeto FitManageTech com o logo](<img src="/public/logo.png">)

# API FitManage Tech

O Projeto FitManage Tech consiste em uma API para gestão de academia, a qual permite o cadastro de usuário, gestão e listagem de alunos, exercício e rotina por parte dos instrutores.

A FitManage Tech, uma empresa altamente respeitada no ramo de academias, foi a solicitante do projeto front-end [TrainSys](https://github.com/VeronicaVilas/ProjetoTrainSys) e agora manifestou o interesse em dar continuidade ao projeto, solicitando a criação do back-end da aplicação.

Este é um projeto desenvolvido para o curso DEVinHouse ministrado pelo Senai (Serviço Nacional de Aprendizagem Industrial) em parceria com a Zucchetti.

## ✔️ Técnicas e tecnologias utilizadas

Projeto foi desenvolvido utilizando a linguagem laravel e banco de dados PostgreSQL.

#### Biblioteca utilizada

| Plugin | Uso |
| ------ | ------ |
| Dompdf | Permite a geração de documentos PDF a partir de visões (views) no Laravel |

## 🧰 Técnicas e padrões utilizadas

O projeto foi dividido em uma estruturas de pastas para organização, os quais contém:

| Local | Uso |
| ------ | ------ |
| /src/models | Contém todos modelos da aplicação |
| /src/controllers | Contém todos os controladores da aplicação |
| /src/middlewares | Contém os middlewares de validação |
| /src/database | Contém as migrações e sementes do banco de dados |
| /routes/api.php  | Define rotas da API para interação com aplicativos ou serviços externos |
| /resources/views | Contém os arquivos Blade, responsáveis pelas estilizações do email e PDF|

## 🛠️ Criando e executando localmente o projeto
Criar e executar o FitManage Tech em seu ambiente de desenvolvimento local é muito fácil. Certifique-se de ter o [Git](https://git-scm.com/downloads) e o [Visual Studio Code](https://code.visualstudio.com/) instalados e siga as instruções abaixo.


1. Clone o código fonte:

```bash
git clone https://github.com/VeronicaVilas/ProjetoFinal_Modulo02_FitManageTech
```

2. Instale dependências de desenvolvimento:

```bash
composer install
```

3. Criar um arquivo .env na raiz do projeto com os seguintes parametros:

```bash
DIALECT_DATABASE=''
HOST_DATABASE=''
USER_DATABASE=''
PASSWORD_DATABASE=''
PORT_DATABASE=''
PORT_API=''
NAME_DATABASE=''

MAIL_MAILER=''
MAIL_HOST=''
MAIL_PORT=''
MAIL_USERNAME=''
MAIL_PASSWORD=''
MAIL_ENCRYPTION=''
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
É importante que os parametros estejam corretamentes configurados.

4. Instale dependências de desenvolvimento:

```bash
composer install
```
5. Execute a seed para popular o banco de dados:

```bash
php artisan db:seed PopulatePlans
```

6. Execute em seguida:

```bash
php artisan serve
```

## 🏋🏽 Documentação da API

Para acesso as rotas privadas é necessário, após o login, informar o token para visualizar os dados. 

### 🚥 Endpoints

#### S01 - Cadastro de usuário (Rota Pública)

```http
  POST /api/users
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `integer` | **Autoincremental**. Chave primaria |
| `name` | `string` | **Obrigatório**. Nome do usuário|
| `email` | `string` | **Obrigatório**. Email do usuário válido|
| `date_birth` | `date` | **Obrigatório**. Data de nascimento do usuário|
| `cpf` | `string` | **Obrigatório**. CPF do usuário, único e válido|
| `password` | `string` | Senha de acesso do usuário|
| `plan_id` | `integer` | **Obrigatório**. Id do plano selecionado|


Request JSON exemplo
```http
{
    "name":"Verônica Vilas",
    "email":"veronica@gmail.com",
    "date_birth":"1997-02-21",
    "cpf":"123.456.789-21",
    "password":"senha123",
    "plan_id":3
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | dados inválidos|

Caso tenha sucesso em enviar a requisição, o usuário receberá um email de boas vindas com o nome, tipo do plano e limite de alunos suportados.

👀Modelo do email

![Imagem do projeto FitManageTech com o modelo do email](<img src="/public/Modelo_email.png">)
##

#### S02 - Login (Rota Pública)

```http
  POST /api/login
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. Email do usuário válido|
| `password` | `string` | **Obrigatório**. Senha de acesso do usuário.|


Request JSON exemplo
```http
{
    "email":"veronica@gmail.com",
    "password":"senha123"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `400` | dados inválidos|
|  `401` | login inválido|

##

#### S03 - Dashboard (Rota Privada)

```http
  GET /api/dashboard
```
Não é necessario resquest body

Exemplo de resposta:
```http
{
    "registered_students": 0,
    "registered_exercises": 0,
    "current_user_plan": "OURO",
    "remaining_students": "ilimitado"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|
|  `404` | não encontrado registro com o código informado|

##

#### S04 - Cadastro de exercícios (Rota Privada)

```http
  POST /api/exercises
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `integer` | **Autoincremental**. Chave primaria |
| `description` | `string` | **Obrigatório**. Nome do exercício|
| `user_id` | `string` | Id do usuário que cadastrou o exercício|

Exemplo de resposta:
```http
{
    "description": "Supino Reto"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `401` | login inválido|
|  `409` | Cadastro de dados duplicados|

##

#### S05 - Listagem de exercícios (Rota Privada)

```http
  GET /api/exercises
```
Não é necessario resquest body

Exemplo de resposta:
```http
{
    "id": 1,
    "description": "Supino Reto"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|

##

#### S06 - Deleção de exercícios (Rota Privada)

```http
  DELETE /api/exercises/{id}
```
Não é necessario resquest body

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `integer` | **Obrigatório**. número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `409` | Exercício vinculado ao id|
|  `403` | Dado não criado pelo usuário autenticado|
|  `404` | não encontrado registro com o código informado|

##

#### S07 - Cadastro de estudantes (Rota Privada)

```http
  POST /api/students
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `integer` | **Autoincremental**. Chave primaria |
| `name` | `string` | **Obrigatório**. Nome do estudante|
| `email` | `string` | **Obrigatório**. Email do estudante, único e válido|
| `date_birth` | `date` | **Obrigatório**. Data de nascimento do estudante|
| `cpf` | `string` | **Obrigatório**. CPF do estudante, único e válido|
| `contact` | `string` | **Obrigatório**. Telefone do estudante|
| `user_id` | `integer` | Id do usuário que realizou o cadastro|
| `city` | `string` | Nome da cidade do estudante|
| `neighborhood` | `string` | Nome do bairro do estudante|
| `number` | `string` | Número da casa do estudante|
| `street` | `string` | Nome da rua do estudante|
| `state` | `string` | Nome do estado do estudante|
| `cep` | `string` | CEP do estudante|


Exemplo de resposta:
```http
{
    "name": "José Santos",
    "email": "jose.santos@gmail.com",
    "date_birth": "1996-04-29",
    "cpf": "943.355.969-29",
    "contact": "+55 11 94824-4351",
    "cep": "12345-678",
    "street": "Rua das flores",
    "state": "BA",
    "neighborhood": "Bairro",
    "city": "Cidade",
    "number": "1456"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | dados inválido|
|  `401` | login inválido|
|  `403` | Atingido o limite de cadastro permitido no plano|

##

#### S08 - Listagem de exercícios (Rota Privada)

```http
  GET /api/exercises
```
Não é necessario resquest body

Exemplo de resposta:
```http
{
    "id": 15,
    "name": "Jaciara Silva",
    "email": "jaciara.silva@gmail.com",
    "date_birth": "1996-04-29",
    "cpf": "943.355.669-29",
    "contact": "+55 11 94374-4341",
    "city": "Cidade",
    "neighborhood": "Bairro",
    "number": "1456",
    "street": "Rua das flores",
    "state": "BA",
    "cep": "12345-678"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|

##

#### S09 - Deleção de estudante (Rota Privada)

```http
  DELETE /api/students/{id}
```
Não é necessario resquest body

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `integer` | **Obrigatório**. número inteiro chave primaria|

Não há response no body em caso de sucesso

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `204` | sucesso|
|  `403` | Dado não criado pelo usuário autenticado|
|  `404` | não encontrado registro com o código informado|

##

#### S10 - Atualização de estudantes (Rota Privada)

```http
  PUT /api/students/{id}
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | Nome do estudante|
| `email` | `string` | Email do estudante, único e válido|
| `date_birth` | `date` | Data de nascimento do estudante|
| `cpf` | `string` | CPF do estudante, único e válido|
| `contact` | `string` | Telefone do estudante|
| `user_id` | `integer` | Id do usuário que realizou o cadastro|
| `city` | `string` | Nome da cidade do estudante|
| `neighborhood` | `string` | Nome do bairro do estudante|
| `number` | `string` | Número da casa do estudante|
| `street` | `string` | Nome da rua do estudante|
| `state` | `string` | Nome do estado do estudante|
| `cep` | `string` | CEP do estudante|

Não há response no body em caso de sucesso

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|
|  `404` | não encontrado registro com o código informado|

##

#### S11 - Cadastro de treinos (Rota Privada)

```http
  POST /api/workouts
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `id`      | `integer` | **Autoincremental**. Chave primaria |
| `student_id` | `integer` | **Obrigatório**. Id do estudante|
| `exercise_id` | `integer` | **Obrigatório**. Id do exercício|
| `repetitions` | `integer` | **Obrigatório**. Número de repetições|
| `weight` | `decimal` | **Obrigatório**. Valor do peso|
| `break_time` | `integer` | **Obrigatório**. Tempo de pausa|
| `day` | `string` | Obrigatório Valores: SEGUNDA, TERÇA, QUARTA, QUINTA, SEXTA, SÁBADO, DOMINGO|
| `observations` | `string` | Observações|
| `time` | `integer` | Tempo|


Exemplo de resposta:
```http
{
     "student_id": 16,
    "exercise_id": 22,
    "repetitions": 10,
    "weight": 5,
    "break_time": 30,
    "day": "QUARTA",
    "observations":"...",
    "time": 3
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `201` | sucesso|
|  `400` | dados inválido|
|  `401` | login inválido|
|  `409` | Conflito de cadastro para treinos no mesmo dia|

##

#### S12 - Listagem de treinos do estudante (Rota Privada)

```http
  GET /api/students/{id}/workouts
```
Não é necessario resquest body

Exemplo de resposta:
```http
{
    "student_id": 16,
    "student_name": "José Santos",
    "workouts": {
        "SEGUNDA": [
            {
                "id": 3,
                "exercise_id": 2,
                "repetitions": 10,
                "weight": "5.00",
                "break_time": 30,
                "observations": "...",
                "time": 3,
                "exercise": {
                "id": 2,
                "description": "Supino"
                }
            }
        ],
        "TERÇA": [],
        "QUARTA": [],
        "QUINTA": [],
        "SEXTA": [],
        "SÁBADO": [],
        "DOMINGO": [],
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|
|  `404` | não encontrado registro com o código informado|

##

#### S13 - Listagem de estudante (Rota Privada)

```http
  GET /api/students/{id}
```
Não é necessario resquest body

Exemplo de resposta:
```http
{
    "id": 16,
    "name": "José Santos",
    "email": "jose.santos@gmail.com",
    "date_birth": "1996-04-29",
    "cpf": "943.355.969-29",
    "contact": "+55 11 94374-4141",
    "address": {
        "cep": "12345-678",
        "street": "Rua das flores",
        "state": "BA",
        "neighborhood": "Bairro",
        "city": "Cidade",
        "number": "1456"
}
```

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|
|  `404` | não encontrado registro com o código informado|

##

#### S13 - Listagem de estudante (Rota Privada)

```http
  GET /api/students/export
```
Não é necessario resquest body

A resposta é retornado em formado de PDF com o treino do estudante.

| Response Status       | Descrição                           |
|  :--------- | :---------------------------------- |
|  `200` | sucesso|
|  `401` | login inválido|
|  `404` | não encontrado registro com o código informado|

##
