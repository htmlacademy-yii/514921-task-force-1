<?php

use app\models\Categories;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Исполнители';
?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="user__search">
            <div class="user__search-link">
                <p>Сортировать по:</p>
                <ul class="user__search-list">
                    <li class="user__search-item user__search-item--current">
                        <a href="#" class="link-regular">Рейтингу</a>
                    </li>
                    <li class="user__search-item">
                        <a href="#" class="link-regular">Числу заказов</a>
                    </li>
                    <li class="user__search-item">
                        <a href="#" class="link-regular">Популярности</a>
                    </li>
                </ul>
            </div>
            <?php foreach ($users as $user): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="#"><img src="./img/man-glasses.jpg" width="65" height="65"></a>
                        <span>17 заданий</span>
                        <span>6 отзывов</span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="/user/view/<?= $user->id?>" class="link-regular"><?=$user->name?></a></p>
                        <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                        <b>4.25</b>
                        <p class="user__search-content">
                            <?=$user->profiles->about?>
                        </p>
                    </div>
                    <span class="new-task__time">Был на сайте 25 минут назад</span>
                </div>
                <div class="link-specialization user__search-link--bottom">
                    <a href="#" class="link-regular">Ремонт</a>
                    <a href="#" class="link-regular">Курьер</a>
                    <a href="#" class="link-regular">Оператор ПК</a>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

        <section  class="search-task">
            <div class="search-task__wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'filter-form',
                    'options' => ['class' => 'search-task__form'],
                    'action' => ['/users'],
                    'method' => 'get'
                ]); ?>
                    <fieldset class="search-task__categories">
                        <legend>Категории</legend>
                        <?php echo $form->field($usersFilter, 'specializations',
                            ['options' => ['class' => '']])
                            ->label(false)
                            ->checkboxList(Categories::find()->select(['name','id'])->indexBy('id')->column(),
                                [
                                    'item' => function ($index, $label, $name, $checked, $value) use ($usersFilter) {
                                        return '<input class="visually-hidden checkbox__input" id="categories_' . $value . '"
                         type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '>
                                        <label for="categories_' . $value . '">' . $label . '</label>';
                                    }
                                ]) ?>
                    </fieldset>
                    <fieldset class="search-task__categories">
                        <legend>Дополнительно</legend>
                        <?php echo $form->field($usersFilter, 'freeNow', [
                                'template' => '{input}{label}',
                                'options' => ['class' => ''],
                            ])
                        ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                        ],false) ?>
                        <?php echo $form->field($usersFilter, 'onlineNow', [
                            'template' => '{input}{label}',
                            'options' => ['class' => ''],
                        ])
                            ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ],false) ?>
                        <?php echo $form->field($usersFilter, 'withReviews', [
                            'template' => '{input}{label}',
                            'options' => ['class' => ''],
                        ])
                            ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ],false) ?>
                        <?php echo $form->field($usersFilter, 'withFavorites', [
                            'template' => '{input}{label}',
                            'options' => ['class' => ''],
                        ])
                            ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ],false) ?>
                    </fieldset>
                    <?php echo $form->field($usersFilter, 'search', [
                        'template' => '{label}{input}',
                        'options' => ['class' => ''],
                        'labelOptions' => ['class' =>'search-task__name']
                    ])
                        ->input('search', [
                            'class' => 'input-middle input',
                            'style' => 'width: 100%'
                    ]) ?>
                    <?= Html::submitButton('Искать', ['class' => 'button']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</main>
