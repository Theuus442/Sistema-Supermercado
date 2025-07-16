# 🛒 Mini Sistema de Gestão de Supermercado

## 📌 Descrição

Este é um sistema web em **PHP puro** para gestão simples de um supermercado, com controle de **usuários por perfil**, **sessões**, e **acesso a funcionalidades específicas**. O projeto utiliza **banco de dados MySQL com PDO**, organização modular e aplicação de **boas práticas de desenvolvimento**.

---

## 👤 Perfis de Usuário

| Perfil       | Permissões |
|--------------|------------|
| **Caixa**     | Registrar vendas, acessar painel de produtos |
| **Estoque**   | Cadastrar, editar, excluir e listar produtos |
| **Admin**     | Acessar todos os produtos e solicitar permissões ao financeiro |
| **Financeiro**| Visualizar solicitações e aprovar/recusar permissões |

---

## ✅ Funcionalidades Implementadas

- ✅ Login com **autenticação segura** (`password_verify`)
- ✅ Controle de **sessões** e **redirecionamento** por perfil
- ✅ Registro de **vendas reais** com atualização de estoque
- ✅ CRUD completo de **produtos**, com exclusão lógica
- ✅ Sistema de **solicitação de permissões** (Admin → Financeiro)
- ✅ Interface com **Bootstrap 5** e **ícones**
- ✅ Separação de responsabilidades:
  - `lib/`: serviços (`ProdutoService`, etc.)
  - `queries/`: comandos SQL externos
  - `views/`: telas organizadas por painel
  - `actions/`: ações do sistema (editar, vender, etc.)

---

## 🗂 Estrutura do Projeto

Sistema-Supermercado/
│
├── actions/ # Arquivos responsáveis por processar ações (inserir, excluir, venda, etc.)
├── config/ # Arquivos de configuração e conexão com o banco
├── helpers/ # Helpers para sessão e controle de acesso
├── lib/ # Classes de serviço (ProdutoService, UsuarioService, etc.)
├── queries/ # Arquivos com SQL separados
├── views/ # Telas da aplicação (login, dashboard, painéis)
│ ├── painel/ # Views específicas por perfil (admin, caixa, estoque, etc.)
│ └── layout.php # Template base com Bootstrap
├── .env # Variáveis de ambiente (credenciais do banco)
├── login.php # Tela de login
├── logout.php # Encerramento de sessão

---

## ▶️ Como Usar

1. Clone este repositório:
   ```bash
   git clone https://github.com/Theuus442/Sistema-Supermercado.git

Configure o ambiente local:

PHP 8.x

MySQL

Servidor local (XAMPP, Laragon, PHP embutido)

Configure o .env com as credenciais:

DB_HOST=localhost
DB_PORT=3306
DB_NAME=mercado_ggl
DB_USER=root
DB_PASS=

Execute os scripts SQL para criar as tabelas(Como desejar, porém não se esqueça de alterar nas queries):

usuarios

produtos

vendas

venda_produtos

solicitacoes

Acesse via navegador:

http://localhost/Sistema-Supermercado/views/login_form.php
🧪 Usuários de Teste
Usuário	Senha	Perfil
admin	123	Admin
estoque	123	Estoque
caixa	123	Caixa
financeiro	123	Financeiro

As senhas devem estar hasheadas no banco usando password_hash().

📌 Observações
O projeto utiliza password_verify() para validar senhas de forma segura.

Todas as funcionalidades são controladas com base no perfil da sessão atual.

O SQL está modularizado na pasta queries/ e carregado dinamicamente nos serviços.