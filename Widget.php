<?php
/**
 * Widget.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace rmrevin\yii\ulogin;

use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\UrlManager;
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
    public $language;

    /**
     * @var string widget language
     * @deprecated
     */
    public $lang;

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
    public $redirectUri;

    /**
     * @example ['sign/in', 'type' => 'ulogin-response']
     * @var array scheme for the formation of an URL to which the response will be returned ulogin
     * @deprecated
     */
    public $redirect_uri;

    /**
     * @link https://ulogin.ru/faq.html
     * @var bool whether to call the "uLogin.customInit()" button to initialize the widget.
     */
    public $executeCustomInit = false;

    /**
     * @link https://ulogin.ru/faq.html
     * @var bool whether to call the "uLogin.customInit()" button to initialize the widget.
     * @deprecated
     */
    public $execute_custom_init = false;

    /** @var string|null name of js function - callback for `ready` event */
    public $onReady;

    /** @var string|null name of js function - callback for `open` event */
    public $onOpen;

    /** @var string|null name of js function - callback for `close` event */
    public $onClose;

    /** @var string|null name of js function - callback for `receive` event */
    public $onReceive;

    /** @var string|UrlManager */
    public $urlManager = 'urlManager';

    /**
     * Initializes the widget.
     * @throws \rmrevin\yii\ulogin\Exception
     */
    public function init()
    {
        parent::init();

        if (empty($this->redirectUri) && !empty($this->redirect_uri)) {
            \Yii::warning(\Yii::t('app', 'You use deprecated param: {param}', ['param' => 'redirect_uri']), __CLASS__);
            $this->redirectUri = $this->redirect_uri;
        }

        if (empty($this->language) && !empty($this->lang)) {
            \Yii::warning(\Yii::t('app', 'You use deprecated param: {param}', ['param' => 'lang']), __CLASS__);
            $this->language = $this->lang;
        }

        if (empty($this->redirectUri)) {
            throw new Exception(\Yii::t('app', 'You must specify the "{param}".', ['{param}' => 'redirectUri']));
        }

        $this->getView()
            ->registerJsFile('https://ulogin.ru/js/ulogin.js', ['position' => View::POS_HEAD]);
    }

    /**
     * Executes the widget.
     */
    public function run()
    {
        $widget_id = $this->getId();

        $urlManager = is_string($this->urlManager)
            ? \Yii::$app->get($this->urlManager, false)
            : $this->urlManager;

        $widget_params = [
            'display' => $this->display,
            'fields' => implode(',', $this->fields),
            'optional' => implode(',', $this->optional),
            'providers' => implode(',', $this->providers),
            'hidden' => implode(',', $this->hidden),
            'redirect_uri' => $urlManager->createAbsoluteUrl($this->redirectUri)
        ];

        // lang param by default is not set
        // language is determined by user's browser locale
        if ($this->language && $this->language !== ULogin::L_AUTO) {
            $widget_params['lang'] = $this->language;
        }

        // relevant providers sorting is enabled by default
        if ($this->sortProviders && $this->sortProviders !== ULogin::S_RELEVANT) {
            $widget_params['sort'] = $this->sortProviders;
        }

        // verification is disabled by default
        if ($this->verifyEmail) {
            $widget_params['verify'] = $this->verifyEmail;
        }

        // mobile buttons display is enabled by default
        if (!$this->mobileButtons) {
            $widget_params['mobilebuttons'] = $this->mobileButtons;
        }

        $action = $this->buildParams($widget_params);

        echo Html::tag('div', '', [
            'id' => $widget_id,
            'data-ulogin' => $action,
        ]);

        if ($this->executeCustomInit === true) {
            $this->getView()->registerJs(sprintf('uLogin.customInit(%s);', Json::encode($widget_id)));
        }

        $this->registerCallback($widget_id, 'ready', $this->onReady);
        $this->registerCallback($widget_id, 'open', $this->onOpen);
        $this->registerCallback($widget_id, 'close', $this->onClose);
        $this->registerCallback($widget_id, 'receive', $this->onReceive);
    }

    protected function registerCallback($widget_id, $event, $function)
    {
        if (!empty($function)) {
            $script = sprintf(
                'uLogin.setStateListener(%s, %s, %s);',
                Json::encode($widget_id),
                Json::encode($event),
                $function
            );

            $this->getView()
                ->registerJs($script);
        }
    }

    /**
     * @param array $params
     * @return string
     */
    protected function buildParams($params)
    {
        return str_replace(
            ['&', '%2C'],
            [';', ','],
            http_build_query($params)
        );
    }
}
