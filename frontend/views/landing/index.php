<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$fieldConfig = [
    'template' => "<p>{label}{input}{error}</p>",
    'labelOptions' => ['class' => 'form-modal-description'],
    'inputOptions' => ['class' => 'enter-form-email input input-middle', 'style' => 'margin-bottom: 5px',]
];
?>

<div class="landing-container">
    <div class="landing-top">
        <h1>Работа для всех.<br>
            Найди исполнителя на любую задачу.</h1>
        <p>Сломался кран на кухне? Надо отправить документы? Нет времени самому гулять с собакой?
            У нас вы быстро найдёте исполнителя для любой жизненной ситуации?<br>
            Быстро, безопасно и с гарантией. Просто, как раз, два, три. </p>
        <?= Html::a('Создать аккаунт', '/signup', ['class' => 'button']) ?>
    </div>
    <div class="landing-center">
        <div class="landing-instruction">
            <div class="landing-instruction-step">
                <div class="instruction-circle circle-request"></div>
                <div class="instruction-description">
                    <h3>Публикация заявки</h3>
                    <p>Создайте новую заявку.</p>
                    <p>Опишите в ней все детали
                        и  стоимость работы.</p>
                </div>
            </div>
            <div class="landing-instruction-step">
                <div class="instruction-circle  circle-choice"></div>
                <div class="instruction-description">
                    <h3>Выбор исполнителя</h3>
                    <p>Получайте отклики от мастеров.</p>
                    <p>Выберите подходящего<br>
                        вам исполнителя.</p>
                </div>
            </div>
            <div class="landing-instruction-step">
                <div class="instruction-circle  circle-discussion"></div>
                <div class="instruction-description">
                    <h3>Обсуждение деталей</h3>
                    <p>Обсудите все детали работы<br>
                        в нашем внутреннем чате.</p>
                </div>
            </div>
            <div class="landing-instruction-step">
                <div class="instruction-circle circle-payment"></div>
                <div class="instruction-description">
                    <h3>Оплата&nbsp;работы</h3>
                    <p>По завершении работы оплатите
                        услугу и закройте задание</p>
                </div>
            </div>
        </div>
        <div class="landing-notice">
            <div class="landing-notice-card card-executor">
                <h3>Исполнителям</h3>
                <ul class="notice-card-list">
                    <li>
                        Большой выбор заданий
                    </li>
                    <li>
                        Работайте где  удобно
                    </li>
                    <li>
                        Свободный график
                    </li>
                    <li>
                        Удалённая работа
                    </li>
                    <li>
                        Гарантия оплаты
                    </li>
                </ul>
            </div>
            <div class="landing-notice-card card-customer">
                <h3>Заказчикам</h3>
                <ul class="notice-card-list">
                    <li>
                        Исполнители на любую задачу
                    </li>
                    <li>
                        Достоверные отзывы
                    </li>
                    <li>
                        Оплата по факту работы
                    </li>
                    <li>
                        Экономия времени и денег
                    </li>
                    <li>
                        Выгодные цены
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="landing-bottom">
        <div class="landing-bottom-container">
            <h2>Последние задания на сайте</h2>
            <?php foreach ($tasks as $task) : ?>
            <div class="landing-task">
                <div class="landing-task-top task-<?= $task->category->ico ?>"></div>
                <div class="landing-task-description">
                    <h3><a href="#" class="link-regular"><?= $task->name ?></a></h3>
                    <p><?= Html::encode($task->description =
                            StringHelper::truncate($task['description'], 67, '...')); ?></p>
                </div>
                <div class="landing-task-info">
                    <div class="task-info-left">
                        <p><a href="#" class="link-regular"><?= $task->category->name ?></a></p>
                        <p><?=date_format(date_create($task->date_add), 'd-m-Y');?></p>
                    </div>
                    <span>
                        <?php if ($task->budget) : ?>
                            <?= Html::encode($task->budget) ?><b> ₽</b>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="landing-bottom-container">
            <?= Html::button('смотреть все задания', ['class' => 'button red-button open-modal',
                'data-for' => 'enter-form',]) ?>
        </div>
    </div>
</div>

<section class="modal enter-form form-modal" id="enter-form">
    <h2>Вход на сайт</h2>
    <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableAjaxValidation' => true,
            'errorSummaryCssClass' => 'errors-field',
    ]);?>

    <?= $form->errorSummary($model, ['class' => 'errors-field'])?>


    <?= $form->field($model, 'email', $fieldConfig)
        ->textInput()
        ->error(['style' => 'color: #FF116E']); ?>

    <?= $form->field($model, 'password', $fieldConfig)
        ->passwordInput()
        ->error(['style' => 'color: #FF116E;margin-bottom: 20px']); ?>


    <?= Html::submitButton('Войти', ['class' => 'button']) ?>

    <?php ActiveForm::end(); ?>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => false,
    ]) ?>
    <?= Html::button('Закрыть', ['id' => 'close-modal', 'class' => 'form-modal-close']); ?>
</section>