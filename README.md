
## About Invoice
This is a comprehensive invoice management system for a Gas product 
delivery company.
For installing this project you need follow the steps below.


--1 Open cmd and run 
   git clone https://github.com/bijCode/invoice.git

--2 Copy env.example to env file and make changes to database (according to your configuration)
    # DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=gas_delivery
    # DB_USERNAME=root
    # DB_PASSWORD=

--3 Run following commands in terminal inside project folder
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan serve

--4 got to http://127.0.0.1:8000/invoices/create


You will see the data created by seeding and you can create invoices here a preview and invoice will be saved to db.


