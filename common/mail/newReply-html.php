<?php
use yii\helpers\Html;

?>
<div class="new-reply-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>На ваше задание был отправлен отклик. Для просмотра отклика перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть отклик', "/task/view/<?=$data->task_id?>") ?></p>
</div>
