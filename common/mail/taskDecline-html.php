<?php
use yii\helpers\Html;

?>
<div class="task-decline-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>Исполнитель отказался от выполнения вашего задания. Для просмотра задания перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть задание', "/task/view/<?=$data->task_id?>") ?></p>
</div>
