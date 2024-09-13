# 📚 Bibliolink - Sistema de Gestão de Biblioteca

Bem-vindo ao **Bibliolink**, um sistema completo para gerenciar sua biblioteca com eficiência! Este sistema permite o cadastro de usuários, livros, editoras, autores e oferece funcionalidades de consulta, edição, remoção, empréstimo e devolução de livros. O **Bibliolink** também inclui um sistema de login que diferencia clientes e funcionários, garantindo que cada tipo de usuário tenha acesso apenas às funcionalidades permitidas.

## 🚀 Funcionalidades Principais

### 🔑 Sistema de Autenticação
- **Login**: O sistema permite que clientes e funcionários façam login de maneira segura, diferenciando suas permissões.
- **Usuários**: O funcionário pode cadastrar novos clientes no sistema, que terão acesso limitado às funcionalidades de consulta e devolução de livros.
- **Foi criado um usuario com cargo de Funcionario para atuar em todos os comandos. Login: `admin@admin.com` - Senha: `admin`**

### 📋 Cadastro e Gestão
1. **Cadastro de Usuário**: Permite adicionar novos usuários ao sistema.
2. **Cadastro de Livro**: Permite adicionar novos livros ao acervo.
3. **Cadastro de Editora**: Permite adicionar novas editoras ao banco de dados.
4. **Cadastro de Autor**: Permite cadastrar autores e associá-los aos livros.

### ✏️ Edição de Registros
- **Editar Usuário**: Permite modificar as informações dos usuários cadastrados.
- **Editar Livro**: Atualize as informações de livros já cadastrados no sistema.
- **Editar Editora**: Modifique as informações das editoras cadastradas.
- **Editar Autor**: Permite editar as informações dos autores registrados.

### ❌ Remoção de Registros
- **Remover Usuário**: Exclua usuários do sistema.
- **Remover Livro**: Remova livros do acervo da biblioteca.
- **Remover Editora**: Exclua editoras da base de dados.
- **Remover Autor**: Remova autores do sistema.

### 🔍 Consultas
- **Consultar Usuário**: Visualize os detalhes dos usuários cadastrados.
- **Consultar Livro**: Acesse as informações dos livros disponíveis no acervo.
- **Consultar Editora**: Visualize as editoras registradas no sistema.
- **Consultar Autor**: Acesse os dados dos autores cadastrados.

### 📖 Empréstimos e Devoluções
- **Empréstimo de Livro**: O funcionário pode registrar o empréstimo de um livro a um cliente. É necessário fornecer o CPF do cliente e o ISBN do livro.
- **Devolução de Livro**: Os clientes podem devolver livros, informando o ISBN do livro e seu CPF.
- **Consultar Empréstimos**: Acompanhe o histórico de empréstimos e devoluções.

## 📄 Instruções de Uso

### 1. **Login no Sistema**
   - Acesse a página inicial e insira seu nome de usuário e senha.
   - Clientes têm acesso à consulta e devolução de livros.
   - Funcionários têm acesso total ao sistema, incluindo o gerenciamento de livros e usuários.

### 2. **Consultando Livros**
   - Após o login, vá até a seção "Consultar Livro".
   - Insira informações do título ou ISBN para encontrar um livro específico.
   - As informações do livro, incluindo sua disponibilidade, serão exibidas.

### 3. **Empréstimo de Livros**
   - Funcionários podem acessar a funcionalidade "Empréstimo de Livro".
   - Insira o CPF do cliente e o ISBN do livro que será emprestado.
   - Confirme o empréstimo, e o status do livro será atualizado no sistema.

### 4. **Devolução de Livros**
   - Tanto clientes quanto funcionários podem registrar devoluções.
   - Acesse "Devolução de Livro", insira o CPF do cliente e o ISBN do livro.
   - Confirme a devolução, e o status do livro voltará para "disponível".

## ⚙️ Configuração do Sistema

1. **Pré-requisitos**:
   - PHP 7.4 ou superior
   - MySQL ou MariaDB para gerenciamento do banco de dados
   - XAMPP ou servidor web local para testar o sistema

2. **Instalação**:
   - Clone o repositório para sua máquina local:
     ```bash
     git clone https://github.com/alessandro0augusto0/bibliolink.git
     ```
   - Importe o banco de dados utilizando o arquivo `bibliolink.sql` fornecido.
   - Configure as informações de conexão com o banco de dados no arquivo `conexao.php`.

3. **Estrutura do Banco de Dados**:
   - Tabelas principais:
     - `usuario`: Armazena as informações de clientes e funcionários.
     - `cadastrolivro`: Contém o acervo de livros cadastrados.
     - `editora`: Registra as editoras disponíveis.
     - `autor`: Armazena os autores cadastrados.
     - `emprestimos`: Armazena informações de empréstimos e devoluções de livros.

## 💡 Dicas de Navegação

- **Botão Voltar**: A qualquer momento, você pode clicar no botão "Voltar" nas páginas de instruções para retornar ao menu principal.
- **Sessão Ativa**: Certifique-se de estar logado para utilizar todas as funcionalidades do sistema.
- **Responsividade**: O sistema foi desenvolvido com Bootstrap para garantir uma navegação fluida em diferentes dispositivos.

## 🤝 Contribuindo

Se você deseja contribuir para o desenvolvimento deste projeto, siga os seguintes passos:
1. Faça um fork do projeto.
2. Crie uma nova branch:
   ```bash
   git checkout -b adicionar-autores
   ```
3. Envie suas modificações:
    ```bash
    git add cadastroautor.php
   git commit -m 'Adiciona funcionalidade de cadastro de autor'
    ```

4. Envie o push para o repositório:
    ```bash
    git push origin adicionar-autores
    ```
    
5. Crie uma nova branch para a funcionalidade:
   ```bash
   git checkout -b adicionar-autores
   ```

6. Adicione suas mudanças e faça um commig:
   ```bash
   git add cadastroautor.php
   git commit -m 'Adiciona funcionalidade de cadastro de autor'
   ```

7. Envie o push para o repositório remoto:
   ```bash
   git push origin adicionar-autores
   ```

8. Abra um Pull Request para revisão.

## 📝 Licença

Este projeto está licenciado sob a licença MIT - consulte o arquivo [LICENSE](LICENSE) para mais detalhes.
