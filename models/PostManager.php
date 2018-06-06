<?php

namespace tina\postManager\models;

use tina\postManager\types\DropDownType;
use yii\base\Model;
use tina\postManager\interfaces\PostManagerInterface;
use yii\helpers\ArrayHelper;
use tina\subscriber\filter\SubscriberFilterInterface;

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

    const GROUP_UZB = 'Узбекистан';
    const GROUP_RUS = 'Россия';

    /**
     * @var SubscriberFilterInterface
     */
    protected $filter;

    /**
     * PostManager constructor.
     *
     * @param SubscriberFilterInterface $filter
     * @param array $config
     */
    public function __construct(SubscriberFilterInterface $filter, array $config = [])
    {
        $this->filter = $filter;
        parent::__construct($config);
    }

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
            'sendTo' => [
                'class' => DropDownType::class,
                'config' => [
                    'items' => $this->getEmails(),
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
     * @return array
     */
    public function subscribersFinder($country)
    {
        $query = $this->filter->filter([
            'country' => $country,
        ]);
        return $query;
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        $query = $this->filter->filter([
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
            self::TEMPLATE_TYPICAL => 'Шаблон 1',
            self::TEMPLATE_SPECIAL => 'Шаблон 2',
        ];
    }

    /**
     * @return array
     */
    public static function getGroups()
    {
        return [
            self::GROUP_UZB,
            self::GROUP_RUS,
        ];
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return ArrayHelper::getValue(static::getGroups(), $this->sendTo);
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
