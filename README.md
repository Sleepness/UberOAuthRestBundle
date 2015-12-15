SleepnessUberOAuthRestBundle
====================

[![Build Status](https://travis-ci.org/Sleepness/UberOAuthRestBundle.svg?branch=develop)](https://travis-ci.org/Sleepness/UberOAuthRestBundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Sleepness/UberOAuthRestBundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Sleepness/UberOAuthRestBundle/?branch=develop) [![Code Climate](https://codeclimate.com/github/Sleepness/UberOAuthRestBundle/badges/gpa.svg)](https://codeclimate.com/github/Sleepness/UberOAuthRestBundle)

Adds support for authenticating users via OAuth2 in Symfony2 REST

Motivation
====================
You curious why you need this bundle, if there is shiny [HWIOAuthBundle](https://github.com/hwi/HWIOAuthBundle).
HWIOAuthBundle requires sessions and forms

```xml
<service id="hwi_oauth.abstract_resource_owner.oauth2" class="%hwi_oauth.resource_owner.oauth2.class%"
         parent="hwi_oauth.abstract_resource_owner.generic" abstract="true">
    <argument type="service" id="hwi_oauth.storage.session" />
</service>
```

```php
$formHandler = $this->container->get('hwi_oauth.registration.form.handler');
...
$this->authenticateUser($request, $form->getData(), $error->getResourceOwnerName(), $error->getRawToken());
```

meanwhile true RESTful app must be stateless

```yml
# app/config/security.yml
security:
    # ...

    firewalls:
        main:
            http_basic: ~
            stateless:  true
```

UberOAuthRestBundle aims Rest applications only. If you produce pure stateless app and want add few social stuff -- UberOAuthRestBundle this is exactly what you need.
Bundle provides dead-simply Interface, and contains built-in handlers for popular SocialNetworks (OAuth servers)

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
