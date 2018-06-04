<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 29.05.18
 * Time: 16:57
 */

namespace tina\postManager\actions;

use tina\postManager\models\PostManager;
use yii\base\Action;
use Yii;
use yii\mail\MessageInterface;
use krok\queue\mailer\MailerJob;
use yii\base\InvalidConfigException;

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
     * @throws InvalidConfigException
     */
    public function run()
    {
        $model = new PostManager();
        if ($model->load(Yii::$app->request->post())) {
            if (is_callable($this->message)) {
                $this->message = call_user_func($this->message, $model);
            }
            if (is_array($this->message)) {
                foreach ($this->message as $mail) {
                    if ($mail instanceof MessageInterface) {
                        $job = Yii::createObject([
                            'class' => MailerJob::class,
                            'message' => $mail,
                        ]);
                        Yii::$app->get('queue')->push($job);
                    } else {
                        throw new InvalidConfigException('Invalid data type: ' . get_class($this->message) . '. ' . MessageInterface::class . ' is expected.');
                    }
                }
            } elseif ($this->message instanceof MessageInterface) {
                $job = Yii::createObject([
                    'class' => MailerJob::class,
                    'message' => $this->message,
                ]);
                Yii::$app->get('queue')->push($job);
            } else {
                throw new InvalidConfigException('Invalid data type: ' . get_class($this->message) . '. ' . MessageInterface::class . ' is expected.');
            }
        } else {
            return $this->controller->redirect($this->errorUrl);
        }
        return $this->controller->redirect($this->successUrl);
    }
}
