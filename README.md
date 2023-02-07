### How to run the API's

## Local Setup (Process 1)

Make sure you have PHP and Composer and mysql installed globally on your computer.

Please follow below steps to clone the project from github and run the application!

1. Run `git clone https://github.com/optimusvish/loop-interview-task.git`
2. `cd loop-interview-task`
3. Run `composer install`
4. Run `copy .env.testing .env`
5. Add your own database detail in `.env` file
6. Run `php artisan migrate` (it'll create all the tables required)
    - In case if you get `database` not found error follow these below steps
        - `mysql -uroot -p` Hit Enter it might ask password of your global mysql `useually it'll be empty so hit Enter again`
        - you will be mysql console now so Run `mysql create databse [database_name]` In our case it is `mysql create database api_webshop` and hit Enter
        - Now to verify Run `mysql show databases;` It'll show you all the available databases
        - Now go back to `6th Step`
7. Put your csv files with the following names customers.csv (`loop-interview-task/storage/app/public/customers.csv`), products.csv (`loop-interview-task/storage/app/public/products.csv`) - I have added the CSV files to `postman_collection` folder.
8. Run `php artisan db:seed --class=ProductsSeeder;`, `php artisan db:seed --class=CustomersSeeder;` (It'll insert all the records from csv files)
9. Check the log following log file `loop-interview-task/storage/logs/laravel.log` to see how many records have been inserted.
10. As I am using Passport for API Authentication you need some personal keys in your local so run this command to create personal key and encryption key so run below commands
    - Run `php artisan passport:install`
    - Run `php artisan key:generate`
11. Run `php artisan serve`

## Docker Setup (Process 2) - My Suggestion is to try this

In case the above process doesn't work. Please follow the docker setup process

Setup Details: `Ubuntu 20.04, PHP 8, MySQL 8, Apache2, PHPMyAdmin`

Requirements: `Docker` should be installed in your local system

1. Run ```git clone https://github.com/optimusvish/loop-interview-task.git```
2. ```cd loop-interview-task```
3. Run ```copy .env.testing .env```
4. Run to Build the Docker Images ```docker-compose --file docker-compose.yml build``` 
5. Run to start the Containers ```docker-compose --file docker-compose.yml up -d```
6. 4th Step will create laravel application running with `localhost:8080`, and PHPMyAdmin wirh `localhost:8081`
7. Now we have to do migration of tables and seed the data to tables by following comands ```php artisan migrate``` ```php artisan db:seed --class=ProductsSeeder```, ```php artisan db:seed --class=CustomersSeeder```
8. All is set now you can login db and check whether the data is inserted or not by using following credentials
    - Server `db`
    - Username `root`
    - Password `pwd`

# REST API List

The REST API to this app is described below.

I have also added all the API Collection of Postman Client added under `postman_collection` please import that into postman and you can test the apis directly.

## Register User

### Request

`POST /api/register`
**Method** : `POST`

**Auth required** : No

**Permissions required** : None

**Data constraints**

Provide name, email, password of user to be created.

```json
{
    "name": "[name with minimum 3 letters]",
    "email": "[proper email]",
    "password": "[paasword with min 4 letters]"
}
```

**Data example** All fields must be sent.

```json
{
   "name": "Vishnu",
    "email": "iamvishnu@example.com",
    "password": "1234"
}
```

## Success Response

**Condition** : If everything is OK and an Account didn't exist for this User.

**Code** : `201 CREATED`

**Content**

```json
{"data":{"message":"User registered successfully!!","data":{"name":"Vishnu","email":"iamvishnu2@gmail.com","updated_at":"2023-02-06T10:03:07.000000Z","created_at":"2023-02-06T10:03:07.000000Z","id":4}}}
```

## Login User

### Request

`POST /api/login`
**Method** : `POST`

**Auth required** : No

**Permissions required** : None

**Data constraints**

Provide email, password of user to be created.

```json
{
    "email": "[email]",
    "password": "[paasword]"
}
```

**Data example** All fields must be sent.

```json
{
    "email": "iamvishnu@example.com",
    "password": "1234"
}
```

## Success Response

**Condition** : If everything is OK and account is exist then the response is shown below

**Code** : `200 OK`

**Content**

```json
{
    "token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiMWY4NjFhOTYzZDZmYzY1Yzg4MTBjZGJiYWMwZjEyM2MxMjBmZTI5MWZhNTY5NjBmY2M0ODgwZGY4OGM2Y2QwOTNiN2RjM2Q5ODM0ODUxM2YiLCJpYXQiOjE2NzU2NzgwMjIuNzUxMTkzLCJuYmYiOjE2NzU2NzgwMjIuNzUxMTk2LCJleHAiOjE2NzU2Nzk4MjIuNzQ0Njc4LCJzdWIiOiI1Iiwic2NvcGVzIjpbXX0.r5NhB8oL0-4f4EKrfbVeCXuhMDNR9XE8y2glBHtPbfuIbAsdGFu2E-cEorXotGTqr28OlVs0I0cTTMCH9VQavqFgh9rIF4FVIQKyFYUIqiLXTedOoqDDwnHCDTdQ2jTxPgsIu7GZy5-Z7FVmAzj3pmjlq2mgby3GY2pBT_l8XlNO-MBDyggXAVnpDVhN6e6ILD6XjgmzRl98ljTQGGNfDxPDirLaMpv2ICumgeWpOrrHws5X0KLRZcHd0bSc_359YjBGluDhu2ThA5OrTbup8jnUF9uVOqsYNT_0Q9xE7Y3rVs4ujCWE2HNHM5yfW9AFvUBHlyuq3iFM_Wk-Ti8xVThVKgSK812DZ6a9_nfROMD5WYH6A9w-0jZqGr9fXEfYXcumFA4nWrqUZMsBcc6jkmRKDthPbfpCSnzUTer8amBus3VJhAEur2iLIpmAUgPh3PGoumxRVQFxOJk-z4V0HjYyd3irC2g54lHTf3nq6sHU5osc565hShWyfiQ8YY1ioB9IwAoaRuCcDOPvQC5-EK5JVOpNWoYoFbl0A3lW05KBslVlMz6hOJvxV-AlYY_hdy8sTiT98ZImO-4Ov8UvuAn4LXvCDgXRkVmW4l5WKL1MX-kb2Pw5a0X1S6lUKpSYq67blAcfMymQdVr6Kl3oAp0NsDLgNGGNLeumt20jp8c","token_type":"Bearer",
    "expires_at":"2023-02-06 10:37:02"
}
```

# Show All Users

Show all User List

**URL** : `/api/users/`

**Method** : `GET`

**Auth required** : YES (Bearer Token)

**Permissions required** : None

**Data constraints** : `{}`

## Success Responses

**Condition** : User can not see any Accounts.

**Code** : `200 OK`

**Content** : `{[]}`

**Content** : User list will be shown like below:

```json
{"data":{"message":"Success","data":[{"id":1,"name":"Vishnu","email":"iamvishnu@example.com","email_verified_at":null,"created_at":"2023-02-06T07:10:19.000000Z","updated_at":"2023-02-06T07:10:19.000000Z"},{"id":2,"name":"Kira","email":"iamvishnu_new@gmail.com","email_verified_at":null,"created_at":"2023-02-06T08:09:39.000000Z","updated_at":"2023-02-06T08:09:39.000000Z"},{"id":3,"name":"Kira","email":"iamvishnu1@gmail.com","email_verified_at":null,"created_at":"2023-02-06T08:34:41.000000Z","updated_at":"2023-02-06T08:34:41.000000Z"},{"id":4,"name":"Vishnu","email":"iamvishnu2@gmail.com","email_verified_at":null,"created_at":"2023-02-06T10:03:07.000000Z","updated_at":"2023-02-06T10:03:07.000000Z"},{"id":5,"name":"Vishnu","email":"iamvishnu2@example.com","email_verified_at":null,"created_at":"2023-02-06T10:06:43.000000Z","updated_at":"2023-02-06T10:06:43.000000Z"}]}}
```

# Show All Orders

Show all Order List

**URL** : `/api/orders/`

**Method** : `GET`

**Auth required** : YES (Bearer Token)

**Permissions required** : None

**Data constraints** : `{}`

## Success Responses

**Condition** : User can not see any Accounts.

**Code** : `200 OK`

**Content** : `{[]}`

**Content** : Order list will be shown like below:

```json
{
    "data": {
        "message": "Success",
        "data": [
            {
                "ID": 1,
                "customer_id": 6,
                "product_id": 27,
                "payed": 1,
                "created_at": "2023-02-06T11:22:34.000000Z",
                "updated_at": "2023-02-06T12:28:36.000000Z"
            }
        ]
    }
}
```
## Create Order

### Request

`POST /api/order/add`
**Method** : `POST`

**Auth required** : YES (Token)

**Permissions required** : None

**Data constraints**

Provide product, customer and payed stattus of order to be created.

```json
{
    "product":"[Product Name]",
    "customer":"[Customer Email]",
    "payed":[Payment Status - Boolean]
}
```

**Data example** Except payed all other fields are mandatory

```json
{
    "product":"Lee",
    "customer":"Rylee_Rodwell1134@cispeto.com",
    "payed":true
}
```

## Success Response

**Condition** : If everything is OK and login token is exist then the response is shown below

**Code** : `200 OK`

**Content**

```json
{
    "data": {
        "message": "Order added Successfully!!",
        "data": {
            "customer_id": 6,
            "product_id": 27,
            "payed": 1,
            "updated_at": "2023-02-06T11:22:34.000000Z",
            "created_at": "2023-02-06T11:22:34.000000Z",
            "ID": 1
        }
    }
}
```

## Update Order

### Request

`POST /api/order/{id}/add`
**Method** : `POST`

**Auth required** : YES (Token)

**Permissions required** : None

**Data constraints**

Provide product, customer, payed of order to be updated.

```json
{
    "product":"[Product Name]",
    "customer":"[Customer Email]",
    "payed":[Payment Status - Boolean]
}
```

**Data example** All fields are not mandatory but if exist validation will happen and it'll update only not payed orders

```json
{
    "product":"Calvin Klein",
    "customer":"Rylee_Rodwell1134@cispeto.com"
}
```

## Success Response

**Condition** : If everything is OK and login token is exist then the response is shown below

**Code** : `200 OK`

**Content**

```json
{
    "data": {
        "message": "Order updated Successfully!!",
        "data": {
            "ID": 1,
            "customer_id": 6,
            "product_id": 6,
            "payed": 0,
            "created_at": "2023-02-06T11:22:34.000000Z",
            "updated_at": "2023-02-06T12:48:06.000000Z"
        }
    }
}
```
# Delete Order

Delete Order

**URL** : `/api/order/{id}`

**Method** : `PUT`

**Auth required** : YES (Bearer Token)

**Permissions required** : None

**Data constraints** : `{}`

## Success Responses

**Condition** : User can not see any Accounts.

**Code** : `200 OK`

**Content** : `{[]}`

**Content** : The resonse show below for Delete

```json
{
    "data": {
        "message": "Success",
        "data": "deleted!"
    }
}
```
## Pay Order

### Request

`POST /api/order/{id}/pay`
**Method** : `POST`

**Auth required** : YES (Token)

**Permissions required** : None

**Data constraints**

Provide order_id, customer_email, value to proceed with payment

```json
{
    "order_id":"[Product Name]",
    "customer_email":"[Customer Email]",
    "payment_method":"[Payment Method]",
    "value":[Price of Product]
}
```

**Data example** All fields are not mandatory and if user login exist validation will happen and it'll update the payment

```json
{
    "order_id": 2,
    "customer_email": "Rylee_Rodwell1134@cispeto.com",
    "value": 1,
    "payment_method":"loop-superpay"
}
```

## Success Response

**Condition** : If everything is OK and login token is exist then the response is shown below

**Code** : `200 OK`

**Content**

```json
{
    "data": {
        "message": "Payment Successful",
        "data": {
            "order_id": 2,
            "customer_email": "Rylee_Rodwell1134@cispeto.com",
            "value": 1,
            "payment_method": "loop-superpay"
        }
    }
}
```