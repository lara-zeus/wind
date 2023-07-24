---
title: Theming
weight: 20
---

## tailwind config

### for filament
we only have small classes used in `LetterResource`, add to your tailwind config `content`

```
'./vendor/lara-zeus/wind/src/Filament/Resources/LetterResource.php',
```

### for the frontend
if you have custom theme you should add the blade files:

```
'./vendor/lara-zeus/wind/resources/views/themes/**/*.blade.php',
```
