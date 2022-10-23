# Registration-Form-Symfony

### Description

Simple PHP/Symfony web application with registration form and some other features. Other technologies used: Composer, JavaScript, jQuery, Bootstrap, SQLite database, HTML, CSS, AJAX and JSON.

### Features

- registration form as an entry point
- Symfony form validation (back-end)
- JavaScript form validation (front-end)
- dynamic retrieving of voivodeships list using AJAX
- saving data to SQLite database
- possibility to display saved data in HTML view on /client/:id URL
- possibility to display saved data in JSON on /json/:id URL
- login form on /admin URL; after logging in, there is a possibility to display, modify and delete the data

### Admin credentials

In order to log in to admin panel (/admin URL) you need to use those credentials:<br>
**Login**: admin<br>
**Password**: admin

### Used technologies (and versions where needed)

- PHP 8.1.1
- Apache 2.4.52 (Win64) OpenSSL/1.1.1m
- Symfony 5.4.14
- Bootstrap 5.0.2
- jQuery 3.6.1
- Composer 2.3.0
- HTML5
- CSS3
- Javascript, AJAX, JSON, SQLite database

### How to use an application (instructions for Windows users)

In order to use an application locally, you need to have installed on your computer:
- XAMPP (https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.1.10/xampp-windows-x64-8.1.10-0-VS16-installer.exe)
- Web browser - I recommend Google Chrome version 106 or higher

When you have XAMPP and Web browser installed:
- Put xampp folder inside your C: disk
- Download this Git repository
- Make sure that main folder of this repository is named Registration-Form-Symfony and you see inside folders like /assets, /bin, /config and so on
- Copy and paste whole Registration-Form-Symfony folder into C:/xampp/htdocs
- Run XAMPP panel (xampp/xampp_start.exe)
- Start Apache service
- Go to your web browser and enter http://localhost/Registration-Form-Symfony/public/
- Your are on the main page of the application (route "/"). To move around the application use buttons and links or paste the route (from next section) to URL after "/public/" part.

### List of routes with features
- / - main page with registration form
- /login - login page, allowing to log in to /admin panel
- /admin - admin page with list of all clients and options to modify or delete them; user who is not logged in or is not admin will be redirected to /login route
- /admin/modify/:id - page to modify a record with id given in the URL
- /admin/delete/:id - route to delete a record with id given in the URL
- /client/:id - HTML page with information about a client with id given in the URL
- /json/:id - similar to /client/:id, but here is a client data in pure JSON (client id is given in the URL)