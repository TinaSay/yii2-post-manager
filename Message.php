<?php

namespace tina\postManager;

use tina\postManager\interfaces\PostManagerInterface;
use tina\postManager\models\PostManager;
use tina\subscriber\filter\SubscriberFilterInterface;
use yii\mail\MailerInterface;
use tina\postManager\interfaces\MessageInterface;
use Yii;
use yii\web\HttpException;
use League\Flysystem\FilesystemInterface;

/**
 * Class Message
 *
 * @package tina\postManager
 */
class Message implements MessageInterface
{
    public $template;

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
     * @var SubscriberFilterInterface
     */
    protected $filter;

    /**
     * Message constructor.
     *
     * @param MailerInterface $mailer
     * @param FilesystemInterface $filesystem
     * @param PostManagerInterface $postManager
     * @param SubscriberFilterInterface $filter
     */
    public function __construct(
        MailerInterface $mailer,
        FilesystemInterface $filesystem,
        PostManagerInterface $postManager,
        SubscriberFilterInterface $filter
    ) {
        $this->mailer = $mailer;
        $this->filesystem = $filesystem;
        $this->postManager = $postManager;
        $this->filter = $filter;
    }

    /**
     * @param $model PostManager|PostManagerInterface
     *
     * @return mixed|\yii\mail\MessageInterface
     * @throws HttpException
     */
    public function make($model)
    {
        $message = $this->mailer->compose($model->template, [
            'model' => $model,
        ]);

        if ($model->getGroup()) {
            $subscribers = $model->subscribersFinder($model->getGroup());
            if ($subscribers === null) {
                throw new HttpException(404, 'The requested Item could not be found.');
            }
            foreach ($subscribers as $subscriber) {
                $mail[] = $subscriber->email;
                $message->setTo($mail);
            }
        } else {
            $message->setTo($model->sendTo);
        }
        $content = $model->message;
        $message->setSubject($model->subject);
        $message->setFrom(Yii::$app->params['email']);
        $szSearchPattern = '/<img(?:.+)src="?\'?([^\"\']+)/';
        preg_match_all($szSearchPattern, $content, $jpegs);

        foreach ($jpegs[1] as $jpeg) {
            $filePath = Yii::getAlias('@public') . strstr($jpeg, '/editor/');
            if ($filePath) {
                $cid = $message->embed($filePath);
                $content = str_replace($jpeg, $cid, $content);
            }
        }

        $message->setHtmlBody($content);

        return $message;
    }
}
