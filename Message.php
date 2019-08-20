<?php

namespace tina\postManager;

use tina\postManager\interfaces\MessageInterface;
use tina\postManager\interfaces\PostManagerInterface;
use Yii;
use yii\base\Model;
use yii\mail\MailerInterface;
use yii\mail\MessageInterface as BaseMessageInterface;

/**
 * Class Message
 *
 * ```php
 * This is an example of the Message class. Not recommended to use in production.
 *
 * ```
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
     * @return BaseMessageInterface
     */
    public function make(PostManagerInterface $model): BaseMessageInterface
    {
        $message = $this->mailer->compose($model->template, [
            'model' => $model,
        ]);

        $message->setSubject($model->subject);
        $message->setTo($model->sendTo);
        $message->setFrom(Yii::$app->params['email']);
        $message->setHtmlBody($model->message);

        return $message;
    }
}
