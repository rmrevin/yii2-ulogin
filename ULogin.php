<?php
/**
 * ULogin.php
 * @author: Revin Roman <xgismox@gmail.com>
 */

namespace rmrevin\yii\ulogin;

/**
 * Class ULogin
 * @package rmrevin\yii\ulogin
 */
class ULogin
{

    /**
     * @param array $config
     * @return string
     */
    public static function widget($config = [])
    {
        return Widget::widget($config);
    }

    /** constants for $display param */
    const D_SMALL = 'small';
    const D_PANEL = 'panel';
    const D_WINDOW = 'window';

    /** constants for $fields param */
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

    /** constants for $providers and $hidden params */
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
    const P_DUDU = 'dudu';
    const P_UID = 'uid';
    const P_INSTAGRAM = 'instagram';

    /** constants for $lang param */
    const L_AUTO = 'auto';
    const L_RU = 'ru';
    const L_EN = 'en';
    const L_UK = 'uk';
    const L_FR = 'fr';
    const L_DE = 'de';

    /** constants for $sort param */
    const S_DEFAULT = 'default';
    const S_RELEVANT = 'relevant';
}
