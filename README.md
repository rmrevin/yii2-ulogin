Extension for yii2 ulogin integration
==========

Installation
------------
In `composer.json`:
```
{
    "require": {
        "rmrevin/yii2-ulogin": "1.0.*"
    }
}
```

Usage
-----
```php
use yii\ulogin\widgets\ULogin;

echo ULogin::widget([
	'display' => ULogin::D_PANEL,
	'fields' => [ULogin::F_FIRST_NAME, ULogin::F_LAST_NAME, ULogin::F_EMAIL, ULogin::F_PHONE, ULogin::F_CITY, ULogin::F_COUNTRY, ULogin::F_PHOTO_BIG],
	'providers' => [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_TWITTER, ULogin::P_GOOGLE],
	'hidden' => [],
	'redirect_uri' => ['sign/ulogin']
]);

```
