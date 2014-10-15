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
Добавьте в конфигурационный файл вашего приложения:
```
modules => [
    'cackle' => [
                'class' => ostashevdv\cackle\Module::className(),
                'siteId' => YOUR_ID,
                'accountAPIKey' => 'YOUR_KEY',
                'siteAPIKey' => 'YOUR_KEY',
            ],
]
```
Более подробную информацию, как получить `accountAPIKey` и `siteAPIKey` Вы можете получить на странице [http://cackle.ru/help/comment-sync]
Выполните миграцию:
```
php yii mgrate/up --migrationPath="@vendor/ostashevdv/yii2-cackle/migrations"
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

**Синхронизация комментариев**
Для запуска синхронизации комментариев, выполните консольную команду:
```
php yii cackle/sync
```
Более подробную информацию о механизме синхронизации Вы можете получить на странице [http://cackle.ru/help/comment-sync]