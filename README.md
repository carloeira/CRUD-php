#CRUD DE ESCOLAS

Aplicação web do tipo monolitica criada com:
- PHP ^7.4 para o backend
- HTML, CSS e Javascript para o frontend
- MySQL/MariaDB para o banco de dados

## Funcionalidades
- CRUD de Usuários
- CRUD de Alunos
- CRUD de Professores
- CRUD de Cursos
- CRUD de Categorias

## Passo a passo para rodar o projeto
Certifique-se que seu computador tem os softwares instalados:
- PHP
- MySQL ou MariaDB
- Editor de texto (por exemplo VS code)
- Navegador Web
- Composer (Gerenciar de pacotes do PHP)

#### Clone o projeto
Baixe ou faça o clone do repositorio:
`git clone ...`

Após isso, entre no diretorio que foi gerado:
`cd crud-php-oo`

#### Habilitar as extensões do PHP
Abra o diretório de instalação do PHP, encontre i arquivo *php.ini-production*, renomeie-o oara *php.ini* e abra-o com algum editor de texto.

Encontre as seguintes linhas e descomente-as, removendo o `;` que precede a linha.

- pdo_mysql
- curl
- mb_string
- openssl

#### Instalar as dependencias
Dentro do diretório da aplicação execute no terminal:
`composer install`

Certifique-se que um diretório chamdo **/vendo** foi criado.

### Banco de dados

> O banco de dados é do tipo relacional e contém as tabelas com até 2 níveis de normatização.

#### Criando o cando de dados
Entre no seu cliente de banco de dados, e execute o comando:

```sql
CREATE DATABASE db_escola;
```

#### Migrar a estrutura do banco de dados
Ainda dentro do cliente de banco de dados, copie e cole o conteúdo do arquivo **db.sql** e execute.

Certifique-se que as tabelas foram criadas, executando o comando:

```sql
SHOW TABLES;
```

Se o resultado for a lista de tabelas existentes, está ok para ultilizar.

#### Configure as credenciais de acesso
Encontre o arquivo **/config/databse.php** e edite-o conforme as credenciais do seu usuario de banco de dados.

### Crie o primeiro usuário de acesso
Dentro do diretório da aplicação, execute no terminal o comando:
`php config/create-admin.php`

Isso criará um usuário com as credenciais:
|Nome|Email|Senha|
| -  |  -  |  -  |
| Administrador | admin@admin.com | admin |

### Executando a aplicação
Para executar e testar a aplicação, dentro do terminal execute:
`php -S localhost:8000 -t public`