<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 29.05.18
 * Time: 11:17
 */

namespace tina\postManager\actions;

use tina\postManager\interfaces\PostManagerInterface;
use yii\base\Action;
use tina\postManager\models\PostManager;

/**
 * Class PostManagerAction
 *
 * @package tina\postManager\actions
 */
class PostManagerAction extends Action
{
    /** @var string */
    public $view;
    /**
     * @var PostManagerInterface
     */
    protected $configure;

    /**
     * @return string
     */
    public function run(): string
    {
        $model = new PostManager();

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }

}