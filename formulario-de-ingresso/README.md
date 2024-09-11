# Exercício: Formulário de Ingresso e Descontos

Este exercício consiste em construir uma página web com funcionalidades específicas e redirecionar o usuário para uma página de resultados baseada nas informações fornecidas. Abaixo estão os requisitos e detalhes para a implementação.

## Requisitos do Projeto

### 1. Página `inicio.php`

1. **Formulário de Cadastro**
   - **Nome**: Adicione um campo para o usuário digitar seu nome.
   - **Time**: Inclua um componente `select` para o usuário escolher seu time dentre as opções disponíveis.
   
2. **Radio Buttons para Sexo**
   - Inclua opções de radio button para o usuário informar seu sexo (Masculino ou Feminino).

3. **Checkboxes**
   - **É sócio-torcedor?**
   - **Foi a algum estádio nos últimos 3 meses?**
   - **Seu time ganhou?**

4. **Redirecionamento**
   - Após o envio do formulário, redirecione o usuário para a página `resultado.php`.

### 2. Página `resultado.php`

1. **Cálculo do Valor do Ingresso**
   - O valor inicial do ingresso é de R$ 120,00.
   - Realize as seguintes validações e cálculos de desconto:
     - Se o usuário tiver menos de 18 anos, aplique um desconto de 30%.
     - Se o usuário for do sexo feminino, aplique um desconto de 20%.
     - Se o usuário for sócio-torcedor, aplique um desconto de 5%.
     - Se o usuário foi ao estádio nos últimos 3 meses, aplique um desconto de 5%.
     - Se o time ganhou, aplique um desconto de 2%.
   - Os descontos devem ser cumulativos.

2. **Exibição dos Dados**
   - Mostre as informações fornecidas no formulário.
   - Exiba o valor final do ingresso após aplicar os descontos.

## 📋 Instruções

1. **Clone o Repositório**
   ```bash
   git clone https://github.com/alessandro0augusto0/formulario-de-ingresso.git
   ```

## 🚀 Como Navegar

1. **Navegue até o Diretório do Projeto**
   ```bash
   cd formulario-de-ingresso
   ```

2. **Abra a Página `inicio.php`**
   - Utilize um servidor local (como XAMPP ou WAMP) para visualizar a página `inicio.php`.

3. **Preencha o Formulário**
   - Preencha o formulário com as informações solicitadas e envie.

4. **Verifique os Resultados**
   - O redirecionamento levará você para a página `resultado.php`, onde serão exibidas as informações e o valor final do ingresso.

## 🛠 Tecnologias Utilizadas

- **HTML**: Para a estruturação do formulário.
- **CSS**: Para a estilização das páginas.
- **PHP**: Para processamento dos dados do formulário e cálculo dos descontos.

## 📄 Licença

Este exercício foi desenvolvido como parte de um curso e está disponível para fins educacionais. Sinta-se à vontade para explorar e modificar conforme necessário.
