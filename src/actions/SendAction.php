<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 29.05.18
 * Time: 16:57
 */

namespace tina\postManager\actions;

use krok\queue\mailer\MailerJob;
use tina\postManager\interfaces\PostManagerInterface;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\mail\MessageInterface;
use yii\web\Controller;

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
     * @var MessageInterface message instance
     */
    public $message;

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
     * @throws InvalidConfigException
     */
    public function run()
    {
        $model = $this->postManager;
        $request = Yii::$app->getRequest();
        if ($request->getIsPost() && $model->populate($request->post())) {
            if (is_callable($this->message)) {
                $this->message = call_user_func($this->message, $model);
            }

            if ($this->message instanceof MessageInterface) {
                $job = Yii::createObject([
                    'class' => MailerJob::class,
                    'message' => $this->message,
                ]);
                Yii::$app->get('queue')->push($job);
            } else {
                throw new InvalidConfigException('Invalid data type: ' . get_class($this->message) . '. ' . MessageInterface::class . ' is expected.');
            }

            return $this->controller->redirect($this->successUrl);
        }

        return $this->controller->redirect($this->errorUrl);
    }
}
