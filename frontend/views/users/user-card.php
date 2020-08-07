<?php

use yii\helpers\Html;

?>

<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <a href="/user/view/<?= $model->id?>"><img src="/uploads/avatars/<?=$model->profiles->avatar ?? '../../img/man-glasses.jpg';?>" width="65" height="65"></a>
            <span><?= count($model->tasks) ?> заданий</span>
            <span><?= count($model->reviews) ?> отзывов</span>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name"><a href="/user/view/<?= $model->id?>" class="link-regular"><?=$model->name?></a></p>
            <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
            <b>4.25</b>
            <p class="user__search-content">
                <?=$model->profiles->about?>
            </p>
        </div>
        <span class="new-task__time"><?=$model->profiles->last_visit?></span>
    </div>
    <div class="link-specialization user__search-link--bottom">
        <?php foreach ($model->userCategories as $category): ?>
            <?= Html::a($category->category->name, ['/users', 'categories[]' => $category->id],
                ['class' => 'link-regular']) ?>
        <?php endforeach; ?>
    </div>
</div>