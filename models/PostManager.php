<?php

namespace tina\postManager\models;

use tina\postManager\types\DropDownType;
use yii\base\Model;
use tina\postManager\interfaces\PostManagerInterface;

/**
 * This is the model class for table "{{%subscriber}}".
 *
 * @property array $sendTo
 * @property string $subject
 * @property string $message
 * @property string $template
 *
 */
class PostManager extends Model implements PostManagerInterface
{
    public $sendTo;
    public $subject;
    public $message;
    public $template;

    const TEMPLATE_TYPICAL = '@tina/postManager/mail/template1';
    const TEMPLATE_SPECIAL = '@tina/postManager/mail/template2';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sendTo', 'subject', 'message', 'template'], 'required'],
            [['sendTo'], 'string'],
            [['subject', 'template'], 'string', 'max' => 64],
            [['message'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sendTo' => 'Адресаты',
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
                'class' => \krok\tinymce\TinyMceWidget::class,
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
