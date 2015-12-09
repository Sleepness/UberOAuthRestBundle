SleepnessUberOAuthRestBundle
====================

[![Build Status](https://travis-ci.org/Sleepness/UberOAuthRestBundle.svg?branch=develop)](https://travis-ci.org/Sleepness/UberOAuthRestBundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Sleepness/UberOAuthRestBundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Sleepness/UberOAuthRestBundle/?branch=develop) [![Code Climate](https://codeclimate.com/github/Sleepness/UberOAuthRestBundle/badges/gpa.svg)](https://codeclimate.com/github/Sleepness/UberOAuthRestBundle)

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

##### Built-in providers:

- [Facebook](Resources/doc/provider/fb.md)
- [Google](Resources/doc/provider/gp.md)
- [Vkontakte](Resources/doc/provider/vk.md)
