#![logo-slogan](https://user-images.githubusercontent.com/15237067/150875257-3b534f91-76f3-4cf2-b929-63bd6d844e4b.png)

## Introduction
**CRM** (Customer Relationship Management) focused mainly on computer equipment repair businesses. It consists of an administration panel where the entire system can be managed (users, repairs, statuses, customers, products and categories), and a page where customers can check the status of the repair(s) by entering the tracking code generated.

## Usage
### Requirements or tested versions:
- PHP 7.4.5
- Symfony 5.3
- Composer 2.2.5
- Node 16.14.0
- NPM 8.3.1

### Follow the next steps:
1. Install composer 
>``composer install``
2. Install NPM 
>``npm install``
3. Configure the database connection in the file ***.env*** or ***.env.local***
4. Create the database
>``php bin/console doctrine:database:create``
5. Run migrations
>``php bin/console doctrine:migrations:migrate``
6. [**OPTIONAL**] Load the demo data
>``php bin/console doctrine:fixtures:load``
7. Run NPM in dev environment
>``npm run dev``
8. Run your server or run ``symfony serve`` if you have [Symfony](https://symfony.com/doc/current/setup/symfony_server.html#installation) installed
9. Open your browser and enter **localhost:8000** or **localhost:8000/login** (or custom port)

If you have loaded the demo data from step 6, you can access using the username "**admin**" and password "**asdf,1234**"




