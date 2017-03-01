ZF2 Doctrine Test
=======================

Introduction
------------
This is a Doctrine ZF2 test

Installation
------------
- First clone this repository
- You need to install vagrant https://www.vagrantup.com/downloads.html
- simply launch the box : vagrant up
- install depdencies: ./composer.phar self-update && ./composer.phar install
- you can connect to the box with ssh : vagrant ssh
- create mysql database 'album_doctrine'
- From your box source code is under /vagrant
- update your database schema with doctrine-module (/vagrant/vendor/bin/doctrine-module)

your env is up to go at 192.168.33.22

 - You have to make a relationship between album entity and the new created artist entity (id, label)
 - In the form album make a dropdown list of artist
 - Add pagination with five Items in album list
