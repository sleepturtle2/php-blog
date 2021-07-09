# CMS BLOG SITE
[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)
####  Built with LAMP stack 



This is a full-stack web application that has a page for listing all blogs and authenticated admin CMS features to edit, add and delete blogs, comments and admins.   
**[Try out the deployed application here](https://blogprototype.000webhostapp.com/Blog.php)**!
 

## Table of Contents 
1. [Details and Technology Used](#1.-Details-and-Technology-Used)
2. [Installing LAMP server](#2.-Installing-LAMP-Server)
3. [Clone Project and View in Browser](#3.-Clone-Project-and-View-in-Browser)
4. [Features](#4.-Features)
5. [First Look](#5. First Look)

## 1. Details and Technology Used 
* LAMP stack (Linux operating system, Apache HTTP Server, MySQL database, PHP programming language)
* Debian based OS Ubuntu 20.04 
## 2. Installing LAMP Server
Running the project requires you to have an Apache Server. If you do not have one, follow the intructions below to get one started on your computer. 

#### Debian Linux / Windows SubSystem for Linux

`sudo apt update`
`sudo apt install apache2`
`sudo apt install mysql-server`
`sudo apt install php libapache2-mod-php php-mysql`

Starting the server:  
`sudo /opt/lampp/lampp start`

#### Arch Linux 
`sudo pacman -Syu apache`
`sudo systemctl start httpd`
`sudo pacman -S mysql`
`sudo systemctl start mysqld`
`sudo pacman -Syu php php-apache`

Go to `/opt/lampp/htdocs` or `/var/www/htdocs` directory according to `htdocs` location 

## 3. Clone Project and View in Browser
Clone repo into `htdocs` folder 
`git clone https://github.com/sleepturtle2/php-blog.git`
 Website live through localhost: 
Repo code is live at `localhost/php-blog`. Each `.php` or `.html` page can be viewed by appending the name of the file after the localhost address. 

## 4. Features

#### 4.1 Public View 
-   A list view of all posts sorted by date, approved comments, date of entry, author
-   A side section of list of categories 
-   Subscription mailing list entry  
-   Each individual post can be viewed in a separate page, consisting of title, post content, author, approved comments. There is a section after the post for commenting. Comment will be displayed only after being approved by the admin 
  
#### 4.2 Admin View (authenticated) 
- CMS to add, delete admins 
- CMS to add, edit, delete posts 
- CMS to approve, disapprove and delete comments 

## 5. First Look at the Application
![alt text](https://github.com/sleepturtle2/php-blog/blob/main/1.png?raw=true)
![alt text](https://github.com/sleepturtle2/php-blog/blob/main/2.png?raw=true)
