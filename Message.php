<?php

namespace tina\postManager;

use League\Flysystem\FilesystemInterface;
use tina\postManager\interfaces\MessageInterface;
use tina\postManager\interfaces\PostManagerInterface;
use Yii;
use yii\helpers\FileHelper;
use yii\mail\MailerInterface;

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
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * @var PostManagerInterface
     */
    protected $postManager;

    /**
     * Message constructor.
     *
     * @param MailerInterface $mailer
     * @param FilesystemInterface $filesystem
     * @param PostManagerInterface $postManager
     */
    public function __construct(
        MailerInterface $mailer,
        FilesystemInterface $filesystem,
        PostManagerInterface $postManager
    ) {
        $this->mailer = $mailer;
        $this->filesystem = $filesystem;
        $this->postManager = $postManager;
    }

    /**
     * @param $model
     *
     * @return mixed|\yii\mail\MessageInterface
     */
    public function make($model)
    {
        $message = $this->mailer->compose($model->template, [
            'model' => $model,
        ]);

        $message->setTo($model->sendTo);
        $message->setSubject($model->subject);
        $message->setFrom(Yii::$app->params['email']);
        $szSearchPattern = '/<img([^src]+)src="\/attachment\/editor\/([^"]+)"/';
        $content = $model->message;

        if (preg_match_all($szSearchPattern, $content, $jpegs)) {
            foreach ($jpegs[2] as $jpeg) {
                $embedContent = $this->filesystem->getContentEditor($jpeg);
                $cid = $message->embedContent($embedContent,
                    ['contentType' => FileHelper::getMimeTypeByExtension($jpeg)]);
                $content = str_replace('/attachment/editor/' . $jpeg, $cid, $content);
            }
        }
        $message->setHtmlBody($content);
        return $message;
    }
}
