# CMS BLOG SITE
[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)
####  Built with LAMP stack 



This is a full-stack web application that has a page for listing all blogs and authenticated admin CMS features to edit, add and delete blogs, comments and admins. 
Try out the deployed application below: 
Public View: 
**[Blog Public View](https://blogprototype.000webhostapp.com/Blog.php)**!
Admin View: 
**[Admin View](https://blogprototype.000webhostapp.com/Login.php)!** (uname - sleepturtle, password - 1234) 
 

## Table of Contents 
1. [Details and Technology Used](#1.-Details-and-Technology-Used)
2. [Installing LAMP server](#2.-Installing-LAMP-Server)
3. [Clone Project and View in Browser](#3.-Clone-Project-and-View-in-Browser)
4. [Features](#4.-Features)
5. [First Look](#5.-First-Look)
6. [License](#6.-License)

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
#### Home Page
![alt text](https://github.com/sleepturtle2/php-blog/blob/main/1.png?raw=true)
#### Comments, Categories
![alt text](https://github.com/sleepturtle2/php-blog/blob/main/2.png?raw=true)

## 6. License
```
Copyright (c) 2021 Sayantan Mukherjee

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

