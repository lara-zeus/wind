---
title: Theming
weight: 20
---

## Tailwind config

### for filament
We only have small classes used in `LetterResource`, add to your tailwind config `content`

```
'./vendor/lara-zeus/wind/src/Filament/Resources/LetterResource.php',
```

### For the frontend
If you have a custom theme you should add the blade files:

```
'./vendor/lara-zeus/wind/resources/views/themes/**/*.blade.php',
```
