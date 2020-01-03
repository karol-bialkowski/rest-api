# Example rest api app

This is an example app based on Symfony 4.4. All requests to change/update/create/listing are according to CQRS commands and structure simply based on DDD. Scripts are written on TDD with the following SOLID rules. 

# Features
  - Endpoints to listing, create, update, delete **products**. Cart entity is planned at todo tasks.
  - Run app by one docker-compose command
  - Support xdebug, phpunit, opcache
  - latest **PHP 7.4** with :heart: typed properties
  - **data fixtures** to purge and insert fresh products ( for more, read below )

# Todo
 - [ ] Cart entity ( add cart, assign and remove products, listing )
 - [ ] Swagger api documentation
 - [ ] Redux components to font-end app
 - [ ] Refactor App.js to different scripts, DRY
 - [ ] JWT auth
 - [ ] git hooks
 - [ ] support string price and parse to <int>

# Run

Clone repository to empty directory:
`git clone https://github.com/karol-bialkowski/rest-api.git .`

Make sure if your docker service is running:
`sudo service docker status`
If in the response you can see `active: (running)` all is okay. If no - try run/restart:
`sudo service docker start/restart`

Go to the directory of repository and run:
`docker-compose build` and next `docker-compose up -d`. 


**If docker-command not work, try to add docker group to sudo, or run with sudo permissions*

Run migrations:
`docker-compose exec php php bin/console doctrine:schema:update --force`

Run fixtures:
`docker-compose exec php php bin/console doctrine:fixtures:load`

Make sure if in you .env file is declared:
`DATABASE_URL=mysql://root:root@mysql:3306/sf4?serverVersion=5.7`

Run `docker-compose exec composer install` or `docker-compose exec composer install --no-dev` if you don`t want dev dependencies. 

And if all before commands work correctly, visit http://127.0.0.1. 


*Added:*
I set `SYMFONY_DEPRECATIONS_HELPER=disabled` because now in Symfony 4.4 Doctrine has some deprecations and you can see many warnings in this doctrine version.  


# API endpoints

If you use PhpStorm ( or different IDE with support .http files ) you can see **/example-requests** directory and show example requests. All endpoints are declared on *src/Shop/Infrastructure/Resources/routes/product.yaml* and return JSON. If you use this api, verify HTTP CODES ( 200 is ok, 404 not found, 400 etc ).


**LISTING**
GET http://127.0.0.1/products?page=1

Parameter *page* is not required. If not provided, the default value is 1 ( first page ). 
This endpoint listing all added products per 3 products per page.

Example response:
```
200 HTTP CODE
{
  "message": "",
  "payload": {
    "products": [
      {
        "uuid": "014763cd-4f37-468b-9c8c-3336eb2f85a9",
        "title": "Bloodborne",
        "price": {
          "cents": "599",
          "format": {
            "usd": "$5.99"
          }
        }
      },
      {
        "uuid": "4d18f2f6-87ce-47ce-8714-cce4f55e4b71",
        "title": "Icewind Dale",
        "price": {
          "cents": "499",
          "format": {
            "usd": "$4.99"
          }
        }
      },
      {
        "uuid": "de9e5310-343c-41bb-a236-48d4c68508d0",
        "title": "Baldur’s Gate",
        "price": {
          "cents": "399",
          "format": {
            "usd": "$3.99"
          }
        }
      }
    ],
    "paginator": {
      "currentPageNumber": 4,
      "totalPages": 5,
      "nextPage": 5,
      "prevPage": 3
    }
  }
}
```


**CREATE**
POST http://127.0.0.1/products
and send json with params:
- title <string>
-- from 1 to 100 chars, **title should be unique!**
- price <int>
-- from 1 to 2147483647. If you want to declare $2.45, declare `(int)245`. Planned this refactor ( and allow send parsed string )

Example request:
```
POST http://127.0.0.1/products
Accept: application/json
Cache-Control: no-cache
Content-Type: application/json

{"title":"Another product--","price":"556"}
```

Example responses:
```
200 HTTP CODE
{
  "message": "Product has been created",
  "payload": {
    "uuid": "90ff02d1-7d36-49f2-adfa-41075a55b184",
    "title": "Another product--",
    "price": "556"
  }
}
```
```
//400 HTTP CODE
{
  "message": "Product title must be a unique value, given: Another product--. Found product with uuid: 90ff02d1-7d36-49f2-adfa-41075a55b184",
  "payload": null
}
```

**UPDATE**
PUT http://127.0.0.1/products/{uuid}
*uuid* is id to update product. Required. This endpoint require also post data as json with fields:
- title
- price

You should declare at least one param - so, if you want to update only title - send only title. If you want update title and price - send price and title. Below some example requests:

```
PUT http://127.0.0.1/products/2ba49e68-8a3e-406d-91ca-548753017df0
Accept: application/json
Cache-Control: no-cache
Content-Type: application/json

{"title":"Another product ##"}
### OR ###
{"price":"11"}
### OR ### 
{"price":"11", "title": "New name"}
```

Example response:
```
404 HTTP CODE
{
  "message": "Not found product with uuid: 2ba49e68-8a3e-406d-91ca-548753017df0",
  "payload": null
}
```
```
200 HTPP CODE
{
  "message": "Product updated.",
  "payload": {
    "uuid": "35208bec-33b6-4fcd-8a1b-8b6c5d9ca1af",
    "title": "Another product ##",
    "price": "556"
  }
}
```
On the payload you will receive product details **after** update.


**DELETE**
DELETE http://127.0.0.1/products/{uuid}
*uuid* is id product to delete. 

Example request: 
```
DELETE http://127.0.0.1/products/2ba49e68-8a3e-406d-91ca-548753017df0
Accept: application/json
Cache-Control: no-cache
Content-Type: application/json
```

Example responses:

```
404 HTTP CODE
{
  "message": "Not found product with uuid: 2ba49e68-8a3e-406d-91ca-548753017df0",
  "payload": null
}
```
```
200 HTTP CODE
{
  "message": "Product with uuid: 7b91dd9f-f444-4f86-9a21-93d36058571c has been removed.",
  "payload": null
}
```



 
Powered by Karol Bialkowski. E-mail: spam@bialkowskikarol.pl