### Para executar o projeto vá na raiz do projeto

Doocumentação da API: https://documenter.getpostman.com/view/5633534/2sAXxP9Y9E

O arquivo `collection_Desafio_Vox.postman_collection` pode ser importado no postman para testes.



__Obs__.: É necessário ter um __NodeJS__, __Docker__ e __PHP__ instalados. Para confirma se estão instalados vá no termninal e execute
```
php -v #PHP 8.1.30
..
node -v #v20.18.0

docker -v # Docker version 24.0.7
```

1. Acessse a pasta `backend` e rode o comando. Irá subir o docker com uma instância do Postgres, subi o servidor PHP e executar as migrations.
```
cd backend
composer run-server
```

2. Na pasta `frontend` execute o seguinte comando para subir o servidor NodeJS.
```
cd ../frontend
npm run start
```