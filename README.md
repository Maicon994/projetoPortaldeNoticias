
# The Fake Times

> Portal de notícias satíricas desenvolvido em **PHP** e **MySQL** como trabalho final da disciplina de **Programação WEB II**.

O **The Fake Times** simula um portal de notícias inspirado em sites como **Sensacionalista** e **The Onion**, apresentando uma interface de um jornal tradicional para publicar conteúdos totalmente fictícios e humorísticos.

---

# Funcionalidades

## Autenticação

- Cadastro de usuários
- Login e logout
- Senhas protegidas com **bcrypt**
- Controle de sessão
- Edição de perfil
- Exclusão de conta

---

## Gerenciamento de Notícias

CRUD completo de notícias:

- ➕ Criar
- 👁️ Visualizar
- ✏️ Editar
- 🗑️ Excluir

### Regras de negócio

- Usuários não logados visualizam apenas as notícias públicas do portal.
- Usuários logados visualizam:
  - as notícias padrão do sistema;
  - as notícias criadas por eles.
- Apenas o autor pode editar ou excluir suas próprias notícias.

---

## Comentários

Usuários autenticados podem comentar em qualquer notícia.

Os comentários são exibidos em ordem cronológica inversa (mais recentes primeiro).

---

## Sistema de Curtidas

- Curtir notícias
- Remover curtida clicando novamente
- Impede curtidas duplicadas através de restrições no banco de dados

---

# Estrutura do Projeto

```text
PORTALSATIRA/
├── config/
│   └── config.php
├── css/
│   └── style.css
├── cadastro.php
├── deletar-noticia.php
├── editar-noticia.php
├── header.php
├── index.php
├── login.php
├── logout.php
├── noticia.php
├── nova-noticia.php
├── perfil.php
└── README.md
```

---

# Requisitos

- PHP **7.4** ou superior
- Apache
- MySQL
- Servidor local, como:
  - XAMPP
  - WampServer
  - Laragon

---

# Instalação

## 1. Baixe ou clone o projeto

Copie a pasta **PORTALSATIRA** para a pasta do seu servidor local.

Exemplo no XAMPP:

```text
C:\xampp\htdocs\PORTALSATIRA
```

---

## 2. Crie o banco de dados

Abra o **phpMyAdmin**.

```
http://localhost/phpmyadmin
```

Crie um banco chamado:

```text
portal_satira
```

Depois execute o arquivo SQL disponibilizado junto ao projeto.

O script irá:

- criar todas as tabelas;
- inserir um usuário administrador;
- cadastrar três notícias satíricas de exemplo.

---

## 3. Configure a conexão

Abra o arquivo:

```text
config/config.php
```

Verifique se as configurações estão corretas.

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "portal_satira";
```

Caso utilize outro usuário ou senha no MySQL, altere esses valores.

---

## 4. Execute o projeto

Abra o navegador e acesse:

```text
http://localhost/PORTALSATIRA/index.php
```

---

# Credenciais para Teste

Após executar o script SQL, será criado automaticamente um usuário administrador.

**E-mail**

```text
redacao@faketimes.com
```

**Senha**

```text
123456
```

Você também pode criar novos usuários através da tela de cadastro para testar o funcionamento completo do sistema.

---

# Design

Todo o layout foi desenvolvido do zero com inspiração em grandes portais jornalísticos.

A identidade visual utiliza:

| Cor | Código |
|------|---------|
| Azul institucional | `#1a365d` |
| Vermelho de destaque | `#e53e3e` |

O contraste entre uma aparência séria e manchetes absurdas reforça o efeito humorístico do portal.

---

# Tecnologias Utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- SQL
- Apache

---

# Autor

Projeto desenvolvido como trabalho final da disciplina de **Programação WEB II**, por Maicon Ferreira Machado.

---

