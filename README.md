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
            'label' => 'Post Manager',
            'name' => 'postManager',
            'controllers' => [
                'default' => [
                    'label' => 'Post Manager',
                    'actions' =>[
                        'list',
                        'send',
                    ],
                ],
            ],
        ],
    ],
```

common:

```
     'definitions' => [
        \tina\postManager\interfaces\MessageInterface::class => \app\modules\postManager\Message::class,
        \tina\postManager\interfaces\PostManagerInterface::class => \tina\postManager\models\PostManager::class,
        \tina\postManager\actions\SendAction::class => [
            'successUrl' => ['/postManager/default'],
            'errorUrl' => ['/postManager/default'],
        ],
     ],   

```

Use
---

Make file Message.php like in the example "Message.php". Alter it as per your requirements. 
