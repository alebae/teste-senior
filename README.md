# Teste - Alexandre Feustel Baehr

## Introdução

Teste para a Senior Sistemas. 

Tecnologias utilizadas:

- PHP 7
- Zend Framework 3
- MySQL
- HTML, CSS, JQuery

## Para iniciar a aplicação
Baixe do GIT os fontes do repositório.

Execute a instalação do Composer
```bash
$ composer install
```

Importe o arquivo teste-senior.sql na raíz do projeto e execute no MySQL.

Altere a linha 21 do arquivo /config/autoload/global.php
```bash
'dsn'    => 'mysql:dbname=teste_senior;host:127.0.0.1'
```
Para o servidor de banco de dados disponível.

Altere a partir da linha 52 do arquivo /module/Venda/config/module.config.php
```bash
'driver' => 'Pdo_Mysql',
    	'database' => 'teste_senior',
    	'username' => 'root',
    	'password' => 'ycUSvR6RCL^b',
    	'hostname' => ''
```
Para o servidor de banco de dados disponível.


Na linha de comando execute a operação abaixo:

```bash
$ php -S localhost:8080 -t public public/index.php
```

Link para totalizadores: __http://localhost:8080/venda__ para abrir o Dashboard com os totalizadores

Link para inclusão de produto: __http://localhost:8080/venda/produto__ para abrir realizar incluir um produto

Link para realização de venda: __http://localhost:8080/venda/carrinho__ para abrir realizar uma venda