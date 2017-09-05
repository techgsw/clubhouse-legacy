
/* User */
INSERT INTO `user` (`id`, `first_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `last_name`, `organization`, `title`, `is_sales_professional`, `receives_newsletter`, `is_interested_in_jobs`)
VALUES
    (1, 'Bob', 'bob@sportsbusiness.solutions', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Hamer', 'Sports Business Solutions', 'President', 1, 0, 0),
	(2, 'Niko', 'niko@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Kovacevic', 'Whale Enterprises', 'Software Developer', 0, 0, 0),
    (3, 'Sean', 'sean@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Brown', 'Whale Enterprises', 'Software Developer', 0, 0, 0),
    (4, 'Liz', 'emagura@gmail.com', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Magura', NULL, 'Graphic Designer', 0, 0, 0),
    (5, 'Test', 'developer@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'User', NULL, NULL, 0, 0, 0),
    (6, 'Cameron', 'cameron@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Dudley', 'Whale Enterprises', NULL, 0, 0, 0)
	;

/* RoleUser */
INSERT INTO `role_user` (`role_code`, `user_id`)
VALUES
    ('superuser', 1),
    ('administrator', 1),
    ('moderator', 1),
    ('user', 1),
    ('superuser', 2),
    ('administrator', 2),
    ('moderator', 2),
    ('user', 2),
    ('superuser', 3),
    ('administrator', 3),
    ('moderator', 3),
    ('user', 3),
    ('superuser', 4),
    ('administrator', 4),
    ('moderator', 4),
    ('user', 4),
    ('user', 5),
    ('superuser', 6),
    ('administrator', 6),
    ('moderator', 6),
    ('user', 6)
    ;

/* Question */
INSERT INTO `question` (`id`, `user_id`, `title`, `approved`, `created_at`, `updated_at`, `body`, `edited_at`)
VALUES
	(1, 3, 'Is it better to work in the NFL or the NBA?', 1, '2017-03-21 13:07:19', '2017-03-21 13:30:13', 'I currently work in the NFL, but I\'ve been considering switching to the NBA. What do you think about that? Any advice for transitioning?\r\n\r\nUPDATE: Got a job with the Spurs!', '2017-03-21 13:30:13'),
	(2, 4, 'Should we approve this question?', NULL, '2017-03-21 14:08:40', '2017-03-21 14:08:40', 'Hopefully, it\'ll be NULL, but we\'ll see!', NULL);

/* Answer */
INSERT INTO `answer` (`id`, `user_id`, `question_id`, `answer`, `approved`, `created_at`, `updated_at`, `edited_at`)
VALUES
	(1, 2, 1, 'I work for the Phoenix Suns. I love it. Give me a call!\r\n\r\nMy phone number is 1234567890.', 1, '2017-03-21 13:08:16', '2017-03-21 13:23:50', '2017-03-21 13:23:50'),
	(2, 2, 1, 'Thanks, Alice!', 1, '2017-03-21 13:29:32', '2017-03-21 13:29:38', NULL);

