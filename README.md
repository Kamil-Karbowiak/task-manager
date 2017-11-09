#Task Manager
Simple to-do application for managing your daily tasks. This project is creating for learning purposes...
Project features:
•	wirtten in PHP
•	based on MVC pattern
•	uses a MySQL database through PHP Data Object
•	uses HTML, CSS and JavaScript (jQuery) in front end
•	authentication uses PHP session mechanism
•	uses TWIG template engine
•	simple pagination system
•	simple validation system
•	CSRF protection
•	uses Bootstrap
•	unit tests

How to use
1.	Clone repository
2.	Run composer install
3.	Set your database credentials in the app/config/config.php file
4.	Database structure:

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
PRIMARY KEY (`id`),
  UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `dueDate` datetime NOT NULL,
  `addDate` datetime NOT NULL,
  `priority` varchar(10) NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`userId`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

