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

    /** @var array optional fields */
    public $optional = [];

    /** @var array providers that will be displayed in the widget */
    public $providers = [ULogin::P_VKONTAKTE, ULogin::P_FACEBOOK, ULogin::P_TWITTER, ULogin::P_GOOGLE];

    /** @var array providers that will appear in the drop-down list widget */
    public $hidden = [ULogin::P_OTHER];

    /** @var string widget language */
    public $lang = ULogin::L_AUTO;

    /** @var bool verify User's email address */
    public $verifyEmail = false;

    /** @var string providers sort option */
    public $sortProviders = ULogin::S_RELEVANT;

    /** @var bool displays mobile ULogin interface when User logs in using mobile device */
    public $mobileButtons = true;

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
     * @throws \rmrevin\yii\ulogin\Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->redirect_uri)) {
            throw new Exception(\Yii::t('app', 'You must specify the "{param}".', ['{param}' => 'redirect_uri']));
        }

        \Yii::$app
            ->getView()
            ->registerJsFile(
                '//ulogin.ru/js/ulogin.js',
                ['position' => View::POS_HEAD]
            );
    }

    /**
     * Executes the widget.
     */
    public function run()
    {
        $widget_id = $this->getId();

        $widgetParams = [
            'display' => $this->display,
            'fields' => implode(',', $this->fields),
            'optional' => implode(',', $this->optional),
            'providers' => implode(',', $this->providers),
            'hidden' => implode(',', $this->hidden),
            'redirect_uri' => \Yii::$app->getUrlManager()->createAbsoluteUrl($this->redirect_uri)
        ];

        // lang param by default is not set
        // language is determined by user's browser locale
        if ($this->lang && $this->lang !== ULogin::L_AUTO) {
            $widgetParams['lang'] = $this->lang;
        }

        // relevant providers sorting is enabled by default
        if ($this->sortProviders && $this->sortProviders !== ULogin::S_RELEVANT) {
            $widgetParams['sort'] = $this->sortProviders;
        }

        // verification is disabled by default
        if ($this->verifyEmail) {
            $widgetParams['verify'] = $this->verifyEmail;
        }

        // mobile buttons display is enabled by default
        if (!$this->mobileButtons) {
            $widgetParams['mobilebuttons'] = $this->mobileButtons;
        }

        $action = str_replace(['&', '%2C'], [';', ','], http_build_query($widgetParams));

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
