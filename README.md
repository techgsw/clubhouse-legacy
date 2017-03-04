# Sports Business Solutions

[Sports Business Solutions](http://www.sportsbusiness.solutions/) helps people succeed in sports business by providing training, consulting, and recruiting services for sports teams and career cervices for those interested in working in sports.

See the [Wiki](https://source.whale.enterprises/sbs/sportsbusinesssolutions/wikis/home) for project scope.

# Installation

## git

#### Clone the repository
```
git clone git@source.whale.enterprises:sbs/sportsbusinesssolutions.git sportsbusinesssolutions
```

## Composer

#### Update and install project dependencies
```
composer update
composer install
```

## Laravel

#### Generate an application key
```
cp .env.example .env
php artisan key:generate
```

## Homestead

*full instructions at https://laravel.com/docs/5.4/homestead*

Set up Homestead environment, which bundles PHP, nginx, MySQL, Postgres, Redis, Memcached, Node, &c.

First, install [VirtualBox 5.1](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/downloads.html).

#### Install the Homestead Vagrant box
```
vagrant box add laravel/homestead
```

#### Install and Configure Homestead
```
php vendor/bin/homestead make
vi Homestead.yaml
```
- Check that `folders` points to your development directory.  
- Change `sites` to `- { map: sportsbusinesssolutions, to: /home/vagrant/Code/sportsbusinesssolutions/public }`.

#### Add to Hosts
```
sudo vi /etc/hosts
```
Add `192.168.10.10 sportsbusinesssolutions` to the list of hosts

#### Run the dang thing
```
vagrant up
```
Go to `http://sportsbusinesssolutions/`
