<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 29.05.18
 * Time: 16:57
 */

namespace tina\postManager\actions;

use tina\postManager\interfaces\MessageInterface;
use tina\postManager\interfaces\PostManagerInterface;
use Yii;
use yii\base\Action;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class SendAction
 *
 * @package tina\postManager\actions
 */
class SendAction extends Action
{
    /**
     * @var string|array
     */
    public $successUrl;

    /**
     * @var string|array
     */
    public $errorUrl;

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * @var PostManagerInterface
     */
    protected $postManager;

    /**
     * SendAction constructor.
     *
     * @param string $id
     * @param Controller $controller
     * @param MessageInterface $message
     * @param PostManagerInterface $postManager
     * @param array $config
     */
    public function __construct(
        string $id,
        Controller $controller,
        MessageInterface $message,
        PostManagerInterface $postManager,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);

        $this->message = $message;
        $this->postManager = $postManager;
    }

    /**
     * @return Response
     */
    public function run()
    {
        $model = $this->postManager;
        $request = Yii::$app->getRequest();

        if ($request->getIsPost() && $model->populate($request->post())) {
            $this->message->send($model);

            Yii::$app->getSession()->addFlash('info', 'Успешно отправленно');

            return $this->controller->redirect($this->successUrl);
        }

        Yii::$app->getSession()->addFlash('danger', 'Ошибка отправки');

        return $this->controller->redirect($this->errorUrl);
    }
}
