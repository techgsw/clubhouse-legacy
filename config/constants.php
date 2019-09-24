<?php

define('JOB_STATUS_ID',
    array(
        'open' => 1,
        'closed' => 2,
        'expired' => 3
    )
);

define('JOB_TYPE_ID',
    array(
        'sbs_default' => 1,
        'user_free' => 2,
        'user_premium' => 3,
        'user_platinum' => 4,
    )
);

define('PRODUCT_ID',
    array(
        'premium_job' => 54,
        'platinum_job' => 55,
    )
);

define('PRODUCT_OPTION_ID',
    array(
        'premium_job' => 51,
        'premium_job_upgrade' => 52,
        'platinum_job' => 53,
        'platinum_job_upgrade' => 54,
        'platinum_job_upgrade_premium' => 55,
        'job_extension' => 56
    )
);
