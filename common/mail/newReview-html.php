<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="new-message-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>У вас новый отзыв. Для его просмотра перейдите по ссылке:</p>
    <p><?= Html::a('Посмотреть отзыв', Url::toRoute("/user/view/{$data->task_id}", 'true')) ?></p>
</div>