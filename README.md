# BankApp (Chessable Challenge)

This is the code for the challenge proposed by Olga Karatsoli to Alberto Gorostiaga.

# Challenge

Extracted from the email:

> You should write a simple banking app. There should be bank branches with locations and customers. Each customer should have a name and a balance. The functional requirements are as follows:
>
> 1. It should be possible to add new branches.
> 2. It should be possible to add new customers with a starting balance.
> 3. It should be possible to transfer a sum of money between any two customers.
> 4. It should be possible to run the following two reports:
> 
>     a) Show all branches along with the highest balance at each branch. A branch with no customers should show 0 as the highest balance.
> 
>     b) List just those branches that have more than two customers with a balance over 50,000.

I would like to comment that I wasn't sure about the correct approach for the point 4.b. I was wondering if it means:

    * List just those branches that have more than two (having each customer a balance over 50,000).
      In that case, I may not list a branch having 3 customers if one of them doesn't have more than 50,000*
    
Or:

    * List just those branches that have more than two customers (with a balance over 50,000).
      In this case, the sentence in parentheses would reffer to the branch the customers belongs to, in this situation, if the summatory of the customers of this branch (assuming there are more than 2) exceeds the 50,000... we may list that branch.
      
I guess that the correct one is the first approach, but just in case, i made both.

# Requirements

If you want to install it in your local server (using XAMPP, WAMP, LAMP, MAMP...), you will need them to have at least this minimum version of:

- PHP-7.4
- MySQL-5.7

If you will use docker, then you only need to install docker.

You will also need to have git "https://git-scm.com/downloads" for both cases and composer "https://getcomposer.org/" (is recommendable to have composer installed globally...if not, you can always run "php composer.phar" instead of "composer" keeping in mind that you need to be in the same path your file composer.phar is located if yu want to use the first method).

# Installation

The first step is the same for both situations. We need to download the code from git:

- Using you terminal, go to the public folder of your local server (it depends of the package you are using and your OS, but probably will be on **C:/XAMPP/htdocs/** or **/var/www/** or **/Applications/XAMPP/htdocs/**) Download the code from git:

>     git clone https://github.com/toriyama2012/bank.git

#### As far as we have two different ways of install it, let's start for the local server way first. The steps will be:

- We start our Apache/Nginx and our MySQL/MariaDB services.
- We may enter into the browser and visit "http://localhost/phpmyadmin" (of course, you can log from the terminal with "mysql -h localhost -u my_user -p" and do everything using queries but I will assume that you already have phpMyAdmin installed) and create a new database named "bank".
- Check the files ".env" and "/config/database.php" and edit their database access (I let the .env I used in git instead of using the .gitignore for avoiding the step of copying the .env.example file and set the propper pararms...but as far as i don't know your local credentials, I need you to update those fields. And as far as we are using the localhost, I will ask you to change the line "DB_HOST=174.21.0.9" in ".env" to "DB_HOST=127.0.0.1" and the connections.mysql.host param from "'host' => env('DB_HOST', '174.21.0.9')," to "'host' => env('DB_HOST', '127.0.0.1')," in the "/config/database.php" file.
- Here you can check the app launching the test if you want (I will explain this later).
- Now you can prepare your app to run...first we need to migrate (this will generate the tables in our DB). Use the command "php artisan migrate" from your terminal been in the root project's folder.
- Once you have your DB ready, is the time to fill it with some fake data which will help us to use our app easily. For this, you may launch the commands "php artisan db:seed --class=UserSeeder" in order to create the user we will use to access to our app (The user is "test@chessable.com" and the password is "chessable123"...I know is not the safest one :P) and "php artisan db:seed" for fill some branches and customers into the DB (feel free modify the file "/database/seeders/DatabaseSeeder.php" for generate more branches or customers).
- Now your app is ready to work so we will launch the command "php artisan serve" and go to the propposed url using the browser (I guess it will be "http://127.0.0.1:8000"). You should see now the login where you can set the user I told you before.*

#### The second way is using docker. Those are the steps to follow:

- Check the files "Dockerfile" and "docker-compose.yml" in the root folder. Those files will allow you to generate the 2 described containers you can see in the docker-compose.yml file ("bank_bank" and "mysql:5.7")...the first one will be the app linked by a volumen (this means that we will have a copy of our current directory in the container) and the second one will be the DB, wich it also be linked by a volume, but in this case will not point our current DB folder, instead it will create a "data" folder in the current directory in order to locate the DB files we will link to the DB container. in order to generate those containers we will launch "docker-compose up -d".

- Once the installer ends, we may launch the command "docker ps" and we will see our created containers. As you can see, there are a "CONTAINER ID" and a "IMAGE" headers in the table...find the row which has "bank_bank" in the "IMAGE" column and check the "CONTAINER ID" value. With this containserID value you can enter into you container and work like you do in your current terminal using a XAMPP, MAMP or even if you installed PHP, MySQL and apache separatedly. For get into the container launch the command "docker exec -it XXXX /bin/bash" where XXXX are the first (you dont need to write the full containerID number, just the first 2, 3 or 4 characters...if we have a containerId like "10c348f9db45" we can write "docker exec -it 10 /bin/bash" or "docker exec -it 10c /bin/bash").

- Like you are know in the public folder "/var/www/html/" you will need to go to "/var/www/" which is your code located, so launch "cd ..". Now you can launch the tests or follow the last 3 points of the local server installation described before. In the same way, once you launch "php artisan serve", the container will propose you an url to visit with your browser (probably "http://127.0.0.1:8000") but remember that this is the inner container port, and if you check again your docker-composer.yml file, we bind the internal port to the external 8200 port, so we will need to visit "http://127.0.0.1:8200" in your browser to see the app.

# Testing

As far as i had not so much time to develop this app (I was working and I had to attend some personal issues). I have only created two tests (a feature test and a unit test) as examples of each one.

The first one is located in "/tests/Unit/TransferTest.php" and it will cover those cases:

- test_transfer_ok 
- test_transfer_wrong
- test_transfer_customer_cant_transfer_itself

As you can see, they are all covering useCases for the transfersStore method from the TransferController.

The second one is located in "/test/Feature/RoutingTest.php" and covers the existence of the "get" routes of my app and if they are reachable or not depending on the user authentication.

There are some others tests (example tests that came with the app, the tests that some composer dependencies as Jetstream+livewire -in case you want to learn more about it check https://jetstream.laravel.com/2.x/introduction.html - added to cover their useCases and so on), but as far as I guess you want to check mines, you can launch those commands:

- "./vendor/bin/phpunit --filter TransferTest tests/Unit/TransferTest.php" for testing the unit test.
- "./vendor/bin/phpunit --filter RoutingTest tests/Feature/RoutingTest.php" for testing the feature test.

# Possible Improvements

There are a lot of things I would like to add:

- Add more tests for covering the full app (Actually i would like to use TDD but as far as I didn't have so much time, I choosed to avoid a complete testing coverage)
- A Toast systems for improving the UI/UX...and also Improving the look and feel of the app in general)
- Increase the ajax use (i only used to validate a transfer in the transfers.index.blade.php view) for having a more reactive web (and maybe use React, Vue or Angular)
- Multilanguage
- Allow the user to download the reports in different formats (docx, odt, pdf, xlsx, csv...)
- Improve the factory to fake the names with current and old world champions as Carlsen, Kasparov, Tal, Fischer or Lasker as i did with the provinces in the BranchFactory
- There are some other improvements I though and now I can't remember (so I guess they are minor issues)

# One more thing

I hope you don't have any troubles testing the app, but if you do, you can contact me in **agorostiaga2012@gmail.com**. Thanks for your time and attention. Regards! :)
