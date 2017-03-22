
INSERT INTO `role` (`code`, `description`) VALUES
    ('super-user', 'Super User: all privileges'),
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
    ('job_create', 'Can ask a job and edit that job.'),
    ('job_edit', 'Can edit any job.'),
    ('job_approve', 'Can approve or disapprove any job.'),
    ('job_delete', 'Can delete any job.'),
    /* Admin */
    ('admin_index', 'Can view admin dashboard.'),
    ('admin_user', 'Can view admin user dashboard.'),
    ('admin_question', 'Can view admin question dashboard.'),
    ('admin_job', 'Can view admin job dashboard.')
    ;

INSERT INTO `resource_role` (`role_code`, `resource_code`) VALUES
    /* Administrator */
    ('super-user', 'user_profile'),
    ('super-user', 'user_show'),
    ('super-user', 'user_edit'),
    ('super-user', 'question_index'),
    ('super-user', 'question_show'),
    ('super-user', 'question_create'),
    ('super-user', 'question_edit'),
    ('super-user', 'question_approve'),
    ('super-user', 'question_delete'),
    ('super-user', 'answer_create'),
    ('super-user', 'answer_edit'),
    ('super-user', 'answer_approve'),
    ('super-user', 'answer_delete'),
    ('super-user', 'job_index'),
    ('super-user', 'job_show'),
    ('super-user', 'job_create'),
    ('super-user', 'job_edit'),
    ('super-user', 'job_approve'),
    ('super-user', 'job_delete'),
    ('super-user', 'admin_index'),
    ('super-user', 'admin_user'),
    ('super-user', 'admin_question'),
    ('super-user', 'admin_job'),
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
    ('administrator', 'job_approve'),
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
    ('moderator', 'job_approve'),
    ('moderator', 'job_delete'),
    ('moderator', 'admin_index'),
    ('moderator', 'admin_question'),
    ('moderator', 'admin_job'),
    /* User */
    ('user', 'user_profile'),
    ('user', 'question_index'),
    ('user', 'question_show'),
    ('user', 'question_create'),
    ('user', 'answer_create'),
    ('user', 'job_index'),
    ('user', 'job_show')
    ;
