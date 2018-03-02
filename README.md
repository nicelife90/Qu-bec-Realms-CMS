# ![logo](http://i66.tinypic.com/5juwt5.jpg)

# Threenity CMS

Threenity CMS is designed to simplify management of a World of Warcraft 3.3.5 server as much as possible. It allows to do the complete management of the [TrinityCore 3.3.5](https://github.com/TrinityCore/TrinityCore/tree/3.3.5) Framework.

## Getting Started

These instructions will get you a copy of the project up and running on your local server machine.

### Prerequisites

* Debian 9.3.0
* Apache2
* MySQL
* PHP 7
* Git
* Composer

### Installing

* First you need a fresh install Debian 9.3.0 [Complete Instruction](https://www.howtoforge.com/tutorial/debian-minimal-server/)

When you complete the above Debian 9.3.0 do the following as **ROOT**:

#### Base Configuration

```sh
$ su
$ apt-get install php7.0 apache2 mysql-server phpmyadmin git composer -y
$ mysql_secure_installation
$ a2enmod rewrite ssl
$ systemctl restart apache2
$ chown www-data:www-data /var/www/html
$ chmod 770 /var/www/html
````

#### MySQL

```sh
$ mysql -u root
mysql> CREATE USER 'newuser'@'localhost' IDENTIFIED BY 'password';
mysql> GRANT ALL PRIVILEGES ON * . * TO 'newuser'@'localhost';
mysql> FLUSH PRIVILEGES;
````

#### CMS

```sh
$ cd /var/www/html/
$ git clone https://github.com/nicelife90/ThreenityCMS.git ./
$ composer install
````

* Complete the installation from your favorite browser by typing your server IP address in the URL bar.

## Keeping CMS up to date

```sh
$ cd /var/www/html/
$ git git pull
$ composer update
````

## Reporting issues

Issues can be reported via the [Github issue tracker](https://github.com/nicelife90/ThreenityCMS/issues).

Please take the time to review existing issues before submitting your own to prevent duplicates.

In addition, thoroughly read through the issue tracker guide to ensure your report contains the required information. Incorrect or poorly formed reports are wasteful and are subject to deletion.

## Contributing

* Create a remote fork
* Push a patch to your remote fork
* Create a pull request
* Keep your remote fork up-to-date with the main repo

## Authors

**[Yanick Lafontaine](https://github.com/nicelife90)** - [ThreenityCMS](https://github.com/nicelife90/ThreenityCMS)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE.md) file for details



