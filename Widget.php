<?php
/**
 * Widget.php
 * @author: Revin Roman <xgismox@gmail.com>
 */

namespace rmrevin\yii\ulogin;

use yii\helpers\Html;
use yii\web\View;

/**
 * Class Widget
 * @package rmrevin\yii\ulogin
 */
class Widget extends \yii\base\Widget
{

	/** @var string form factor */
	public $display = ULogin::D_SMALL;

	/** @var array fields that must be obtained from the social network */
	public $fields = [ULogin::F_FIRST_NAME, ULogin::F_LAST_NAME, ULogin::F_EMAIL];

	/** @var array providers that will be displayed in the widget */
	public $providers = [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_TWITTER, ULogin::P_GOOGLE];

	/** @var array providers that will appear in the drop-down list widget */
	public $hidden = [ULogin::P_OTHER];

	/**
	 * @example ['sign/in', 'type' => 'ulogin-response']
	 * @var array scheme for the formation of an URL to which the response will be returned ulogin
	 */
	public $redirect_uri = ['/'];

	/**
	 * @link https://ulogin.ru/faq.html
	 * @var bool whether to call the "uLogin.customInit()" button to initialize the widget.
	 */
	public $execute_custom_init = false;

	/**
	 * Initializes the widget.
	 * @throws ULoginException
	 */
	public function init()
	{
		parent::init();

		if (empty($this->redirect_uri)) {
			throw new ULoginException(\Yii::t('app', 'You must specify the "{param}".', ['{param}' => 'redirect_uri']));
		}

		\Yii::$app
			->getView()
			->registerJsFile(
				'//ulogin.ru/js/ulogin.js',
				[],
				['position' => View::POS_HEAD]
			);
	}

	/**
	 * Executes the widget.
	 */
	public function run()
	{
		$widget_id = $this->getId();

		$action = str_replace(['&', '%2C'], [';', ','], http_build_query([
			'display' => $this->display,
			'fields' => implode(',', $this->fields),
			'providers' => implode(',', $this->providers),
			'hidden' => implode(',', $this->hidden),
			'redirect_uri' => \Yii::$app->getUrlManager()->createAbsoluteUrl($this->redirect_uri)
		]));

		echo Html::tag('div', '', [
			'id' => $widget_id,
			'data-ulogin' => $action,
		]);

		if ($this->execute_custom_init === true) {
			\Yii::$app
				->getView()
				->registerJs("uLogin.customInit('$widget_id');");
		}
	}
}