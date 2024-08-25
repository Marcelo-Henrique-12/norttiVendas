<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o Projeto

Este é um projeto que utiliza o framework [Laravel](https://laravel.com), para o cadastro e manutenção do estoque de Produtos com suas respectivas Categorias na parte do administrador, e vendas na área do cliente. Este projeto utiliza o Laravel AdminLTE para um painel de administração, bem como o Laravel UI para scaffolding de autenticação.

O administrador utiliza de um login e páginas protegidas para o cadastro e atualização de Categorias e Produtos, e monitoramento de vendas.

Já o cliente, utiliza de seu login e páginas próprias para visualizar os produtos cadastrados, e realizar compra dos mesmos. Há um sistema de filtragem dos produtos pela sua categoria e relevância, conforme os mais vendidos. Há também um sistema em que o usuário pode adicionar ao carrinho itens antes de finalizar a compra.


### Principais Pacotes Utilizados

- **PHP**: ^8.2
- **Laravel Framework**: ^11.9
- **Laravel AdminLTE**: ^3.13
- **Bootstrap**: "^5.2.3",

## Requisitos

- **PHP**: 8.2 ou superior
- **Composer**: para gerenciamento de dependências PHP
- **Node.js**: 18 ou superior
- **NPM**: 8 ou superior

## Instalação

1. Clone o repositório:

   ```bash
   git clone https://github.com/Marcelo-Henrique-12/norttiVendas.git
   cd seu-repositorio

2. Instale as dependências do Composer:

    composer install

3. Copie o arquivo .env.example para .env e configure o banco de dados e outras variáveis de ambiente:

    cp .env.example .env

4. O sistema utiliza por padrão no .env o mysql, altere para o banco de dados de preferência, e atualize os dados no .env:
    DB_CONNECTION= "Sua Conexão de banco de dados"
    DB_HOST=127.0.0.1
    DB_PORT= suaPorta
    DB_DATABASE= "Nome do Banco Criado"
    DB_USERNAME= "Usuário do Banco"
    DB_PASSWORD= "Senha do usuário do Banco"

5. Gere a chave da aplicação:

    php artisan key:generate

6. Execute as migrações e seeders do banco de dados:

    php artisan migrate --seed

7. Instale as dependências do Node.js:

    npm install

8. Compile os ativos front-end:

    npm run dev

9. Inicie o servidor de desenvolvimento:

    php artisan serve


## Uso Como Usuário/Cliente

Após configurar o ambiente de desenvolvimento, você pode acessar a aplicação em http://localhost:8000.

Para realizar algumas operações como usuário é necessário registrar-se e fazer o login.

## Uso Como Administrador

Após configurar o ambiente de desenvolvimento, você pode acessar a aplicação em http://localhost:8000/admin.

Por padrão ao rodar o passo 5 da instalação, há um seeder que registra um administrador com os seguintes dados:

    nome: Admin
    e-mail de acesso: admin@contato.br
    senha: 12345678

Ao realizar login como administrador é possível alterar estes dados na tela de configurações do Perfil.


## Rodando Testes Unitários

**Importante** Crie um banco de dados reserva e altere no .env, e crie uma branch nova pois os arquivos da pasta storage serão deletados nos testes.

Recomendável realizar estes testes antes de inserir dados no aplicativo

Para rodar os testes, execute o seguinte comando:

    php artisan test

Para rodar os testes isolados, execute o seguinte comando:

    php artisan test --filter NomeDoMetodoDeTeste

## Rodando Seeders para teste

**Importante** os dados gerados são ficticios, apenas para o teste de inclusão em massa, recomendável utilizar para testes e com um banco de dados para teste.

Recomendável realizar estes testes antes de inserir dados no aplicativo

Para rodar as seeders, execute os seguintes comandos:

    php artisan db:seed --class=CategoriaSeeder
    php artisan db:seed --class=ProdutoSeeder
    php artisan db:seed --class=VendaSeeder

## Estrutura do Projeto

O projeto segue a estrutura padrão do Laravel. Abaixo estão alguns dos diretórios e arquivos principais:

app/: Contém os modelos, controladores, e outros arquivos principais da aplicação.
resources/views/: Contém as views Blade usadas na aplicação.
resources/js/: Contém os arquivos JavaScript utilizados na aplicação.
resources/css/: Contém os arquivos CSS utilizados na aplicação.
routes/: Contém os arquivos de rotas (web.php, api.php, etc.).
database/migrations/: Contém os arquivos de migração para o banco de dados.


