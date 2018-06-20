ULogin integration for Yii 2
============================

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

```bash
composer require "rmrevin/yii2-ulogin:~1.4"
```

or add

```
"rmrevin/yii2-ulogin": "~1.4",
```

to the `require` section of your `composer.json` file.

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
    'redirectUri' => ['sign/ulogin'],

    // force use https in redirect uri
    'forceRedirectUrlScheme' => 'https',

    // optional params (can be ommited)
    // force widget language (autodetect by default)
    'language' => ULogin::L_RU,

    // providers sorting ('relevant' by default)
    'sortProviders' => ULogin::S_RELEVANT,

    // verify users' email (disabled by default)
    'verifyEmail' => '0',

    // mobile buttons style (enabled by default)
    'mobileButtons' => '1',
]);
```

Getting user info after success auth (response from ulogin):
```php
use rmrevin\yii\ulogin\AuthAction;

class SiteController extends Controller
{

    public function action()
    {
        return [
            // ...
            'ulogin-auth' => [
                'class' => AuthAction::className(),
                'successCallback' => [$this, 'uloginSuccessCallback'],
                'errorCallback' => function($data){
                    \Yii::error($data['error']);
                },
            ]
        ];
    }

    public function uloginSuccessCallback($attributes)
    {
        print_r($attributes);
    }
}
```
