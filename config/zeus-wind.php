<?php

return [
    /**
     * set the default path for the contact form homepage.
     */
    'path' => 'contact-us',

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * customize the models
     */
    'models' => [
        'department' => \LaraZeus\Wind\Models\Department::class,
        'letter' => \LaraZeus\Wind\Models\Letter::class,
    ],

    /**
     * allows you to create multiple departments to receive the messages from your website.
     */
    'enableDepartments' => true,

    /**
     * you can set a default department to receive all messages, if the user didn't chose one.
     */
    'defaultDepartmentId' => 1,

    /**
     * set the default upload options for departments logo.
     */
    'uploads' => [
        'disk' => 'public',
        'directory' => 'logos',
    ],

    /**
     * set the default status that all messages will have when received.
     */
    'default_status' => 'NEW',

    /**
     * Navigation Group Label
     */
    'navigation_group_label' => 'wind',
];
