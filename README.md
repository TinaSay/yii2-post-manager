Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist contrib/yii2-post-manager "*"
```

or add

```
"contrib/yii2-post-manager": "*"
```

to the require section of your `composer.json` file.

Configure
---------

backend:

```
    'modules' => [
        'postManager' => [
            'class' => \tina\postManager\Module::class,
            'viewPath' => '@tina/postManager/views/backend',
            'controllerNamespace' => 'tina\postManager\controllers\backend',
        ],
    ],
```
params:

```
    'menu' => [
        [
            'label' => 'PostManager',
            'items' => [
                [
                    'label' => 'postManager',
                    'url' => ['/postManager/default'],
                ],
            ],
        ],
    ],
```
console:

```
    'config' => [
        [
            'name' => 'postManager',
            'controllers' => [
                'default' => [
                    'index',
                    'list',
                    'send',
                ],
            ],
        ],
    ],
```
common:

```
     'definitions' => [
        \tina\postManager\interfaces\PostManagerInterface::class => \tina\postManager\models\TestModel::class,
        \tina\subscriber\filter\SubscriberFilterInterface::class=>\tina\subscriber\filter\SubscriberFilter::class,
        \tina\postManager\actions\SendAction::class => [
            'message' => function (\tina\postManager\interfaces\PostManagerInterface $model) {
                $message = Yii::createObject(\tina\postManager\Message::class);
                return $message->make($model);
            },
        ],
     ],   

```