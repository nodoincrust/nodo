<?php return array(
    'root' => array(
        'pretty_version' => 'dev-master',
        'version' => 'dev-master',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(
            0 => '3.2.x-dev',
        ),
        'reference' => '4471e63791c604126ba447c47c7ab9f43f78e183',
        'name' => 'twbs/bootstrap',
        'dev' => true,
    ),
    'versions' => array(
        'mongodb/mongodb' => array(
            'pretty_version' => '1.4.3',
            'version' => '1.4.3.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../mongodb/mongodb',
            'aliases' => array(),
            'reference' => '18fca8cc8d0c2cc07f76605760d20632bb3dab96',
            'dev_requirement' => false,
        ),
        'twbs/bootstrap' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(
                0 => '3.2.x-dev',
            ),
            'reference' => '4471e63791c604126ba447c47c7ab9f43f78e183',
            'dev_requirement' => false,
        ),
        'twitter/bootstrap' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '3.2.x-dev',
                1 => 'dev-master',
            ),
        ),
    ),
);
