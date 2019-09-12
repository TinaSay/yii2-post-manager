<?php

namespace tina\postManager;

use krok\queue\mailer\MailerJob;
use tina\postManager\interfaces\MessageInterface;
use tina\postManager\interfaces\PostManagerInterface;
use Yii;
use yii\base\Model;
use yii\mail\MailerInterface;

/**
 * Class Message
 *
 * @package tina\postManager
 */
class Message implements MessageInterface
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * Message constructor.
     *
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param PostManagerInterface|Model|object $model
     *
     * @return bool
     */
    public function send(PostManagerInterface $model): bool
    {
        $message = $this->mailer->compose($model->template, [
            'model' => $model,
        ]);

        $message->setSubject($model->subject);
        $message->setTo($model->sendTo);
        $message->setFrom(Yii::$app->params['email']);

        $job = Yii::createObject([
            'class' => MailerJob::class,
            'message' => $message,
        ]);

        return Yii::$app->get('queue')->push($job);
    }
}
