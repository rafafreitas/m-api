# M-API
> Sistema de controle de transações.

API que gerencia uma aplicação que permita que os usuários adicionem transações de entradas e saídas. 
Sendo possível realizar as consultas necessárias para validar as transações.

1. Slim-Framework v4.4.0
2. Doctrine/ORM v2.7
3. JWT - Firebase/php v5.0.0
4. PhpMailer v6.0

## Instalação e uso

Instalação de bibliotecas:  
```sh
// Irá atualizar as dependências automaticamente
composer install
```

Validação do schema local
```sh
vendor/bin/doctrine orm:validate-schema
```

Criação do banco de dados localmente:<br>
Obs: Alterar os dados do banco no construtor do arquivo Credentials.php em src/Config/Credentials.php:23
```sh
vendor/bin/doctrine orm:schema-tool:create
```

Capturar o SQL antes do Update:<br>
```sh
vendor/bin/doctrine orm:schema-tool:update --dump-sql
```

Update do banco de dados localmente:<br>
```sh
vendor/bin/doctrine orm:schema-tool:update --force
```

Caso não tenha o Composer instalado em seu computador:

```sh
https://getcomposer.org
```

## Histórias de Lançamento

* 0.01 - (18/02/2020)
    * Implementação: Sistema implementado na sua versão inicial.


## Dev

Rafael Freitas – [GitHub](https://github.com/rafafreitas/) – rafael.vasconcelos@outlook.com  

Consulte a ``LICENÇA`` para mais informações.

## Contribuição

1. Fork it (<https://github.com/rafafreitas/m-api>)
2. Crie sua feature branch (`git checkout -b feature/fooBar`)
3. Commit suas mudanças (`git commit -am 'Adicione as mudanças'`)
4. Faça o Push para a branch (`git push origin feature/branch`)
5. Crie um new Pull Request


