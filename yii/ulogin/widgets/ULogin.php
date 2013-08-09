<?php
/**
 * ULogin.php
 * @author: Revin Roman <xgismox@gmail.com>
 */

namespace yii\ulogin\widgets;

use yii\base\View;
use yii\base\Widget;
use yii\helpers\Html;

class ULogin extends Widget
{

	public $display = self::D_SMALL;

	public $fields = [self::F_FIRST_NAME, self::F_LAST_NAME, self::F_EMAIL];

	public $providers = [self::P_VKONTAKTE, self::P_FACEBOOK, self::P_TWITTER, self::P_GOOGLE];

	public $hidden = [self::P_OTHER];

	public $redirect_uri = null;

	public function init()
	{
		parent::init();

		if ($this->redirect_uri === null) {
			$this->redirect_uri = ['ulogin/adapter'];
		}

		\Yii::$app->getView()->registerJsFile('//ulogin.ru/js/ulogin.js', ['position' => View::POS_HEAD]);
	}

	public function run()
	{
		echo Html::tag('div', '', [
			'id' => $this->getId(),
			'data-ulogin' => str_replace(['&', '%2C'], [';', ','], http_build_query([
				'display' => $this->display,
				'fields' => implode(',', $this->fields),
				'providers' => implode(',', $this->providers),
				'hidden' => implode(',', $this->hidden),
				'redirect_uri' => \Yii::$app->getUrlManager()->createAbsoluteUrl($this->redirect_uri)
			]))
		]);
	}

	const D_SMALL = 'small';

	const D_PANEL = 'panel';

	const D_WINDOW = 'window';

	const F_FIRST_NAME = 'first_name';

	const F_LAST_NAME = 'last_name';

	const F_EMAIL = 'email';

	const F_NICKNAME = 'nickname';

	const F_BDATE = 'bdate';

	const F_SEX = 'sex';

	const F_PHONE = 'phone';

	const F_PHOTO = 'photo';

	const F_PHOTO_BIG = 'photo_big';

	const F_CITY = 'city';

	const F_COUNTRY = 'country';

	const P_OTHER = 'other';

	const P_VKONTAKTE = 'vkontakte';

	const P_ODNOKLASSNIKI = 'odnoklassniki';

	const P_MAILRU = 'mailru';

	const P_FACEBOOK = 'facebook';

	const P_TWITTER = 'twitter';

	const P_GOOGLE = 'google';

	const P_YANDEX = 'yandex';

	const P_LIVEJOURNAL = 'livejournal';

	const P_OPENID = 'openid';

	const P_FLICKR = 'flickr';

	const P_LASTFM = 'lastfm';

	const P_LINKEDIN = 'linkedin';

	const P_LIVEID = 'liveid';

	const P_SOUNDCLOUD = 'soundcloud';

	const P_STEAM = 'steam';

	const P_VIMEO = 'vimeo';

	const P_WEBMONEY = 'webmoney';

	const P_YOUTUBE = 'youtube';

	const P_FOURSQUARE = 'foursquare';

	const P_TUMBLR = 'tumblr';

	const P_GOOGLEPLUS = 'googleplus';
}