# Teste DC Tecnologia

Aplicação web para gestão de **clientes**, **produtos**, **pedidos** e **pagamentos**, com autenticação de usuários.

## Stack

| Camada | Tecnologia |
|--------|------------|
| Backend | [PHP](https://www.php.net/) 8.2+ · [Laravel](https://laravel.com/) 12 |
| Autenticação | [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) |
| Banco de dados | [SQLite](https://www.sqlite.org/) (padrão) — suporta MySQL/MariaDB via `.env` |
| Frontend | [Blade](https://laravel.com/docs/blade) · [Tailwind CSS](https://tailwindcss.com/) |
| Build | [Vite](https://vitejs.dev/) 7 · [Axios](https://axios-http.com/) |

## Pré-requisitos

- PHP 8.2 ou superior (extensões: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) 18+ e npm

## Como rodar

### 1. Instalar dependências e configurar o projeto

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Crie o arquivo do banco SQLite (se ainda não existir):

```bash
touch database/database.sqlite
```

Execute as migrations:

```bash
php artisan migrate
```

Instale os assets do frontend:

```bash
npm install
npm run build
```

> **Atalho:** o script `composer setup` executa os passos acima automaticamente (`composer install`, `.env`, `key:generate`, `migrate`, `npm install` e `npm run build`).

### 2. Subir a aplicação

**Desenvolvimento** (servidor PHP + fila + Vite em paralelo):

```bash
composer dev
```

**Ou manualmente**, em dois terminais:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Acesse: [http://localhost:8000](http://localhost:8000)

### 3. Primeiro acesso

1. Acesse a página inicial e clique em **Register** para criar um usuário.
2. Após o login, use o **Dashboard** para acessar clientes, produtos e pedidos.

## Comandos úteis

```bash
php artisan migrate          # rodar migrations
php artisan migrate:fresh    # recriar o banco (apaga dados)
composer test                # executar testes
npm run build                # build de produção dos assets
```

## Estrutura principal

- `app/Http/Controllers/` — controllers (Client, Product, Order, Payment)
- `app/Models/` — modelos Eloquent
- `resources/views/` — templates Blade
- `routes/web.php` — rotas da aplicação
- `database/migrations/` — schema do banco

## Licença

MIT
