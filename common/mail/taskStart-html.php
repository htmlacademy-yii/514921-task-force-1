<?php
use yii\helpers\Html;

?>
<div class="task-start-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>Вы были назначены на задание. Для просмотра задания перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть задание', "/task/view/<?=$data->task_id?>") ?></p>
</div>