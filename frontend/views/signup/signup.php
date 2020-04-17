<?php

use app\models\Cities;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$fieldConfig = [
    'template' => "{label}\n{input}\n{hint}\n{error}",
    'options' => ['tag' => false],
    'errorOptions' => ['style' => 'color: #FF116E'],
    'hintOptions' => ['tag' => 'span']
];

$this->title = 'Регистрация аккаунта';
?>

    <div class="main-container page-container">
        <section class="registration__user">
            <h1>Регистрация аккаунта</h1>
            <div class="registration-wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'signup',
                    'enableClientValidation' => false,
                    'enableAjaxValidation' => false,
                    'options' => [
                        'method' => 'post',
                        'class' => 'registration__user-form form-create'
                    ]
                ]); ?>

                <?= $form->field($model, 'email', $fieldConfig)
                    ->textInput([
                        'class' => 'input textarea '.($model->hasErrors('email')
                                ? 'field-danger' : ''),
                        'rows' => 1,
                    ])
                    ->error(['class' => 'text-danger'])
                    ->hint('Введите валидный адрес электронной почты') ?>

                <?= $form->field($model, 'username', $fieldConfig)
                    ->textInput(['class' => 'input textarea'])
                    ->hint('Введите ваше имя и фамилию')
                ?>

                <?= $form->field($model, 'city', $fieldConfig)
                    ->dropDownList(Cities::find()->select(['name', 'id'])->indexBy('id')->column(), [
                        'class' => 'multiple-select input town-select registration-town'])
                    ->hint('Укажите город, чтобы находить подходящие задачи'); ?>

                <?= $form->field($model, 'password', $fieldConfig)
                    ->passwordInput(['class' => 'input textarea'])
                    ->hint('Длина пароля от 8 символов') ?>

                <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']);?>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>



