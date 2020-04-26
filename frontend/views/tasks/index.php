<?php

use frontend\models\Categories;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Новые задания';
?>

        <div class="main-container page-container">
            <section class="new-task">
                <div class="new-task__wrapper">
                    <h1>Новые задания</h1>
                    <?php foreach ($tasks as $task): ?>
                    <div class="new-task__card">
                        <div class="new-task__title">
                            <a href="/task/view/<?= $task->id?>" class="link-regular"><h2><?=$task->name?></h2></a>
                            <a  class="new-task__type link-regular" href="#"><p><?=$task->category->name?></p></a>
                        </div>
                        <div class="new-task__icon new-task__icon--translation"><?=$task->category->ico?></div>
                        <p class="new-task_description">
                            <?=$task->description?>
                        </p>
                        <b class="new-task__price new-task__price--translation"><?=$task->budget?><b> ₽</b></b>
                        <p class="new-task__place"><?=$task->address?></p>
                        <span class="new-task__time"><?=date_format(date_create($task->date_add), 'd-m-Y');?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="new-task__pagination">
                    <ul class="new-task__pagination-list">
                        <li class="pagination__item"><a href="#"></a></li>
                        <li class="pagination__item pagination__item--current">
                            <a>1</a></li>
                        <li class="pagination__item"><a href="#">2</a></li>
                        <li class="pagination__item"><a href="#">3</a></li>
                        <li class="pagination__item"><a href="#"></a></li>
                    </ul>
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
