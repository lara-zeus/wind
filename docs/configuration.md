---
title: Configuration
weight: 3
---

## Configuration

to configure the plugin Wind, you can pass the configuration to the plugin in `adminPanelProvider`

these all the available configuration, and their defaults values

```php
WindPlugin::make()
    ->windPrefix('wind')
    ->windMiddleware(['web'])
    ->defaultDepartmentId(1)
    ->defaultStatus('NEW')
    ->departmentResource()
    ->windModels([
        'Department' => \LaraZeus\Wind\Models\Department::class,
        'Letter' => \LaraZeus\Wind\Models\Letter::class,
    ])
    ->uploadDisk('public')
    ->uploadDirectory('logos')
    ->navigationGroupLabel('Wind'),
```
