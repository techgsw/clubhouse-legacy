# SBS Consulting

[SBS Consulting](http://www.sportsbusiness.solutions/) helps people succeed in sports business by providing training, consulting, and recruiting services for sports teams and career cervices for those interested in working in sports.

See the [Wiki](https://source.whale.enterprises/sbs/sportsbusinesssolutions/wikis/home) for project scope.

# Installation

## git

Clone the repository
```
git clone git@source.whale.enterprises:sbs/sportsbusinesssolutions.git sportsbusinesssolutions
```

## Composer

Update and install project dependencies
```
composer install
```

## Laravel

Generate an application key
```
cp .env.example .env
php artisan key:generate
```

## Homestead

*full instructions at https://laravel.com/docs/5.4/homestead*

Set up Homestead environment, which bundles PHP, nginx, MySQL, Postgres, Redis, Memcached, Node, &c.

First, install [VirtualBox 5.1](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/downloads.html).

Drop this `Homestead.yaml` config file into the project's root directory:
```
ip: 192.168.10.10
memory: 2048
cpus: 1
provider: virtualbox
authorize: ~/.ssh/id_rsa.pub
keys:
    - ~/.ssh/id_rsa
folders:
    - { map: /Users/{YOU}/Sites/sportsbusinesssolutions, to: /home/vagrant/Code/sportsbusinesssolutions }
sites:
    - { map: sportsbusinesssolutions.app, to: /home/vagrant/Code/sportsbusinesssolutions/public }
databases:
    - homestead
name: sportsbusinesssolutions
hostname: sportsbusinesssolutions
```
- Check that `folders` points to your development directory.  
- Check that `sites` points to `- { map: sportsbusinesssolutions, to: /home/vagrant/Code/sportsbusinesssolutions/public }`.

Install the Homestead Vagrant box
```
vagrant box add laravel/homestead
```

Add to Hosts
```
sudo vi /etc/hosts
```
Add `192.168.10.10 sportsbusinesssolutions` to the list of hosts

Run the dang thing
```
vagrant up
```

## Schema

Migrations will build the schema for you, but you'll have to create the database in your Vagrant environment.

```
vagrant ssh
mysql -u homestead -p
Enter the password: secret

> create database sbs;
> use sbs;
> exit;

php artisan migrate
```

To obtain access through a client like Sequel Pro or MySQL Workbench, set up with SSH

```
Host:     192.168.10.10
Username: homestead
Password: secret
SSH Host: 192.168.10.10
SSH User: vagrant
SSH Pass: vagrant
```

*see https://laracasts.com/discuss/channels/general-discussion/location-of-mysql-db-on-vm*

## Did it work?

Go to `http://sportsbusinesssolutions/` to find out.
