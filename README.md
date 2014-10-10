yii2-cackle
===========
** В РАЗРАБОТКЕ! НЕ ИСПОЛЬЗОВАТЬ! **

Библиотека для работы с виджетами Cackle.


Установка
------------
Добавьте в секцию require вашего файла `composer.json`
```
"ostashevdv/yii2-cackle": "*"
```

Использование
-----
**Виджет комментариев**
```php
<?php
    echo Html::tag('div','',['id'=>'mc-container']);
    \ostashevdv\cackle\Widget::widget(['widget'=>[
            'comment' => [
                'widget'=>'Comment',
                'id'=>1,
                'channel'=>12355,
                'container'=>'mc-container',
                'ssoProvider' => [
                    'name'=> 'Sign-in by ajax.me',
                    'url'=> 'http://ajax.me/sign',
                    'logo'=> 'http://ajax.me/logo.png',
                    'width'=> 64,
                    'height'=> 64
                ],
                'callback' => [
                    'create' => '[function(comment) { console.log(comment); }]',
                    'edit' => '[function(comment) { console.log(comment); }]'
                ]
            ]
    ]])
?>