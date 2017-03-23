
/* User */
INSERT INTO `user` (`id`, `first_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `last_name`, `organization`, `title`, `is_sales_professional`, `receives_newsletter`, `is_interested_in_jobs`)
VALUES
	(1, 'Niko', 'niko@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', '5QtHdOtZl70ZE2bLcvF1JLHeRAtxg8DX2BFlIBc3JINXekqDB37L2Tx7Hk6M', '2017-03-21 13:03:06', '2017-03-21 13:03:06', 'Kovacevic', 'Whale Enterprises', 'Software Developer', 0, 1, 0),
	(2, 'Alice', 'alice@sportsbusiness.solutions', '$2y$10$D8K0FX8p6GKIiuf5p1Qu7ePuvLoztfllZ/VNO0VrOZn4PiugfQHRG', 'R02neBpvIvwUzOcu2RHWWwissHxKXRlGhNdLyuCF7gFseNpjaNObo1itw99t', '2017-03-21 13:03:39', '2017-03-21 13:03:39', 'User', 'Phoenix Suns', 'Sales associate', 1, 1, 1),
	(3, 'Bob', 'bob@sportsbusiness.solutions', '$2y$10$R6VTK2BVksOkzijuPFiveuZJPwlGye.3R.9zhLFnuKI3tRQ32.Kdq', 'Qm7RnQ6AS4QBm03JpXL3f7sqslyMhxJSYYcpKlgncu8tBLMNXZKMxG2WV7Ar', '2017-03-21 13:04:09', '2017-03-21 13:05:26', 'User', 'Pittsburgh Steelers', 'Quarterback', 0, 0, 1),
	(4, 'Mike', 'mike@sportsbusiness.solutions', '$2y$10$lzi8TUpVOUgvqolG6i/Qc.dBw4n2XV8xoYKto0rP7hmuFmENRVr2e', NULL, '2017-03-21 14:08:00', '2017-03-21 14:08:00', 'Moderator', 'Sports Business Solutions', 'Moderator', 1, 0, 1);

/* RoleUser */
INSERT INTO `role_user` (`role_code`, `user_id`)
VALUES
    ('superuser', 1),
    ('administrator', 1),
    ('moderator', 1),
    ('user', 1),
    ('user', 2),
    ('user', 3),
    ('moderator', 4),
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
