# MARKET
Sistema para gerenciamento de loja ou mercado.

## Estrutura inicial

- `public/`: ponto de entrada da aplicacao e arquivos publicos.
- `app/Controllers/`: controllers da arquitetura MVC.
- `app/Models/`: modelos da aplicacao.
- `app/Views/`: telas renderizadas pelo PHP.
- `config/`: configuracoes gerais do sistema.
- `database/`: banco SQLite e script SQL com a estrutura inicial.

## Como rodar

Execute o servidor embutido do PHP apontando para a pasta `public`:

```bash
php -S localhost:8000 -t public
```

Depois acesse:

```text
http://localhost:8000
```

## Banco de dados

O banco SQLite fica em:

```text
database/market.sqlite
```

As tabelas iniciais estao documentadas em:

```text
database/schema.sql
```

Produtos de exemplo para desenvolvimento:

```text
database/seed.sql
```
