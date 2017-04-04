
/* User */
INSERT INTO `user` (`id`, `first_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `last_name`, `organization`, `title`, `is_sales_professional`, `receives_newsletter`, `is_interested_in_jobs`)
VALUES
    (1, 'Bob', 'bob@sportsbusiness.solutions', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Hamer', 'Sports Business Solutions', 'President', 1, 0, 0),
	(2, 'Niko', 'niko@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Kovacevic', 'Whale Enterprises', 'Software Developer', 0, 0, 0),
    (3, 'Sean', 'sean@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Brown', 'Whale Enterprises', 'Software Developer', 0, 0, 0),
    (4, 'Test', 'developer@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'User', 'Whale Enterprises', 'Software Developer', 0, 0, 0),
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
    ('user', 4)
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

/* Job */
INSERT INTO `job` (`id`, `user_id`, `title`, `description`, `created_at`, `updated_at`, `organization`, `league`, `job_type`, `city`, `state`, `open`, `image_url`, `edited_at`)
VALUES
	(1, 1, 'Sales manager', 'Cras vulputate, diam in mattis ultrices, velit massa gravida nisl, sed sollicitudin turpis lorem sed dui. Vivamus eu erat nisi. Sed interdum nisi at consectetur sollicitudin. Phasellus vehicula enim nec ex interdum hendrerit. Cras neque enim, pulvinar sed ligula at, sagittis ultricies mauris. Morbi egestas rutrum bibendum. Nulla egestas varius sem sit amet consectetur. Sed laoreet nisi ut tellus elementum, ullamcorper congue nisl semper. Fusce mi quam, lacinia non interdum id, ultricies sit amet ante. Donec ante neque, auctor sit amet eros at, hendrerit bibendum massa. Praesent laoreet turpis at pulvinar viverra. Proin laoreet neque tellus, ut molestie dolor dapibus nec. Mauris mattis ultrices leo non pulvinar. Cras feugiat egestas libero in tempor. Sed sit amet lorem quis augue sollicitudin tristique. Curabitur lectus eros, congue vitae consequat et, commodo et arcu.\r\n\r\nUt nec tellus commodo, tincidunt turpis eget, cursus nulla. Ut tincidunt at arcu quis venenatis. Sed dictum augue quis sem consequat fringilla. Vestibulum in fringilla nisl. Curabitur nisl mi, egestas eget purus in, varius convallis augue. Curabitur et aliquet massa, eget rutrum quam. Cras sed facilisis dui, at elementum ex. Vestibulum elit tellus, eleifend nec erat quis, dictum viverra nunc. Sed sed ante sed neque laoreet mollis id in metus.\r\n\r\nPellentesque at convallis enim, nec commodo ligula. Donec dignissim eu nibh sit amet feugiat. Mauris pretium, massa ac consectetur venenatis, erat velit vestibulum nisi, ac commodo erat nibh ac quam. Aenean pulvinar enim et posuere cursus. Proin sit amet nulla augue. Praesent feugiat interdum sem, et volutpat ante pharetra et. Integer congue convallis ante sed rutrum. Cras id leo eget est vulputate scelerisque. In at eleifend erat. Mauris purus mi, semper quis lacinia vitae, eleifend sed enim. Praesent efficitur dui et neque ornare elementum. Sed posuere arcu blandit, posuere sapien id, euismod magna. Sed accumsan massa quis mollis tincidunt. Mauris aliquam mollis justo sed consequat.', '2017-03-27 13:55:33', '2017-03-27 13:55:33', 'Pittsburgh Steelers', 'nfl', 'sales', 'Pittsburgh', 'PA', 1, 'job/5wQKs8F82bAowKpHtqho8wkgVQEKGpq81OamJVWI.png', NULL),
	(2, 1, 'Sales manager', 'Cras vulputate, diam in mattis ultrices, velit massa gravida nisl, sed sollicitudin turpis lorem sed dui. Vivamus eu erat nisi. Sed interdum nisi at consectetur sollicitudin. Phasellus vehicula enim nec ex interdum hendrerit. Cras neque enim, pulvinar sed ligula at, sagittis ultricies mauris. Morbi egestas rutrum bibendum. Nulla egestas varius sem sit amet consectetur. Sed laoreet nisi ut tellus elementum, ullamcorper congue nisl semper. Fusce mi quam, lacinia non interdum id, ultricies sit amet ante. Donec ante neque, auctor sit amet eros at, hendrerit bibendum massa. Praesent laoreet turpis at pulvinar viverra. Proin laoreet neque tellus, ut molestie dolor dapibus nec. Mauris mattis ultrices leo non pulvinar. Cras feugiat egestas libero in tempor. Sed sit amet lorem quis augue sollicitudin tristique. Curabitur lectus eros, congue vitae consequat et, commodo et arcu.\r\n\r\nUt nec tellus commodo, tincidunt turpis eget, cursus nulla. Ut tincidunt at arcu quis venenatis. Sed dictum augue quis sem consequat fringilla. Vestibulum in fringilla nisl. Curabitur nisl mi, egestas eget purus in, varius convallis augue. Curabitur et aliquet massa, eget rutrum quam. Cras sed facilisis dui, at elementum ex. Vestibulum elit tellus, eleifend nec erat quis, dictum viverra nunc. Sed sed ante sed neque laoreet mollis id in metus.\r\n\r\nPellentesque at convallis enim, nec commodo ligula. Donec dignissim eu nibh sit amet feugiat. Mauris pretium, massa ac consectetur venenatis, erat velit vestibulum nisi, ac commodo erat nibh ac quam. Aenean pulvinar enim et posuere cursus. Proin sit amet nulla augue. Praesent feugiat interdum sem, et volutpat ante pharetra et. Integer congue convallis ante sed rutrum. Cras id leo eget est vulputate scelerisque. In at eleifend erat. Mauris purus mi, semper quis lacinia vitae, eleifend sed enim. Praesent efficitur dui et neque ornare elementum. Sed posuere arcu blandit, posuere sapien id, euismod magna. Sed accumsan massa quis mollis tincidunt. Mauris aliquam mollis justo sed consequat.', '2017-03-27 14:07:19', '2017-03-27 14:07:19', 'Denver Broncos', 'nfl', NULL, 'Denver', 'CO', 1, 'job/7BxGlexyqGSR3Gn599GD6bqHYCy5XGcgUcKcSuVt.png', NULL),
	(3, 1, 'Sales manager', 'Cras vulputate, diam in mattis ultrices, velit massa gravida nisl, sed sollicitudin turpis lorem sed dui. Vivamus eu erat nisi. Sed interdum nisi at consectetur sollicitudin. Phasellus vehicula enim nec ex interdum hendrerit. Cras neque enim, pulvinar sed ligula at, sagittis ultricies mauris. Morbi egestas rutrum bibendum. Nulla egestas varius sem sit amet consectetur. Sed laoreet nisi ut tellus elementum, ullamcorper congue nisl semper. Fusce mi quam, lacinia non interdum id, ultricies sit amet ante. Donec ante neque, auctor sit amet eros at, hendrerit bibendum massa. Praesent laoreet turpis at pulvinar viverra. Proin laoreet neque tellus, ut molestie dolor dapibus nec. Mauris mattis ultrices leo non pulvinar. Cras feugiat egestas libero in tempor. Sed sit amet lorem quis augue sollicitudin tristique. Curabitur lectus eros, congue vitae consequat et, commodo et arcu.\r\n\r\nUt nec tellus commodo, tincidunt turpis eget, cursus nulla. Ut tincidunt at arcu quis venenatis. Sed dictum augue quis sem consequat fringilla. Vestibulum in fringilla nisl. Curabitur nisl mi, egestas eget purus in, varius convallis augue. Curabitur et aliquet massa, eget rutrum quam. Cras sed facilisis dui, at elementum ex. Vestibulum elit tellus, eleifend nec erat quis, dictum viverra nunc. Sed sed ante sed neque laoreet mollis id in metus.\r\n\r\nPellentesque at convallis enim, nec commodo ligula. Donec dignissim eu nibh sit amet feugiat. Mauris pretium, massa ac consectetur venenatis, erat velit vestibulum nisi, ac commodo erat nibh ac quam. Aenean pulvinar enim et posuere cursus. Proin sit amet nulla augue. Praesent feugiat interdum sem, et volutpat ante pharetra et. Integer congue convallis ante sed rutrum. Cras id leo eget est vulputate scelerisque. In at eleifend erat. Mauris purus mi, semper quis lacinia vitae, eleifend sed enim. Praesent efficitur dui et neque ornare elementum. Sed posuere arcu blandit, posuere sapien id, euismod magna. Sed accumsan massa quis mollis tincidunt. Mauris aliquam mollis justo sed consequat.', '2017-03-27 14:07:50', '2017-03-27 14:07:50', 'Phoenix Suns', 'nba', 'sales', 'Phoenix', 'AZ', 1, 'job/ZrJ5o0I8yjSbv8TZIZSxWdw00pR2CuA0FkqHdDXw.jpeg', NULL),
	(4, 1, 'Sales manager', 'Cras vulputate, diam in mattis ultrices, velit massa gravida nisl, sed sollicitudin turpis lorem sed dui. Vivamus eu erat nisi. Sed interdum nisi at consectetur sollicitudin. Phasellus vehicula enim nec ex interdum hendrerit. Cras neque enim, pulvinar sed ligula at, sagittis ultricies mauris. Morbi egestas rutrum bibendum. Nulla egestas varius sem sit amet consectetur. Sed laoreet nisi ut tellus elementum, ullamcorper congue nisl semper. Fusce mi quam, lacinia non interdum id, ultricies sit amet ante. Donec ante neque, auctor sit amet eros at, hendrerit bibendum massa. Praesent laoreet turpis at pulvinar viverra. Proin laoreet neque tellus, ut molestie dolor dapibus nec. Mauris mattis ultrices leo non pulvinar. Cras feugiat egestas libero in tempor. Sed sit amet lorem quis augue sollicitudin tristique. Curabitur lectus eros, congue vitae consequat et, commodo et arcu.\r\n\r\nUt nec tellus commodo, tincidunt turpis eget, cursus nulla. Ut tincidunt at arcu quis venenatis. Sed dictum augue quis sem consequat fringilla. Vestibulum in fringilla nisl. Curabitur nisl mi, egestas eget purus in, varius convallis augue. Curabitur et aliquet massa, eget rutrum quam. Cras sed facilisis dui, at elementum ex. Vestibulum elit tellus, eleifend nec erat quis, dictum viverra nunc. Sed sed ante sed neque laoreet mollis id in metus.\r\n\r\nPellentesque at convallis enim, nec commodo ligula. Donec dignissim eu nibh sit amet feugiat. Mauris pretium, massa ac consectetur venenatis, erat velit vestibulum nisi, ac commodo erat nibh ac quam. Aenean pulvinar enim et posuere cursus. Proin sit amet nulla augue. Praesent feugiat interdum sem, et volutpat ante pharetra et. Integer congue convallis ante sed rutrum. Cras id leo eget est vulputate scelerisque. In at eleifend erat. Mauris purus mi, semper quis lacinia vitae, eleifend sed enim. Praesent efficitur dui et neque ornare elementum. Sed posuere arcu blandit, posuere sapien id, euismod magna. Sed accumsan massa quis mollis tincidunt. Mauris aliquam mollis justo sed consequat.', '2017-03-27 14:08:18', '2017-03-27 14:08:18', 'Pittsburgh Pirates', 'mlb', 'sales', 'Pittsburgh', 'PA', 1, 'job/oIrbA609iZIOyAsfSxPLGfV57lx3cM5G14I62qFF.jpeg', NULL);
