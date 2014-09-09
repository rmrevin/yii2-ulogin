Extension for yii2 ulogin integration
==========

Installation
------------
In `composer.json`:
```
{
    "require": {
        "rmrevin/yii2-ulogin": "1.2.0"
    }
}
```

Usage
-----
```php
use rmrevin\yii\ulogin\ULogin;

echo ULogin::widget([
    // widget look'n'feel
    'display' => ULogin::D_PANEL,

    // required fields
    'fields' => [ULogin::F_FIRST_NAME, ULogin::F_LAST_NAME, ULogin::F_EMAIL, ULogin::F_PHONE, ULogin::F_CITY, ULogin::F_COUNTRY, ULogin::F_PHOTO_BIG],

    // optional fields
    'optional' => [ULogin::F_BDATE],

    // login providers
    'providers' => [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_TWITTER, ULogin::P_GOOGLE],

    // login providers that are shown when user clicks on additonal providers button
    'hidden' => [],

    // where to should ULogin redirect users after successful login
    'redirect_uri' => ['sign/ulogin'],

    // optional params (can be ommited)
    // force widget language (autodetect by default)
    'lang' => ULogin::L_RU,

    // providers sorting ('relevant' by default)
    'sort' => ULogin::S_RELEVANT,

    // verify users' email (disabled by default)
    'verify' => '0',

    // mobile buttons style (enabled by default)
    'mobilebuttons' => '1',
]);

```
