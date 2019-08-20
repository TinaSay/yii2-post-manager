<?php

namespace tina\postManager\controllers\backend;

use krok\system\components\backend\Controller;
use tina\postManager\actions\PostManagerAction;
use tina\postManager\actions\SendAction;

/**
 * Class DefaultController
 *
 * @package tina\postManager\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * @var string
     */
    public $defaultAction = 'list';

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'list' => [
                'class' => PostManagerAction::class,
                'view' => 'index.php',
            ],
            'send' => [
                'class' => SendAction::class,
            ],
        ];
    }
}
