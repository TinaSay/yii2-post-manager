<?php

namespace tina\postManager\models;

use krok\tinymce\TinyMceWidget;
use tina\postManager\interfaces\PostManagerInterface;
use tina\postManager\types\DropDownType;
use yii\base\Model;

/**
 * This is the model class for table "{{%subscriber}}".
 *
 * @property string $sendTo
 * @property string $subject
 * @property string $message
 * @property string $template
 *
 */
class PostManager extends Model implements PostManagerInterface
{
    /**
     * @var string
     */
    public $sendTo;
    /**
     * @var string
     */
    public $subject;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $template;

    const TEMPLATE_TYPICAL = '@tina/postManager/mail/typical';
    const TEMPLATE_SPECIAL = '@tina/postManager/mail/special';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sendTo', 'subject', 'message', 'template'], 'required'],
            [['sendTo'], 'email'],
            [['subject', 'template'], 'string', 'max' => 64],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sendTo' => 'Кому',
            'subject' => 'Тема',
            'message' => 'Текст сообщения',
            'template' => 'Шаблон',
        ];
    }

    /**
     * @return array
     */
    public function attributeTypes(): array
    {
        return [
            'sendTo' => 'text',
            'subject' => 'text',
            'message' => [
                'class' => TinyMceWidget::class,
            ],
            'template' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::getTemplates(),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getTemplates(): array
    {
        return [
            self::TEMPLATE_TYPICAL => 'Обычный',
            self::TEMPLATE_SPECIAL => 'Праздничный',
        ];
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function populate(array $data): bool
    {
        return $this->load($data);
    }
}
