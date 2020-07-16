<?php
use yii\helpers\Html;

?>
<div class="new-message-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>Вам отправили новое сообщение в чате на странице задания. Для его просмотра перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть сообщение', "/task/view/<?=$data->task_id?>") ?></p>
</div>