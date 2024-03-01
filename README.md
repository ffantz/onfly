# Teste técnico - Onfly

>  This is a challenge by [Coodesh](https://coodesh.com/)

## Introdução

Este é o repositório contendo a aplicação de teste da Onfly, visando demonstrar a tomada de decisões arquiteturais acerca de um projeto de crud simples, incluindo segurança, validação de dados, testes, etc.

## Tecnologias utilizadas:

O projeto conta com a linguagem PHP e o framework Laravel, em suas versões mais atuais.
Para o funcionamento total, conta com os serviços MySQL e Redis.
O projeto está 100% em containers do Docker, facilitando a configuração e testes em qualquer máquina.

## Instalação e configuração do projeto:

1. Faça o clone do projeto
2. Caso não possua, instale e configure a ferramenta Docker e Docker Compose [aqui](https://docs.docker.com/get-docker/)
3. Abra um terminal dentro da pasta do projeto e rode o comando ```make setup```
4. Teste e navegue pela aplicação

## Observações e comandos úteis para testes:

- O comando de setup do Makefile irá criar automaticamente o banco de dados com um usuário específico para a aplicação, com suas credenciais explicitadas no arquivo .env.example caso necessário.
- A porta declarada no container para o banco de dados é a 3307, para evitar que o container não suba por conflito do serviço MySQL local do usuário que for testar - ponto de prevenção.
- As migrations e seeders são rodadas automaticamente no mesmo comando de setup. São criados 10 usuários aleatórios e um com meu nome e um email "pessoal", com uma senha inicial para testar:
    - Login (email: flavio@mail.com; password: 123456)
    - Cadastro e atualização de registros
    - Busca das informações
    - Testes de restrição quanto a dados de outros usuários
- Por fim, existe uma seeder para criar uma despesa para cada usuário, para que seja possível testar as restrições de acesso e manipulação de dados terceiros.

## Comandos e rotas úteis:
- Para rodar os testes unitários, acesse o container Docker da aplicação com o comando ```docker exec -it onfly_app bash```
- Dentro do container, rodar o comando ```php artisan test```
- A aplicação contém as rotas:
    - ```POST /api/login```: loga no sistema
    - ```GET /api/```: busca os dados do usuário logado, com todas as suas despesas, através das relations de model
    - ```RESOURCE /api/expense```: CRUD completo de despesa
- Todas as rotas com exceção da rota de login são protegidas por autenticação.

## Detalhes de implementações e tomadas de decisões:
- O projeto está 100% dockerizado pela principal motivação de facilidade de configuração, onde eu mesmo codei em uma máquina 100% nova e sem nenhuma ferramenta previamente instalada.
- O envio de email foi configurado em uma conta pessoal no aplicativo Mailtrap, responsável por simular ambientes de envio de email. Para testar, sugerido trocar no arquivo .env da aplicação as credenciais de algum servidor ou conta Mailtrap válida
- O roteamento de rotas direciona para um Controller, onde existe a validação de permissão de ação via Policy e validação dos dados da requisição em um Form Request customizado, sempre em arquivos com o nome da entidade + tipo de arquivo. As ações de regra de negócio são todas direcionadas para uma camada de BO e somente essa camada é capaz de interagir com a camada de Repository, que por sua vez acessa o banco de dados. Somente a camada de Repository manipula diretamente uma Model.
- A camada de BO ainda conta com uma camada de trait, responsável por filtrar os dados do request antes de persistir no banco de dados. Isso cria uma camada de segurança adicional e previne erros, evitando que dados inexistentes ou nulos sejam inseridos, bem como campos inexistentes sejam acessados.
- A aplicação e as entidades foram todas feitas em ingles por padronização, com comentários em portugues em alguns pontos importantes.
- A tratativa dos dados de retorno na camada de Resource foi interpretada como uma maneira de devolutiva da aplicação com dados legíveis em portugues, devolvendo todos os dados formatados de forma humana e com campos traduzidos. A decisão foi tomada para exemplificar um uso puramente informativo. Para reaproveitar as rotas possibilitando outras interações com a API, seriam devolvidos os dados de forma original.
- O único recurso externo ao framework utilizado foi a biblioteca Predis, manipuladora do Redis para testar um formato diferente de filas. Todas as outras ferramentas utilizadas são da própria aplicação.

- Sugestão ao testar as rotas: incluir cabeçalho "Accept" com "application/json" para melhor visualização das validações e travas.