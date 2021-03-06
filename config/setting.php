<?php
return [
    'settings' => [
        'gateUrl' => 'https://gate.biom.io:444/',
        'gateUri' => 'https://gate.biom.io:444/',
        'openIdUri' => 'https://idp.biom.io',
        'AIUri'=>'https://biom.io',

        'mailer_service' => [
            'provider' => [
                'name' => 'MailerGun',
                 'apiKey' => 'key-22d04f5f1108f80acd648c9234c45546',
                 'domain' => 'mg.biom.io',
            ],
            'template_path' => PATH_ROOT .'../components/renderer_tmpl/emails/'
        ],
        'upload' => [
            'profilePicturePath' => PATH_ROOT ."profileData/profilePicture/",
            'companyLogoPath' => PATH_ROOT ."profileData/companyLogo/",
            'locationPicturePath' => PATH_ROOT ."profileData/locationPicture/",
            'tempWebsiteFilesPath' => PATH_ROOT .'profileData/tempWebsiteFiles/',
            'websiteScreenshotPath' => PATH_ROOT .'profileData/websiteScreenshot/'
        ],
        'displayErrorDetails' => true, // set to false in production

        // PHP Renderer settings
        'renderer' => [
            'template_path' => PATH_ROOT . '../components/renderer_tmpl',
        ],

        // Twig View settings
        'view' => [
            'template_path' => PATH_ROOT . '../components/twig_tmpl',
            'cache_path' => PATH_ROOT . '../storage/cache/',
            'debug' => true,
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => PATH_ROOT . '../storage/log/server.log',
        ],

    ],
    'db' => [
        'host' => '35.161.49.206',
        'user' => 'biomio_admin',
        'password' => 'admin',
        'dbName' => 'biomio_db',
        'port'=>'3306'
    ]
];
