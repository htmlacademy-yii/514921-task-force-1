<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="new-message-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>Вам отправили новое сообщение в чате на странице задания. Для его просмотра перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть сообщение', Url::toRoute("/task/view/{$data->task_id}", 'true')) ?></p>
</div>