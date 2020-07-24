<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="new-reply-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>На ваше задание был отправлен отклик. Для просмотра отклика перейдите по ссылке:</p>
    <p><?= Html::a('Посмотреть отклик', Url::toRoute("/task/view/{$data->task_id}", 'true')) ?></p>
</div>
