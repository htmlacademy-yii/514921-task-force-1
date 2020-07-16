<?php
use yii\helpers\Html;

?>
<div class="new-message-email">
    <p>Здравствуйте, <?= Html::encode($data->user->name) ?>,</p>

    <p>У вас новый отзыв. Для его просмотра перейдите по ссылке:</p>

    <p><?= Html::a('Посмотреть отзыв', "/user/view/<?=$data->user_id?>") ?></p>
</div>