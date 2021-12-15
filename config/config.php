<?php

return [
    'name' => 'Zeus Wind',

    /**
     * always end with /
     * if you made this your default route '/', remember to comment out the default route in web.php
     */
    'path' => 'zeus/',

    'user' => [
        'prefix' => 'user',
        'middleware' => ['web'],
    ],
    'admin' => [
        'prefix' => 'admin',
        'middleware' => ['web','auth'],
    ],

    'defaultDateFormat' => 'M, d Y · h:i a',
    'defaultCategoryId' => 1,
    'enableCategories' => true,
    'layout' => 'zeus::components.layouts.app',
];