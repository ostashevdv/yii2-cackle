<?php
/**
 * Created by Ostashev Dmitriy <ostashevdv@gmail.com>
 * Date: 10.10.14 14:45
 * ------------------------------------------------------------
 */
namespace ostashevdv\cackle;

use yii\web\View;
use yii\helpers\Json;

class Widget extends \yii\base\Widget
{
    /**
     * @var array $widget массив настроек виджета
     * подробнее на http://cackle.ru/help/widget-api
     */
    public $widget = [];

    /** @var string $jsInitWidget инициализация JavaScript переменной Cackle */
    protected $jsInitWidget = <<<'JS'
cackle_widget = window.cackle_widget || [];
JS;

    /** @var string $jsLoadWidget загрузка js скрипта */
    protected $jsLoadWidget = <<<'JS'
(function() {
var mc = document.createElement('script');
mc.type = 'text/javascript';
mc.async = true;
mc.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cackle.me/widget.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mc, s.nextSibling);
})();
JS;


    public function init()
    {
        parent::init();
        if (!is_array($this->widget)) {
            throw new InvalidConfigException("\$options - must be array() [[widget=>'', id=>1, ...],[],[]]");
        } else {
            foreach($this->widget as $widget) {
                if (!array_key_exists('widget',$widget)) {
                    throw new InvalidConfigException("\$options - must be array() [[widget=>'', id=>1, ...],[],[]]");
                }
            }
        }
        return true;
    }

    public function run()
    {
        parent::run();

        foreach ($this->widget as $widget) {
            $js[] = 'cackle_widget.push('.Json::encode($widget).');';
        }
        $js = implode(PHP_EOL, $js);

        $this->getView()->registerJs($js);
        $this->getView()->registerJs($this->jsInitWidget, View::POS_HEAD, 'cackle_init');
        $this->getView()->registerJs($this->jsLoadWidget, View::POS_END, 'cackle_load');
    }
}