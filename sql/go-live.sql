
INSERT INTO `role` (`code`, `description`) VALUES
    ('superuser', 'Super User: all privileges'),
    ('administrator', 'Administrator: can manage all content and users'),
    ('moderator', 'Moderator: can manage all content'),
    ('user', 'User: can authenticate identity');

INSERT INTO `resource` (`code`, `description`) VALUES
    /* User */
    ('user_profile', 'Can view user profile.'),
    ('user_show', 'Can view any user.'),
    ('user_edit', 'Can edit any user.'),
    /* Question & Answer */
    ('question_index', 'Can view question index.'),
    ('question_show', 'Can view individual questions.'),
    ('question_create', 'Can ask a question and edit that question.'),
    ('question_edit', 'Can edit any question.'),
    ('question_approve', 'Can approve or disapprove any question.'),
    ('question_delete', 'Can delete any question.'),
    ('answer_create', 'Can answer any question and edit that answer.'),
    ('answer_edit', 'Can edit any answer.'),
    ('answer_approve', 'Can approve or disapprove any answer.'),
    ('answer_delete', 'Can delete any answer.'),
    /* Job board */
    ('job_index', 'Can view job index.'),
    ('job_show', 'Can view individual jobs.'),
    ('job_create', 'Can create a job and edit that job.'),
    ('job_edit', 'Can edit any job.'),
    ('job_close', 'Can close or open a job.'),
    ('job_delete', 'Can delete any job.'),
    ('inquiry_create', 'Can submit an inquiry for a job.'),
    /* Admin */
    ('admin_index', 'Can view admin dashboard.'),
    ('admin_user', 'Can view admin user dashboard.'),
    ('admin_question', 'Can view admin question dashboard.'),
    ('admin_job', 'Can view admin job dashboard.')
    ;

INSERT INTO `resource_role` (`role_code`, `resource_code`) VALUES
    /* Superuser */
    ('superuser', 'user_profile'),
    ('superuser', 'user_show'),
    ('superuser', 'user_edit'),
    ('superuser', 'question_index'),
    ('superuser', 'question_show'),
    ('superuser', 'question_create'),
    ('superuser', 'question_edit'),
    ('superuser', 'question_approve'),
    ('superuser', 'question_delete'),
    ('superuser', 'answer_create'),
    ('superuser', 'answer_edit'),
    ('superuser', 'answer_approve'),
    ('superuser', 'answer_delete'),
    ('superuser', 'job_index'),
    ('superuser', 'job_show'),
    ('superuser', 'job_create'),
    ('superuser', 'job_edit'),
    ('superuser', 'job_close'),
    ('superuser', 'job_delete'),
    ('superuser', 'admin_index'),
    ('superuser', 'admin_user'),
    ('superuser', 'admin_question'),
    ('superuser', 'admin_job'),
    /* Administrator */
    ('administrator', 'user_profile'),
    ('administrator', 'user_show'),
    ('administrator', 'user_edit'),
    ('administrator', 'question_index'),
    ('administrator', 'question_show'),
    ('administrator', 'question_create'),
    ('administrator', 'question_edit'),
    ('administrator', 'question_approve'),
    ('administrator', 'question_delete'),
    ('administrator', 'answer_create'),
    ('administrator', 'answer_edit'),
    ('administrator', 'answer_approve'),
    ('administrator', 'answer_delete'),
    ('administrator', 'job_index'),
    ('administrator', 'job_show'),
    ('administrator', 'job_create'),
    ('administrator', 'job_edit'),
    ('administrator', 'job_close'),
    ('administrator', 'job_delete'),
    ('administrator', 'admin_index'),
    ('administrator', 'admin_user'),
    ('administrator', 'admin_question'),
    ('administrator', 'admin_job'),
    /* Moderator */
    ('moderator', 'question_edit'),
    ('moderator', 'question_approve'),
    ('moderator', 'question_delete'),
    ('moderator', 'answer_edit'),
    ('moderator', 'answer_approve'),
    ('moderator', 'answer_delete'),
    ('moderator', 'job_create'),
    ('moderator', 'job_edit'),
    ('moderator', 'job_close'),
    ('moderator', 'job_delete'),
    ('moderator', 'admin_index'),
    ('moderator', 'admin_question'),
    ('moderator', 'admin_job'),
    ('moderator', 'user_show'),
    /* User */
    ('user', 'user_profile'),
    ('user', 'question_index'),
    ('user', 'question_show'),
    ('user', 'question_create'),
    ('user', 'answer_create'),
    ('user', 'job_index'),
    ('user', 'job_show'),
    ('user', 'inquiry_create')
    ;

/* User */
INSERT INTO `user` (`id`, `first_name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `last_name`, `organization`, `title`, `is_sales_professional`, `receives_newsletter`, `is_interested_in_jobs`)
VALUES
    (1, 'Bob', 'bob@sportsbusiness.solutions', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, NOW(), NOW(), 'Hamer', 'Sports Business Solutions', 'President', 1, 0, 0),
	(2, 'Niko', 'niko@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, NOW(), NOW(), 'Kovacevic', 'Whale Enterprises', 'Software Developer', 0, 0, 0),
    (3, 'Sean', 'sean@whale.enterprises', '$2y$10$ae8AwT5S7Taava1LrmVvAOPevxaSC5gTfwG4NofdUafDVQQnbTjVy', NULL, NOW(), NOW(), 'Brown', 'Whale Enterprises', 'Software Developer', 0, 0, 0)
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
    ('user', 3)
    ;
