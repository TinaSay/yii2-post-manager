<?php
/**
 * Created by PhpStorm.
 * User: nsign
 * Date: 30.05.18
 * Time: 9:40
 */

namespace tina\postManager\types;

use yii\helpers\Html;

/**
 * Class TextAreaType
 *
 * @package tina\postManager\types
 */
class TextAreaType extends Type
{
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
        return Html::activeTextarea($this->model, $this->attribute, $this->options);
    }
}
