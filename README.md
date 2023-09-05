# Teste Técnico Datum

## Requisitos
- Docker
- Docker Compose

## Instalação
Rodar os comandos

Clonar o projeto
```git@github.com:aquilahenrique/datum.git```

Baixar as imagens e rodar os containers 
```docker-compose up -d```

Instalar as dependencias 
```docker-compose exec php-fpm composer install```

Criar as migrations 
```docker-compose exec php-fpm ./bin/console doc:mig:mig --quiet```

## Testar a aplicação

> Rota que calcula o hash
> 
> [http://localhost:13000/generate-hash/Datum](http://localhost:13000/generate-hash/Datum)


> Rota de listagem sem parâmetros
> 
> [http://localhost:13000/](http://localhost:13000/)

> Rota de listagem com parâmetros
> 
> [http://localhost:13000/?perPage=3&page=1&filters[tries]=100000](http://localhost:13000/?perPage=3&page=1&filters[tries]=100000)

> Comando que salva os hashs calculados
> 
> ```docker-compose exec php-fpm ./bin/console avato:test Datum --requests=10```
