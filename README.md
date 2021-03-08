
<p align="center">
    <h2 align="center">Projeto Api</h2>
    <br>
</p>

## Framework
Vou utilzar a mesma esplicação que utilizei no meu TCC XD.
Foi utilizado o framework YII2 para a construção da API REST. Os modelos utilizados são Active Records.

> O Active Record fornece uma interface orientada a objetos para acessar
> e manipular dados armazenados em bancos de dados. Uma classe Active
> Record está associada a uma tabela da base de dados, uma instância do
> Active Record corresponde a uma linha desta tabela, e um atributo
> desta instância representa o valor de uma coluna desta linha. Em vez
> de escrever instruções SQL a mão, você pode acessar os atributos do
> Active Record e chamar os métodos do Active Record para acessar e
> manipular os dados armazenados nas tabelas do banco de dados (YII,
> acesso em outubro de 2018).

  
Estrutura de Diretorios
-------------------
Temos a estrutura basica do YII2 e eu vou dar uma explicada rapida em cada diretorio.<br>
.docker/ <br>
nesse diretorio ficam os arquivos referentes ao docker, tera uma sessao para explicar sobre o uso do docker nesse projeto.<br>
commands/ <br>
diretorios referentes ao comandos, geralmente algo que sera executado pelo cron similar aos jobs do laravel<br>
config/ <br>
diretorio com os aquivos referentes as configuracoes do framework, um arquivo em especifico o web.php contem todas as configuracoes mais as rotas das apis.<br>
controllers/ <br>
diretorio com as classes referentes aos controllers<br>
documentacao/ <br>
diretorio com arquivos referente a documentacao do sistema.<br>
migrations/ <br>
diretorio com as classes de migrations, para versionamento do banco em codigo.<br>
models/ <br>
diretorio com as classes referentes aos modelos.<br>
modules/ <br>
diretorio com os modules, cada modulo possui seus diretorios de models e controllers <br>
tests/ <br>
diretorio para as classes de testes<br>
web/ <br>
diretorio similar ao public do laravel, onde fica o apontamento e carrega as classes do framework.<br>


Estrutura do Projeto
-------------------
#### Modelo Relacional
![](documentacao/modelo_relacional.png)
##### Todos os modelos nos 3 modulos semguem as tabelas pois todos sao active records
#### Foi criado 3 modulos de api
##### chamadas / 
 usa a estrutura padrao do Yii2 tendo seus modelos em models e seus controles em controllers, a configuracao de roteamento esta em config/web.php na linha 46 toda a parte de urlManager é referente ao roteamento, essa api nao utiliza nenhum padrao de autenticação e seguranca, toda a transaction é realisada por transaction de banco de dados quando ocorre algum erro é realizado um rollback para desfazer todas as operacoes assim não guardando nenhuma informacao

#### chamadas /security/
Nessa api existe autenticacao via JWT outras implementacoes por exemplo o usuario só consegue ver sua propria wallet, e só consegue ver os valores de transactions que ele participou. possui o mesmo esquema de transaction de banco de dados

#### chamadas /nodbt/
Nao possui autenticacao e a reversao ao ocorrer algum tipo de erro é realizada sem transaction de banco de dados.

documentação completa da api
[https://documenter.getpostman.com/view/1908250/Tz5m6ygv](https://documenter.getpostman.com/view/1908250/Tz5m6ygv)

Estrutura Docker
---------------------
O docker-compose foi separado em 3 containers diferentes um container para a api, um para o mysql e o ultimo com o adminer para acessar o banco com mais facilidade.
existe um .env com as configuracoes necessarias para rodar o docker-compose.
os arquivos referentes ao docker ficam no diretorio .docker/
o mesmo possui 3 diretorios mais um arquivo de comando.
diretorio app/ possui arquivos que seram subistituidos no yii2 sempre que rodar um compose up e possui o dockerfile com a configuracao docker da api.
foi utilizado o dockerize para fazer essas subistituicoes.
o diretorio dbdata é o responsavel peloas arquivos de banco
o diretorio httpd é aonde ficam as configuracoes do apache que o container da api utiliza
e o arquivo entrypoint.sh é o entrypoint do container da api o mesmo instala os arquivos do compose caso não nao esteja instalado.

O que é necessario para rodar ?
---------------------

 1. Baixar o projeto
 2. Copiar o .env.example para um .env
 3. Rodar o docker-compose up ( o mesmo ja ira instalar as dependencias do yii2 e rodar as migrations)
 4. Pronto já pode realizar os testes :D
