<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 29.05.18
 * Time: 14:57
 */

namespace tina\postManager\types;

use krok\select2\Select2Widget;
use yii\helpers\Html;

/**
 * Class DropDownType
 *
 * @package tina\postManager\types
 */
class DropDownType extends Type
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var array
     */
    public $options = [
        'class' => 'form-control',
    ];

    /**
     * @return string
     */
    public function run()
    {
        return Select2Widget::widget([
            'selector' => Html::getInputId($this->model, $this->attribute),
            'model' => $this->model,
            'attribute' => $this->attribute,
            'items' => $this->items,
            'options' => $this->options,
        ]);
    }
}
