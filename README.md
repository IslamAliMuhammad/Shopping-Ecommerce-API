# E-commerce API 
E-commerce API work as a link between company to sell their products and customer to consume company products.

## Description
E-commerce API that allows a company to sell their products within four categories clothing, footwear, watches, and bags on the other hand allows a customer to place orders for company products.  

## API Documentation
Documentation is available at [link](http://137.184.42.173/docs/)

## Getting started

### Prerequisites

* [PHP 8.0](https://www.php.net/releases/8.0/en.php)
* [Docker](https://www.docker.com/products/docker-desktop)

### Installation

1. Clone the repo
    ```sh
    https://github.com/IslamAliMuhammad/e-commerce-api.git
    ```
2. Enter the project folder
    ```sh
    cd e-commerce-api
    ```  
3. Installing dependencies
    ```sh
    composer install
    ```
4. Set the application key
    ```sh
    php artisan key:generate
    ```
5. Run `cp .env.example .env` and set your enviournment variables to .env file
6. Create and start containers 
    ```sh
    sudo ./vendor/bin/sail up
    ``` 
7. Run and seed database migrations 
    ```sh
    sail php artisan migrate --seed
    ```

### Testing

* Create dummy data for your database 

    ```sh
    sail php artisan db:seed --class TestSeeder
    ```

#### Postman collection
Postman collection is available at the root folder under the name [e-commerce.postman_collection.json](e-commerce.postman_collection.json)

## License
[MIT](https://choosealicense.com/licenses/mit/)