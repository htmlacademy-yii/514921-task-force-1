<?php
use yii\helpers\Html;

?>
<div class="task-complete-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>.Задание завершено. Для просмотра задания перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть задание', "/task/view/<?=$data->task_id?>") ?></p>
</div>
