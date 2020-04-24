<?php
use yii\helpers\Html;

?>
    <div class="main-container page-container">
        <section class="content-view">
            <div class="content-view__card">
                <div class="content-view__card-wrapper">
                    <div class="content-view__header">
                        <div class="content-view__headline">
                            <h1><?= $task->name ?></h1>
                            <span>Размещено в категории
                                    <a href="#" class="link-regular"><?= $task->category->name ?></a>
                                    <?=date_format(date_create($task->date_add), 'd-m-Y');?></span>
                        </div>
                        <b class="new-task__price new-task__price--clean content-view-price"><?= $task->budget ? Html::encode($task->budget) : ''; ?><b> ₽</b></b>
                        <div class="new-task__icon new-task__icon--clean content-view-icon"><?= $task->category->ico ?></div>
                    </div>
                    <div class="content-view__description">
                        <h3 class="content-view__h3">Общее описание</h3>
                        <p>
                            <?= $task->description ?>
                        </p>
                    </div>
                    <div class="content-view__attach">
                        <?php if (!empty($task->attachments)): ?>
                            <div class="content-view__attach">
                                <h3 class="content-view__h3">Вложения</h3>
                                <?php foreach ($task->attachments as $file): ?>
                                    <a href="#"><?php echo "/uploads/{$file->name}" ?></a>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div class="content-view__map">
                                <a href="#"><img src="../../img/map.jpg" width="361" height="292"
                                                 alt="Москва, Новый арбат, 23 к. 1"></a>
                            </div>
                            <div class="content-view__address">
                                <span class="address__town"><?= $task->city ? Html::encode($task->city->name) : ''; ?></span><br>
                                <span><?= $task->address ? Html::encode($task->address) : ''; ?></span>
                                <p>Вход под арку, код домофона 1122</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-view__action-buttons">
                    <button class=" button button__big-color response-button open-modal"
                            type="button" data-for="response-form">Откликнуться</button>
                    <button class="button button__big-color refusal-button open-modal"
                            type="button" data-for="refuse-form">Отказаться</button>
                    <button class="button button__big-color request-button open-modal"
                            type="button" data-for="complete-form">Завершить</button>
                </div>
            </div>
            <div class="content-view__feedback">
                <h2>Отклики <span>(<?= count($task->replies) ?>)</span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($task->replies as $reply): ?>
                    <div class="content-view__feedback-card">
                        <div class="feedback-card__top">
                            <a href="#"><img src="../../img/man-glasses.jpg" width="55" height="55"></a>
                            <div class="feedback-card__top--name">
                                <p><?= Html::a($reply->user->name, ['/user/view'],
                                        ['class' => 'link-regular']) ?></p>
                                <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                                <b><?= $reply->rating ?></b>
                            </div>
                            <span class="new-task__time"><?= date_format(date_create($task->date_add), 'd-m-Y'); ?></span>
                        </div>
                        <div class="feedback-card__content">
                            <p>
                                <?= $reply->description ?>
                            </p>
                            <span><?= $task->budget ?><b> ₽</b></span>
                        </div>
                        <div class="feedback-card__actions">
                            <a class="button__small-color request-button button"
                               type="button">Подтвердить</a>
                            <a class="button__small-color refusal-button button"
                               type="button">Отказать</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="connect-desk">
            <div class="connect-desk__profile-mini">
                <div class="profile-mini__wrapper">
                    <h3>Заказчик</h3>
                    <div class="profile-mini__top">
                        <img src="../../img/man-brune.jpg" width="62" height="62" alt="Аватар заказчика">
                        <div class="profile-mini__name five-stars__rate">
                            <p><?= $task->customer->name ?></p>
                        </div>
                    </div>
                    <p class="info-customer"><span><?= count($task->customer->tasks); ?> заданий</span><span class="last-"><?= date_format(date_create($task->customer->profiles->last_visit), 'd-m-Y'); ?></span></p>
                    <a href="#" class="link-regular">Смотреть профиль</a>
                </div>
            </div>
            <div id="chat-container">

                <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
                <?= $task->id ?>
                <chat class="connect-desk__chat"></chat>
            </div>
        </section>
    </div>
