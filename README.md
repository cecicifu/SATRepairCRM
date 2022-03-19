![logo-slogan](https://user-images.githubusercontent.com/15237067/150875257-3b534f91-76f3-4cf2-b929-63bd6d844e4b.png)

## Introduction
**CRM** (Customer Relationship Management) focused mainly on computer equipment repair businesses. It consists of an administration panel where the entire system can be managed (users, repairs, statuses, customers, products and categories), and a page where customers can check the status of the repair(s) by entering the tracking code generated.

## Usage
### Requirements & tested versions:
- PHP 7.4.5
- Node 16.14.0
- NPM 8.3.1

### Installation:
1. Install Composer packages
```sh
composer install
```
2. Install NPM packages
```sh
npm install
```
3. Configure the database connection in the file ***.env*** or ***.env.local***
4. Create the database
```sh
php bin/console doctrine:database:create
```
5. Run database migrations
```sh
php bin/console doctrine:migrations:migrate
```
6. Run build for dev environment
```sh
npm run dev
```
7. Run your own server or if you have [Symfony CLI](https://symfony.com/doc/current/setup/symfony_server.html#installation) installed, just run:
```sh
symfony serve
```
8. Open your browser and enter **localhost:8000** or **localhost:8000/login** (could be other port, you should check it out)
9. Enjoy it! 😊

### Load demo data
Run the next command:
```sh
php bin/console doctrine:fixtures:load
```

With the demo data loaded you can access using:
- Username: **admin**
- Password: **asdf,1234**

If not, you will have to create the user manually in the database.




