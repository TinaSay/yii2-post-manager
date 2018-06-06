<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model \tina\postManager\interfaces\PostManagerInterface | \tina\postManager\models\PostManager */
/* @var $this yii\web\View */
/* @var  $form \yii\widgets\ActiveForm */

$this->title = Yii::t('system', 'postManager');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="card-content">
        <?php $form = ActiveForm::begin(['action' => ['send']]); ?>

        <?php foreach ($model->attributeTypes() as $attribute => $item) : ?>

            <?php if (is_array($item)) : ?>

                <?= $form->field($model, $attribute)->widget($item['class'], $item['config'] ?? []) ?>

            <?php elseif (is_string($item)) : ?>

                <?= $form->field($model, $attribute)->input($item) ?>
            <?php endif; ?>

        <?php endforeach; ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('system', 'Send'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
