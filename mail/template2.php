<?php

/* @var $model \tina\postManager\models\PostManager */

?>
<h3>Another cool template</h3>

<p>Letter sent:</p>

<div>
    Send to: <?= $model->sendTo ?>
    Subject is: <?= $model->subject ?>
    Message is: <?= $model->message ?>
    Template is: <?= $model->template ?>
</div>
<p>С уважением,
    почтовый робот N.</p>