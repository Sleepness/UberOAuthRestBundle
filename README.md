SleepnessUberOAuthRestBundle
====================
Adds support for authenticating users via OAuth2 in Symfony2 REST

Enable the bundle
====================
Enable the bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Sleepness\UberOAuthRestBundle\SleepnessUberOAuthRestBundle(),
    );
}
```

Configuring providers
===================================

To make this bundle work you need to add the following to your app/config/config.yml:

```yaml
# app/config/config.yml
oauth_rest:
```

##### Built-in resource owners:

- [Facebook](Resources/doc/provider/fb.md)
- [Google](Resources/doc/provider/gp.md)
- [Vkontakte](Resources/doc/provider/vk.md)
