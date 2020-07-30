<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="task-complete-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>.Задание завершено. Для просмотра задания перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть задание', Url::toRoute("/task/view/{$data->task_id}", 'true')) ?></p>
</div>
