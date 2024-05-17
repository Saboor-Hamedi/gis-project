CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) UNIQUE NOT NULL ,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `roles` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
);
insert into users (username, email, password) values('admin', 'admin@gmail.com', '123');
