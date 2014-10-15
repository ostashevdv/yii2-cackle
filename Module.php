<?php
/**
 * Created by Ostashev Dmitriy <ostashevdv@gmail.com>
 * Date: 13.10.14 Time: 12:11
 * -------------------------------------------------------------
 */

namespace ostashevdv\cackle;


class Module extends \yii\base\Module
{
    public  $siteId;
    public  $accountAPIKey;
    public  $siteAPIKey;

    public function init()
    {
        //Консольные контроллеры в commands
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'ostashevdv\cackle\commands';
        }

        return parent::init();
    }
} 