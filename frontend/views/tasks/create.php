<?php

use frontend\models\Categories;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$fieldConfig = [
    'template' => "{label}\n{input}\n{hint}\n{error}",
    'options' => ['tag' => false],
    'errorOptions' => ['style' => 'color: #FF116E'],
    'hintOptions' => ['tag' => 'span']
];

$this->title = 'Создать задание';
?>
<!--<script>-->
<!--    var dropzone = new Dropzone("div.create__file", {url: "/", paramName: "Attach"});-->
<!--</script>-->
<div class="main-container page-container">
    <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">
            <?php $form = ActiveForm::begin([
                'id' => 'create',
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'method' => 'post',
                    'class' => 'create__task-form form-create',
                ]
            ]); ?>

            <?= $form->field($model, 'name', $fieldConfig)
                ->textInput([
                    'class' => 'input textarea '.($model->hasErrors('name')
                            ? 'field-danger' : ''),
                    'rows' => 1,
                ])
                ->error(['class' => 'text-danger'])
                ->hint('Кратко опишите суть работы') ?>

            <?= $form->field($model, 'description', $fieldConfig)
                ->textInput([
                    'class' => 'input textarea '.($model->hasErrors('description')
                            ? 'field-danger' : ''),
                    'rows' => 7,
                ])
                ->error(['class' => 'text-danger'])
                ->hint('Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться') ?>

            <?= $form->field($model, 'category', $fieldConfig)
                ->dropDownList(Categories::find()->select(['name', 'id'])->indexBy('id')->column(), [
                    'class' => 'multiple-select input multiple-select-big'])
                ->hint('Выберите категорию'); ?>

            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file">
                <?= $form->field($model, 'files[]')
                    ->label(false)
                    ->fileInput(['multiple' => true]);?>
            </div>
            <span>Добавить новый файл</span>

            <?= $form->field($model, 'location', $fieldConfig)
                ->textInput(['class' => 'input-navigation input-middle input'])
                ->hint('Укажите адрес исполнения, если задание требует присутствия')
            ?>
            <div class="create__price-time">
                <div class="create__price-time--wrapper">
            <?= $form->field($model, 'budget', $fieldConfig)
                ->textInput([
                    'class' => 'input textarea input-money'.($model->hasErrors('budget')
                            ? 'field-danger' : ''),
                    'rows' => 1,
                ])
                ->error(['class' => 'text-danger'])
                ->hint('Не заполняйте для оценки исполнителем') ?>
                </div>
                <div class="create__price-time--wrapper">
                <?= $form->field($model, 'dateExpire', $fieldConfig)
                    ->textInput([
                        'type' => 'date',
                        'class' => 'input-middle input input-date'.($model->hasErrors('dateExpire')
                                ? 'field-danger' : ''),
                        'rows' => 1,
                    ])
                    ->error(['class' => 'text-danger'])
                    ->hint('Укажите крайний срок исполнения') ?>
                </div>
            </div>
            <?= Html::submitButton('Опубликовать', ['class' => 'button']);?>
            <?php ActiveForm::end(); ?>
            <div class="create__warnings">
                <div class="warning-item warning-item--advice">
                    <h2>Правила хорошего описания</h2>
                    <h3>Подробности</h3>
                    <p>Друзья, не используйте случайный<br>
                        контент – ни наш, ни чей-либо еще. Заполняйте свои
                        макеты, вайрфреймы, мокапы и прототипы реальным
                        содержимым.</p>
                    <h3>Файлы</h3>
                    <p>Если загружаете фотографии объекта, то убедитесь,
                        что всё в фокусе, а фото показывает объект со всех
                        ракурсов.</p>
                </div>
                <div class="warning-item warning-item--error">
                    <h2>Ошибки заполнения формы</h2>
                    <h3>Категория</h3>
                    <p>Это поле должно быть выбрано.<br>
                        Задание должно принадлежать одной из категорий</p>
                </div>
            </div>
        </div>

    </section>
</div>

