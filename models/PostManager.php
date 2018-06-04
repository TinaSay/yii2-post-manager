<?php

namespace tina\postManager\models;

use tina\postManager\types\DropDownType;
use yii\base\Model;
use tina\postManager\interfaces\PostManagerInterface;
use yii\helpers\ArrayHelper;
use tina\subscriber\filter\SubscriberFilter;

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

    const TEMPLATE_1 = '@tina/postManager/mail/template1';
    const TEMPLATE_2 = '@tina/postManager/mail/template2';

    const GROUP_1 = 'Узбекистан';
    const GROUP_2 = 'Россия';

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
    public static function attributeTypes(): array
    {
        return [
            'sendTo' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => static::filter(),
                ],
            ],
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
     * @param $country
     *
     * @return array|\tina\subscriber\models\Subscriber[]
     */
    public static function subscribersFinder($country)
    {
        $subscriberFilter = new SubscriberFilter();

        $query = $subscriberFilter->filter([
            'country' => $country,
        ]);
        return $query;
    }

    /**
     * @return array|\tina\subscriber\models\Subscriber[]
     */
    public static function filter()
    {
        $subscriberFilter = new SubscriberFilter();
        $query = $subscriberFilter->filter([
            'and',
            ['like', 'email', 'oo'],
            ['like', 'city', 'Дубна'],
        ]);
        return ArrayHelper::map($query, 'email', 'email');
    }

    /**
     * @return array
     */
    public static function getTemplates(): array
    {
        return [
            self::TEMPLATE_1 => 'Шаблон 1',
            self::TEMPLATE_2 => 'Шаблон 2',
        ];
    }

    /**
     * @return array
     */
    public static function getGroups()
    {
        return [
            self::GROUP_1,
            self::GROUP_2,
        ];
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return ArrayHelper::getValue(static::getGroups(), $this->sendTo);
    }
}
