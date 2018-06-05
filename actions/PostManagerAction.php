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
use yii\web\Controller;

/**
 * Class PostManagerAction
 *
 * @package tina\postManager\actions
 */
class PostManagerAction extends Action
{
    /**
     * @var string
     */
    public $view;

    /**
     * @var PostManagerInterface
     */
    protected $postManager;

    /**
     * PostManagerAction constructor.
     *
     * @param string $id
     * @param Controller $controller
     * @param PostManagerInterface $postManager
     * @param array $config
     */
    public function __construct(
        string $id,
        Controller $controller,
        PostManagerInterface $postManager,
        array $config = []
    ) {
        $this->postManager = $postManager;
        parent::__construct($id, $controller, $config);
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $model = $this->postManager;

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}
