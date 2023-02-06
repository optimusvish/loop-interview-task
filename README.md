### How to run the API

Make sure you have PHP and Composer and mysql installed globally on your computer.

Please follow below steps to clone the project from github and run the application!

1. Run `git clone https://github.com/optimusvish/loop-interview-task.git`
2. cd loop-interview-task
3. Run composer install
4. Run cp .env.example .env or copy .env.example .env
5. Add your own database detail in .env file
6. Run php artisan migrate (it'll create all the tables required)
7. Put your csv files with the following names customers.csv (loop-interview-task/storage/app/public/customers.csv), products.csv (loop-interview-task/storage/app/public/products.csv)
8. Run php artisan db:seed --class=CustomersSeeder, ProductsSeeder; (It'll insert all the records from csv files)
9. Check the log following log file loop-interview-task/storage/logs/laravel.log to see how many records have been inserted.
10. Run php artisan serve

# REST API

The REST API to this app is described below.

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
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIzIiwianRpIjoiMWY4NjFhOTYzZDZmYzY1Yzg4MTBjZGJiYWMwZjEyM2MxMjBmZTI5MWZhNTY5NjBmY2M0ODgwZGY4OGM2Y2QwOTNiN2RjM2Q5ODM0ODUxM2YiLCJpYXQiOjE2NzU2NzgwMjIuNzUxMTkzLCJuYmYiOjE2NzU2NzgwMjIuNzUxMTk2LCJleHAiOjE2NzU2Nzk4MjIuNzQ0Njc4LCJzdWIiOiI1Iiwic2NvcGVzIjpbXX0.r5NhB8oL0-4f4EKrfbVeCXuhMDNR9XE8y2glBHtPbfuIbAsdGFu2E-cEorXotGTqr28OlVs0I0cTTMCH9VQavqFgh9rIF4FVIQKyFYUIqiLXTedOoqDDwnHCDTdQ2jTxPgsIu7GZy5-Z7FVmAzj3pmjlq2mgby3GY2pBT_l8XlNO-MBDyggXAVnpDVhN6e6ILD6XjgmzRl98ljTQGGNfDxPDirLaMpv2ICumgeWpOrrHws5X0KLRZcHd0bSc_359YjBGluDhu2ThA5OrTbup8jnUF9uVOqsYNT_0Q9xE7Y3rVs4ujCWE2HNHM5yfW9AFvUBHlyuq3iFM_Wk-Ti8xVThVKgSK812DZ6a9_nfROMD5WYH6A9w-0jZqGr9fXEfYXcumFA4nWrqUZMsBcc6jkmRKDthPbfpCSnzUTer8amBus3VJhAEur2iLIpmAUgPh3PGoumxRVQFxOJk-z4V0HjYyd3irC2g54lHTf3nq6sHU5osc565hShWyfiQ8YY1ioB9IwAoaRuCcDOPvQC5-EK5JVOpNWoYoFbl0A3lW05KBslVlMz6hOJvxV-AlYY_hdy8sTiT98ZImO-4Ov8UvuAn4LXvCDgXRkVmW4l5WKL1MX-kb2Pw5a0X1S6lUKpSYq67blAcfMymQdVr6Kl3oAp0NsDLgNGGNLeumt20jp8c","token_type":"Bearer","expires_at":"2023-02-06 10:37:02"}
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