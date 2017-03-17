# Dynamic DNS
Dynamic DNS is a self hosted web application for dynamic DNS, built entirely with [laravel](https://laravel.com/) and [bootstrap](https://getbootstrap.com/)
With a simple clean UI and easy setup, it makes dynamic DNS a breeze. This application uses the cPanel API to update the Zone Entries, with the web interface.

### Features
- Add / Remove Zone Entries
- Enable and Disable Zone Entries
- View all current Entries and last updated

### Usage
Simply create an account with the console command if you haven't already
```
php artisan add:user
```
Fill in the inputs and login!

Once an entry has been added, generate the URL under actions, use this URL to keep the IP up to date in a script or cron on whatever device has the dynmaic IP.


### Requirements
- Web Server
- Composer
- Database(mysql, mariadb)
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- A CPanel account( Cpanel User, Cpanel Password, Cpanel Domain)


### Installation

#### Setup Database
```
CREATE DATABASE easydyn;
CREATE USER 'easydyn'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON * . * TO 'easydyn'@'localhost';
FLUSH PRIVILEGES;
```

#### Setup the Web Directory
```
git clone https://github.com/pheinrichs/easydn
cd easydyn
```
[Download Composer if not installed](https://getcomposer.org/download/)
```
composer install
composer setup-app
vi .env
```
-------------
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=easydyn
DB_USERNAME=easydyn
DB_PASSWORD=your_password

CPANEL_URL=https://cpanel.example.com:2083
CPANEL_USER=my_cpanel_user
CPANEL_PASS=my_cpanel_pass
CPANEL_SUBDOMAIN=example.com
CPANEL_TTL=30
```
-------------
save and exit ( :x )

```
chown apache:apache -R storage/ bootstrap/cache/
composer.phar setup-db
```
