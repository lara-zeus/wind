<?php

return [
    /**
     * set the default path for the blogs homepage.
     */
    'path' => 'blog',

    /**
     * the middleware you want to apply on all the blogs routes
     * for example if you want to make your blog for users only, add the middleware 'auth'.
     */
    'middleware' => ['web'],

    /**
     * allows you to create multiple departments to receive the messages from your website.
     */
    'enableDepartments' => true,

    /**
     * you can set a default department to receive all messages, if the user didn't chose one.
     */
    'defaultDepartmentId' => 1,

    /**
     * you can use the default layout as a starting point for your blog.
     * however, if you're already using your own component, just set the path here.
     */
    'layout' => 'zeus::components.app',

    /**
     * set the default upload options for departments logo.
     */
    'uploads' => [
        'disk' => 'public',
        'directory' => 'logos',
    ],

    /**
     * this will be setup the default seo site title. read more about it in 'laravel-seo'.
     */
    'site_title' => config('app.name', 'Laravel').' | Contact Us',

    /**
     * this will be setup the default seo site description. read more about it in 'laravel-seo'.
     */
    'site_description' => config('app.name', 'Laravel').' Contact Us',

    /**
     * this will be setup the default seo site color theme. read more about it in 'laravel-seo'.
     */
    'color' => '#F5F5F4',

    /**
     * set the default status that all messages will have when received.
     */
    'default_status' => 'NEW',
];
