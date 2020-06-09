<?php

use frontend\models\Categories;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

$this->title = 'Новые задания';
?>

        <div class="main-container page-container">
            <section class="new-task">
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => [
                            'tag' => 'div',
                            'class' => 'new-task__wrapper',
                        ],
                        'summary' => Html::tag('h1', $this->title),
                        'layout' => "{summary}\n{items}",
                        'itemView' => 'task-card',
                    ])  ?>
                <div class="new-task__pagination">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->getPagination(),
                        'maxButtonCount' => 5,
                        'linkContainerOptions' => ['class' => 'pagination__item'],
                        'activePageCssClass' => 'pagination__item--current',
                        'options' => [
                            'class' => 'new-task__pagination-list',
                        ],
                        'nextPageLabel' => '&#160;',
                        'prevPageLabel' => '&#160;',
                    ]); ?>
                </div>
            </section>
            <section  class="search-task">
                <div class="search-task__wrapper">
                    <?php $form = ActiveForm::begin([
                        'id' => 'filter-form',
                        'options' => ['class' => 'search-task__form'],
                        'action' => ['/tasks'],
                        'method' => 'get'
                    ]); ?>
                        <fieldset class="search-task__categories">
                            <legend>Категории</legend>
                            <?php echo $form->field($filter, 'categories',
                                ['options' => ['class' => '']])
                                ->label(false)
                                ->checkboxList(Categories::find()->select(['name','id'])->indexBy('id')->column(),
                                    [
                                        'item' => function ($index, $label, $name, $checked, $value) use ($filter) {
                                            return '<input class="visually-hidden checkbox__input" id="categories_' . $value . '"
                         type="checkbox" name="' . $name . '" value="' . $value . '" ' . $checked . '>
                                        <label for="categories_' . $value . '">' . $label . '</label>';
                                        }
                                    ]) ?>
                        </fieldset>
                        <fieldset class="search-task__categories">
                            <legend>Дополнительно</legend>
                            <?php echo $form->field($filter, 'noResponse',[
                                'template' => '{input}{label}',
                                'options' => ['class' => ''],
                                ])
                                ->checkbox([
                                        'class' => 'visually-hidden checkbox__input'
                                ],false) ?>
                            <?php echo $form->field($filter, 'remoteWork',[
                                'template' => '{input}{label}',
                                'options' => ['class' => ''],
                                ])->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ],false) ?>
                        </fieldset>
                    <label class="search-task__name" for="period">Период</label>
                    <?= $form->field($filter, 'period', [
                            'options' => ['tag' => false],
                            'template' => '{label}{input}'
                    ])
                        ->label(false)
                        ->dropDownList([
                                'all' => 'За всё время',
                                '1 day' => 'За день',
                                '1 week' => 'За неделю',
                                '1 month' => 'За месяц'], ['class' => 'multiple-select input']); ?>

                    <?= $form->field($filter, 'search', [
                        'template' => '{label}{input}',
                        'options' => ['class' => ''],
                        'labelOptions' => ['class' => 'search-task__name']
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
