
## Focus project

Installation

- Clone project
- Composer update
- Composer install
- Create DB
- Update .env



Configuration Laravel

- php artisan migrate:fresh --seed
- php artisan population:create (to get data)
- php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
- php artisan l5-swagger:generate
- Add Variable L5_SWAGGER_CONST_HOST=http://project.test/api/v1 in .env



Api documentation url http://urlproject/api/documentation
