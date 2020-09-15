<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
$linkOptions = ['class'=> "link-regular"];
$this->title = 'Исполнители';
?>

    <div class="main-container page-container">
        <section class="user__search">
            <div class="user__search-link">
                <p>Сортировать по:</p>
                <ul class="user__search-list">
                    <li class="user__search-item <?= trim(Yii::$app->request->get('sort'), '-') === 'rating' ? 'user__search-item--current' : ''; ?>">
                        <?= $sort->link('rating', $linkOptions) ?>
                    </li>
                    <li class="user__search-item <?= trim(Yii::$app->request->get('sort'), '-') === 'task_completion_status' ? 'user__search-item--current' : ''; ?>">
                        <?= $sort->link('task_completion_status', $linkOptions) ?>
                    </li>
                    <li class="user__search-item <?= trim(Yii::$app->request->get('sort'), '-') === 'views_count' ? 'user__search-item--current' : ''; ?>">
                        <?= $sort->link('views_count', $linkOptions) ?>
                    </li>
                </ul>
            </div>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['tag' => false],
                    'options' => ['tag' => false],
                    'layout' => "{items}\n{pager}",
                    'itemView' => 'user-card',
                    'pager' => [
                        'maxButtonCount' => 5,
                        'options' => [
                            'class' => 'new-task__pagination-list',
                        ],
                        'activePageCssClass' => 'pagination__item--current',
                        'linkContainerOptions' => [
                            'class' => 'pagination__item',
                        ],
                        'nextPageLabel' => '&#160;',
                        'prevPageLabel' => '&#160;',
                    ],
                ])  ?>
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
                            ->checkboxList($categories->getModels(),
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
