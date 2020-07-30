<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="task-start-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>Вы были назначены на задание. Для просмотра задания перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть задание', Url::toRoute("/task/view/{$data->task_id}", 'true')) ?></p>
</div>