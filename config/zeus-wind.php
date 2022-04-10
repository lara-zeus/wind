<?php

return [
    'enableDepartments' => true,

    'defaultDepartmentId' => 1,

    'layout' => 'zeus::components.layouts.app',

    'uploads' => [
        'disk' => 'public',
        'directory' => 'logos',
    ],

    'title' => config('app.name', 'Laravel').' | '.'Contact Us',

    'description' => config('app.name', 'Laravel').' Contact Us',

    'color' => '#F5F5F4',

    'default_status' => 'NEW',


];
