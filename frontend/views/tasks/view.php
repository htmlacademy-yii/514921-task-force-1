<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$fieldConfig = [
    'template' => "<p>{label}{input}{error}</p>",
    'labelOptions' => ['class' => 'form-modal-description'],
];
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
                                    <a href="/uploads/<?=$file->name?>"><?=Html::encode($file->name); ?></a>
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
                    <?php if ($postedReply['user_id'] !== $currentUser->id) : ?>
                    <button class=" button button__big-color response-button open-modal"
                            type="button" data-for="response-form">Откликнуться</button>
                    <?php endif; ?>
                    <button class="button button__big-color refusal-button open-modal"
                            type="button" data-for="refuse-form">Отказаться</button>
                    <button class="button button__big-color request-button open-modal"
                            type="button" data-for="complete-form">Завершить</button>
                </div>
            </div>
            <?php if (($task->replies && $postedReply['user_id'] === $currentUser->id) || $currentUser->id === $task->customer_id) : ?>
            <div class="content-view__feedback">
                <h2>Отклики <span>(<?= count($task->replies) ?>)</span></h2>
                <div class="content-view__feedback-wrapper">
                    <?php if ($currentUser->id === $task->customer_id) : ?>
                        <?php foreach ($task->replies as $reply) : ?>
                            <div class="content-view__feedback-card">
                                <div class="feedback-card__top">
                                    <a href="#"><img src="../../img/man-glasses.jpg" width="55" height="55"></a>
                                    <div class="feedback-card__top--name">
                                        <p><?= Html::a($reply->user->name, ["/user/view/{$reply->user->id}"],
                                                ['class' => 'link-regular']) ?></p>
                                        <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                                        <b><?= $reply->rating ?></b>
                                    </div>
                                    <span class="new-task__time"><?= date_format(date_create($reply->date_add), 'd-m-Y'); ?></span>
                                </div>
                                <div class="feedback-card__content">
                                    <p>
                                        <?= $reply->description ?>
                                    </p>
                                    <span><?= $reply->price ?><b> ₽</b></span>
                                </div>
                                <div class="feedback-card__actions">
                                    <a class="button__small-color request-button button"
                                       type="button">Подтвердить</a>
                                    <a class="button__small-color refusal-button button"
                                       type="button">Отказать</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else:#  $postedReply['user_id'] === $currentUser->id ?>
                        <div class="content-view__feedback-card">
                            <div class="feedback-card__top">
                                <a href="#"><img src="../../img/man-glasses.jpg" width="55" height="55"></a>
                                <div class="feedback-card__top--name">
                                    <p><?= Html::a($postedReply->user->name, ["/user/view/{$postedReply->user->id}"],
                                            ['class' => 'link-regular']) ?></p>
                                    <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                                    <b><?= $postedReply->rating ?></b>
                                </div>
                                <span class="new-task__time"><?= date_format(date_create($postedReply->date_add), 'd-m-Y'); ?></span>
                            </div>
                            <div class="feedback-card__content">
                                <p>
                                    <?= $postedReply->description ?>
                                </p>
                                <span><?= $postedReply->price ?><b> ₽</b></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
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
                    <p class="info-customer"><span><?= count($task->customer->tasks); ?> заданий</span><span class="last-"><?= $task->customer->profiles ? date_format(date_create($task->customer->profiles->last_visit), 'd-m-Y') : ''; ?></span></p>
                    <?= Html::a(
                        "Смотреть профиль",
                        ["/user/view/{$task->customer->id}"],
                        ['class' => 'link-regular']
                    ) ?>
                </div>
            </div>
            <div id="chat-container">

                <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
                <chat class="connect-desk__chat"></chat>
            </div>
        </section>
    </div>

<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <?php $form = ActiveForm::begin([
        'id' => 'reply-form',
        'options' => [
            'method' => 'post',
        ]
    ]);?>

    <?= $form->field($replyForm, 'price', $fieldConfig)
        ->textInput([
            'class' => 'response-form-payment
             input input-middle input-money'.($replyForm->hasErrors('price')
                    ? 'field-danger' : ''),
            'rows' => 1,
        ])
        ->error(['style' => 'color: #FF116E']) ?>

    <?= $form->field($replyForm, 'comment', $fieldConfig)
        ->textarea([
            'class' => 'input textarea',
            'rows' => 4,
        ]) ?>

    <?= Html::submitButton('Отправить', ['class' => 'button modal-button']) ?>

    <?php ActiveForm::end(); ?>
    <?= Html::button('Закрыть', ['id' => 'close-modal', 'class' => 'form-modal-close']); ?>
</section>
<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <form action="#" method="post">
        <input class="visually-hidden completion-input completion-input--yes" type="radio" id="completion-radio--yes" name="completion" value="yes">
        <label class="completion-label completion-label--yes" for="completion-radio--yes">Да</label>
        <input class="visually-hidden completion-input completion-input--difficult" type="radio" id="completion-radio--yet" name="completion" value="difficulties">
        <label  class="completion-label completion-label--difficult" for="completion-radio--yet">Возникли проблемы</label>
        <p>
            <label class="form-modal-description" for="completion-comment">Комментарий</label>
            <textarea class="input textarea" rows="4" id="completion-comment" name="completion-comment" placeholder="Place your text"></textarea>
        </p>
        <p class="form-modal-description">
            Оценка
        <div class="feedback-card__top--name completion-form-star">
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
        </div>
        </p>
        <input type="hidden" name="rating" id="rating">
        <button class="button modal-button" type="submit">Отправить</button>
    </form>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <button class="button__form-modal button" id="close-modal"
            type="button">Отмена</button>
    <button class="button__form-modal refusal-button button"
            type="button">Отказаться</button>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<div class="overlay"></div>