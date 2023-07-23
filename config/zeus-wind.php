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
     * you can set a default department to receive all messages, if the user didn't chose one.
     */
    'defaultDepartmentId' => 1,

    /**
     * set the default status that all messages will have when received.
     */
    'default_status' => 'NEW',
];
