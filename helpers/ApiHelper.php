<?php
/**
 * Created by Ostashev Dmitriy <ostashevdv@gmail.com>
 * Date: 15.10.14 Time: 14:09
 * -------------------------------------------------------------
 */

namespace ostashevdv\cackle\helpers;


class ApiHelper
{

    public static function createUrl($modified=null, $page=null)
    {
        $cfg = \Yii::$app->getModule('cackle');
        $vars = [
            'id' => $cfg->siteId,
            'accountApiKey' => $cfg->accountAPIKey,
            'siteApiKey' => $cfg->siteAPIKey,
            'modified' => $modified,
            'page' => $page

        ];
        foreach ($vars as $k=>$v) {
            $url[]= "{$k}={$v}";
        }
        return "http://cackle.me/api/2.0/comment/list.json?".implode('&',$url);
    }

    /** Обертка над соединениями в curl. */
    public static function curlInit()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/x-www-form-urlencoded; charset=utf-8']);
        return $ch;
    }
    public static function curlExec(&$ch, $url)
    {
        curl_setopt($ch, CURLOPT_URL, $url);
        return curl_exec($ch);
    }
    public static function curlClose(&$ch)
    {
        curl_close($ch);
    }
} 