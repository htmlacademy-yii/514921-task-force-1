<?php

use TaskForce\helpers\UrlHelper;
use yii\helpers\Html;

?>

<div class="content-view__feedback-card user__search-wrapper">
    <div class="feedback-card__top">
        <div class="user__search-icon">
            <a href="/user/view/<?= $model->id?>"><img src="<?= UrlHelper::getUserAvatarUrl($model);?>" width="65" height="65"></a>
            <span><?= $model->completedTasksCount ?? 0; ?> заданий</span>
            <span><?= $model->getReviews()->count() ?> отзывов</span>
        </div>
        <div class="feedback-card__top--name user__search-card">
            <p class="link-name"><a href="/user/view/<?= $model->id?>" class="link-regular"><?=$model->name?></a></p>
                <?php for ($i = 0; $i < 5; $i++) : ?>
                    <span <?= (int)$model->getUserRating() > $i ? ''
                        : 'class="star-disabled"'; ?>></span>
                <?php endfor; ?>
            <b><?= $model->getUserRating()?></b>
            <p class="user__search-content">
                <?=$model->profiles->about?>
            </p>
        </div>
        <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($model->profiles->last_visit) ?></span>
    </div>
    <div class="link-specialization user__search-link--bottom">
        <?php foreach ($model->userCategories as $category): ?>
            <?= Html::a($category->category->name, ['/users', 'categories[]' => $category->id],
                ['class' => 'link-regular']) ?>
        <?php endforeach; ?>
    </div>
</div>