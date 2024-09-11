# Agenda de Contatos com Sistema de Login em PHP

## Objetivo

Desenvolver uma aplicação web em PHP para gestão de uma agenda de contatos. A aplicação deve incluir um sistema de autenticação (login e senha) para proteger os dados dos usuários e permitir que cada usuário tenha acesso apenas aos seus próprios contatos. O layout da aplicação deve ser responsivo, utilizando o framework Bootstrap.

## Descrição do Projeto

Este projeto é uma Agenda de Contatos desenvolvida em PHP com conexão ao banco de dados MySQL. Ele permite que os usuários criem uma conta, façam login e gerenciem seus contatos pessoais (adicionar, editar e excluir). O layout foi feito usando Bootstrap para garantir responsividade.

### Funcionalidades

1. **Criação de uma Logo Personalizada**
   - Cada aluno deve criar uma logo personalizada para a aplicação, visível em todas as páginas do sistema.
   - A logo pode ser desenvolvida com ferramentas de design simples ou editores gráficos vetoriais.

2. **Funcionalidades do Menu**
   - **Início**: Página principal da agenda, onde o usuário pode visualizar seus contatos.
   - **Adicionar Contato**: Formulário para adicionar um novo contato.
   - **Gerenciar Contatos**: Página de listagem e gerenciamento dos contatos cadastrados.
   - **Perfil**: Edição das informações pessoais do usuário.
   - **Logout**: Encerra a sessão e redireciona para a página de login.

3. **Autenticação de Usuário**
   - Cadastro com nome, e-mail e senha.
   - Verificação do login e senha fornecidos.
   - Redirecionamento para a agenda de contatos após o login.

4. **Gestão de Contatos (CRUD)**
   - **Criar**: Adicionar novos contatos.
   - **Ler**: Exibir contatos cadastrados.
   - **Atualizar**: Editar informações de contatos existentes.
   - **Excluir**: Remover contatos da agenda.

5. **Validações e Segurança**
   - Validações nos formulários (e-mail válido, campos obrigatórios, etc.).
   - Armazenamento seguro das senhas no banco de dados (utilizando hash).
   - Acesso restrito aos contatos de cada usuário.

## Requisitos Técnicos

- **Linguagem**: PHP
- **Banco de Dados**: MySQL
- **Front-end**: HTML, CSS e JavaScript (opcional), utilizando Bootstrap
- **Autenticação**: Sessões em PHP
- **Validação**: Front-end (JavaScript) e back-end (PHP)
- **Deploy**: Publicação da aplicação no servidor gratuito 000Webhost

## Instruções de Execução

### Pré-requisitos

- Servidor Apache (recomendado: XAMPP, WAMP ou LAMP)
- PHP (versão 7.4 ou superior)
- MySQL (para banco de dados)
- phpMyAdmin (opcional para gerenciamento do banco de dados)

### Passo a Passo para Executar o Projeto

1. **Configuração do Ambiente**
   - Baixe e instale o XAMPP (para Windows) ou LAMP (para Linux).
   - Certifique-se de que o Apache e o MySQL estão rodando.

2. **Colocar os Arquivos do Projeto no Servidor**
   - Copie os arquivos do projeto para a pasta raiz do servidor local. No caso do XAMPP, a pasta deve ser: `C:\xampp\htdocs\agenda_contatos`

3. **Importar o Banco de Dados**
   - Acesse o phpMyAdmin: `http://localhost/phpmyadmin`
   - Crie um novo banco de dados com o nome `agenda_contatos` (ou importe o arquivo `.sql` fornecido).
   - Importe o banco de dados na aba "Importar".

4. **Configurar a Conexão com o Banco de Dados**
   - Abra o arquivo `db_connect.php` e configure as credenciais de conexão ao banco de dados MySQL.

     ```php
     <?php
     $servername = "localhost";
     $username = "root"; // Usuário da sua máquina
     $password = ""; // Senha da sua máquina
     $dbname = "agenda_contatos";

     $conn = new mysqli($servername, $username, $password, $dbname);

     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     ?>
     ```

5. **Executar o Projeto**
   - Abra o navegador e acesse a aplicação através da URL: `http://localhost/agenda_contatos`
   - A página inicial será a tela de Login. Use o usuário de exemplo `admin@admin.com` com a senha `admin` para fazer login.

6. **Funcionalidades Principais**
   - **Login/Logout**: Faça login com e-mail e senha registrados. Use o botão de logout para se desconectar.
   - **Gerenciamento de Contatos**: Adicione, edite e exclua contatos.
   - **Validação de Senha**: O registro exige confirmação correta da senha.
   - **Logo Personalizada**: Logo visível no cabeçalho de todas as páginas.

7. **Backup e Restauração do Banco de Dados**
   - Para backup, use o phpMyAdmin e vá para a aba "Exportar".
   - Para restaurar, use a aba "Importar" no phpMyAdmin.

## Link da Aplicação Hospedada

[http://agendacontatos.rf.gd/](http://agendacontatos.rf.gd/)

## Considerações Finais

Este projeto demonstra o uso de PHP e MySQL na implementação de uma aplicação CRUD para gerenciamento de contatos pessoais. Inclui boas práticas de desenvolvimento web, como validação de dados, autenticação segura e um layout responsivo com Bootstrap. A aplicação é intuitiva e funcional, possibilitando o gerenciamento completo de uma agenda de contatos.
