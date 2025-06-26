# Gestão de Usuários e Perfis

Aplicação desenvolvida em Laravel e Vue 3 para gerenciar usuários e perfis. Cada usuário pode ter múltiplos perfis, e o sistema inclui controle de acesso baseado no perfil "Administrador".

---

## Descrição do Projeto

Funcionalidades:

- Autenticação de usuários (registro, login e logout)
- CRUD de usuários com associação de múltiplos perfis
- CRUD de perfis com associação de múltiplos usuários
- Restrição de acesso para usuários com o perfil "Administrador"
- Soft deletes para usuários e perfis
- Toasts para mensagens de sucesso/erro
- Paginação nas listagens
- Docker (Laravel Sail) para ambiente de desenvolvimento

---

## Passos para configurar o ambiente

### Pré-requisitos:

- Docker
- Laravel Sail
- Composer

### Tecnologias utilizadas
- Laravel 12
- Vue 3
- Inertia.js
- Tailwind CSS
- MySQL
- Docker (Laravel Sail)

### Funcionalidades de destaque
- Associação bidirecional entre usuários e perfis
- Restrição de acesso por perfil usando middleware
- Sistema de feedback com toast (mensagens automáticas e com botão fechar)
- Soft delete com suporte à recuperação futura
- Paginação reutilizável com componente Pagination.vue

### Melhorias futuras (sugestões)
- Exportação de usuários e perfis em CSV ou PDF
- Histórico de alterações (logs de auditoria)
- Painel com gráficos e métricas

### Usuário e senha de teste para login
Tipo	Dado
Email	admin@teste.com
Senha	password
Permissão	Perfil Administrador

| Tipo      | Dado                 |
|-----------|----------------------|
| Email     | admin@teste.com      |
| Senha     | password             |
| Permissão | Perfil Administrador |

#### Esse usuário pode acessar e gerenciar usuários, perfis e associações.

### Estrutura do Projeto
- app/Models/User.php: modelo do usuário
- app/Models/Profile.php: modelo do perfil
- app/Http/Middleware/IsAdmin.php: middleware que protege rotas administrativas
- UserController: gerencia usuários e seus perfis
- ProfileController: gerencia perfis e seus usuários
- resources/js/Pages: telas Vue com Inertia (Index, Create, Edit, Show)
- resources/js/Components: componentes como Toast, Pagination, etc.

### Instalação:

```bash
# Clonar o repositório
git clone git@github.com:Guilherme-coder/user-management.git user-management
cd user-management

cd minha-aplicacao

# Baixar dependências
composer install

# Subir os containers
./vendor/bin/sail up -d

# Acessar container
./vendor/bin/sail shell

# Copiar o arquivo de ambiente e gerar chave
cp .env.example .env
php artisan key:generate
```

### Migrations e Seeders:

```bash
# Rodar migrations
php artisan migrate

# Rodar seeders
php artisan db:seed
```

