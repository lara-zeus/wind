---
title: Events
weight: 4
---

## Available Events

wind will fire these events:
- `LaraZeus\Wind\Events\LetterSent`

## Register a Listener:
* first create your listener:
```bash
php artisan make:listener SendWindNotification --event=LetterSent
```

* second register the listener in your `EventServiceProvider`

```php
protected $listen = [
    //...
    LetterSent::class => [
        SendWindNotification::class,
    ],
];
```

* finally, you can receive the letter object in the `handle` method, and do what ever you want. 
for example:

```php
Mail::to(User::first())->send(new \App\Mail\Contact(
    $event->letter->name, $event->letter->email, $event->letter->message
));
```
