<?php

use yii\helpers\Html;

?>




<div class="new-task__card">
    <div class="new-task__title">
        <a href="/task/view/<?= $model->id?>" class="link-regular"><h2><?=$model->name?></h2></a>
        <a  class="new-task__type link-regular" href="#"><p><?=$model->category->name?></p></a>
    </div>
    <div class="new-task__icon new-task__icon--<?=$model->category->ico?>"></div>
    <p class="new-task_description">
        <?=$model->description?>
    </p>
    <b class="new-task__price new-task__price--<?=$model->category->ico?>">
        <?php if ($model->budget): ?>
            <?= Html::encode($model->budget) ?><b> ₽</b>
        <?php endif; ?>
    </b>
    <p class="new-task__place"><?=$model->address?></p>
    <span class="new-task__time"><?=Yii::$app->formatter->asRelativeTime($model->date_add);?></span>
</div>