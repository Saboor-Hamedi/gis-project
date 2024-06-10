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
insert into users (username, email, password) values('guest', 'guest@gmail.com', '123');

/* banner */
create table `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);
insert into banner (title, content) values('Global Islamic School',
"
Global Islamic School adalah sekolah islam yang menggunakan kurikulum nasional yang diperkaya dengan penguatan pada empat pilar unggulan (competitive advantages): Akademik, Keislaman, Kepemimpinan dan Keglobalan (wawasan internasional).
"
);

create table `posts`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
insert into posts (title, content, user_id) values('Post 1', 'Global Islamic School', 1);
insert into posts (title, content, user_id) values('Post 2', 'Global Islamic School', 2);
