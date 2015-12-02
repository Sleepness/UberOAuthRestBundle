OAuthRest Bundle
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
        new new Sleepness\UberOAuthRestBundle\SleepnessUberOAuthRestBundle(),
    );
}

Configuring providers
===================================

To make this bundle work you need to add the following to your app/config/config.yml:

```yaml
# app/config/config.yml
oauth_rest:
    providers:
        vk:
            client_id: <client_id>
            client_secret: <client_secret>
            redirect_uri: <redirect_uri>
        fb:
            client_id: <client_id>
            client_secret: <client_secret>
            redirect_uri: <redirect_uri>
        gp:
            client_id: <client_id>
            client_secret: <client_secret>
            redirect_uri: <redirect_uri>

```
