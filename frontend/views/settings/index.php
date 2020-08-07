<?php

use frontend\models\Categories;
use frontend\models\Cities;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$fieldConfig = [
    'template' => "{label}\n{input}\n{error}",
    'options' => ['tag' => false],
    'errorOptions' => ['style' => 'color: #FF116E'],
];

$this->title = 'Настройки';
?>

<section class="account__redaction-wrapper">
    <h1>Редактирование настроек профиля</h1>
    <?php $form = ActiveForm::begin([
        'id' => 'account',
        'validateOnChange' => true,
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'method' => 'post',
        ]
    ]); ?>
        <div class="account__redaction-section">
            <h3 class="div-line">Настройки аккаунта</h3>
            <div class="account__redaction-section-wrapper">
                <div class="account__redaction-avatar">
                    <img src="/uploads/avatars/<?=$user->profiles->avatar ?? '../img/man-glasses.jpg';?>" width="156" height="156">
                    <?= $form->field($model, 'avatar', ['template' => '{input}{label}{error}'])
                        ->fileInput(['id' => 'upload-avatar',])
                        ->label(null, ['class' => 'link-regular']); ?>
                </div>
                <div class="account__redaction">
                    <div class="account__input account__input--name">
                        <?= $form->field($model, 'name', $fieldConfig)
                            ->textInput([
                                    'class' => 'input textarea',
                                    'value' => $user->name,
                            ])
                            ->error(['class' => 'text-danger']) ?>
                    </div>
                    <div class="account__input account__input--email">
                        <?= $form->field($model, 'email', $fieldConfig)
                            ->textInput([
                                'class' => 'input textarea',
                                'value' => $user->email,
                            ])
                            ->error(['class' => 'text-danger']) ?>
                    </div>
                    <div class="account__input account__input--name">
                        <?= $form->field($model, 'city', $fieldConfig)
                            ->dropDownList(Cities::find()->select(['name', 'id'])->indexBy('id')->column(), [
                                'class' => 'multiple-select input multiple-select-big',
                                'options' => [
                                    $user->city_id ?? 1 => ['selected' => true],
                                ],
                            ]) ?>
                    </div>
                    <div class="account__input account__input--date">
                        <?= $form->field($model, 'birthday', $fieldConfig)
                            ->textInput([
                                'type' => 'date',
                                'class' => 'input-middle input input-date '.($model->hasErrors('birthday')
                                        ? 'field-danger' : ''),
                                'value' => Html::encode($user->profiles->birthday
                                    ?? ''),
                            ])
                            ->error(['class' => 'text-danger']) ?>
                    </div>
                    <div class="account__input account__input--info">
                        <?= $form->field($model, 'about', $fieldConfig)
                            ->textarea([
                                'class' => 'input textarea '.($model->hasErrors('about')
                                        ? 'field-danger' : ''),
                                'rows' => 7,
                                'value' => Html::encode($user->profiles->about
                                    ?? ''),
                            ])
                            ->error(['class' => 'text-danger']) ?>
                    </div>
                </div>
            </div>
            <h3 class="div-line">Выберите свои специализации</h3>
            <div class="account__redaction-section-wrapper">
                <?= $form->field($model, 'specializations')
                    ->checkboxList(Categories::find()->select(['name','id'])->indexBy('id')->column(), [
                        'item' => function ($index, $label, $name, $checked, $id) use ($user) {
                            $checked = in_array($id, $user->getUserCategories()->select('category_id')->column())
                                ? 'checked' : '';
                            return "<input class='visually-hidden checkbox__input'
                                type='checkbox' name='$name' id='specializations-$id' value='$id' $checked>
                                <label for='specializations-$id'>$label</label>";
                        },
                        'tag' => 'div',
                        'class' => 'search-task__categories account_checkbox--bottom',
                    ])->label(false) ?>
            </div>
            <h3 class="div-line">Безопасность</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field($model, 'password', $fieldConfig)
                        ->passwordInput(['autocomplete' => 'new-password', 'class' => 'input textarea']) ?>
                </div>
                <div class="account__input">
                    <?= $form->field($model, 'confirmedPassword', $fieldConfig)
                        ->passwordInput(['autocomplete' => 'new-password', 'class' => 'input textarea']) ?>
                </div>
            </div>

            <h3 class="div-line">Фото работ</h3>

            <div class="account__redaction-section-wrapper account__redaction">
                <span class="dropzone">Выбрать фотографии</span>
            </div>

            <h3 class="div-line">Контакты</h3>
            <div class="account__redaction-section-wrapper account__redaction">
                <div class="account__input">
                    <?= $form->field($model, 'phoneNumber', $fieldConfig)
                        ->textInput([
                            'class' => 'input textarea '.($model->hasErrors('phoneNumber')
                                    ? 'field-danger' : ''),
                            'value' => Html::encode($user->profiles->phone_number
                                ?? ''),
                        ])
                        ->error(['class' => 'text-danger'])?>
                </div>
                <div class="account__input">
                    <?= $form->field($model, 'skype', $fieldConfig)
                        ->textInput([
                            'class' => 'input textarea '.($model->hasErrors('skype')
                                    ? 'field-danger' : ''),
                            'value' => Html::encode($user->profiles->skype
                                ?? ''),
                        ])
                        ->error(['class' => 'text-danger'])?>
                </div>
                <div class="account__input">
                    <?= $form->field($model, 'telegram', $fieldConfig)
                        ->textInput([
                            'class' => 'input textarea '.($model->hasErrors('telegram')
                                    ? 'field-danger' : ''),
                            'value' => Html::encode($user->profiles->telegram
                                ?? ''),
                        ])
                        ->error(['class' => 'text-danger'])?>
                </div>
            </div>
            <h3 class="div-line">Настройки сайта</h3>
            <h4>Уведомления</h4>
            <div class="account__redaction-section-wrapper account_section--bottom">
                <div class="search-task__categories account_checkbox--bottom">
                    <?php $checkboxConfig = [
                        'template' => '{input}{label}',
                        'options' => ['tag' => false],
                    ]; ?>
                    <?= $form->field($model, 'newMessage', $checkboxConfig)
                        ->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'checked' => (bool)$user->profiles->message_notifications
                                ?? 0,
                            'value' => 1,
                        ]); ?>
                    <?= $form->field($model, 'taskActions', $checkboxConfig)
                        ->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'checked' => (bool)$user->profiles->task_notifications
                                ?? 0,
                            'value' => 1,
                        ]); ?>
                    <?= $form->field($model, 'newReview', $checkboxConfig)
                        ->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'checked' => (bool)$user->profiles->review_notifications
                                ?? 0,
                            'value' => 1,
                        ]); ?>
                </div>
                <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                    <?= $form->field($model, 'hideContacts', $checkboxConfig)
                        ->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'checked' => (bool)$user->profiles->hide_contact_info
                                ?? 0,
                            'value' => 1,
                        ]); ?>
                    <?= $form->field($model, 'hideProfile', $checkboxConfig)
                        ->input('checkbox', [
                            'class' => 'visually-hidden checkbox__input',
                            'checked' => (bool)$user->profiles->hide_profile
                                ?? 0,
                            'value' => 1,
                        ]); ?>
                </div>
            </div>
        </div>
    <?= Html::submitButton('Сохранить изменения', [
        'class' => 'button',
    ]);?>
    <?php ActiveForm::end(); ?>
</section>
<script src="js/dropzone.js"></script>

<script>
    Dropzone.autoDiscover = false;

    var dropzone = new Dropzone(".dropzone",
        {url: window.location.href, maxFiles: 6, uploadMultiple: true, parallelUploads: 6,
        acceptedFiles: 'image/*', previewTemplate: '<a href="#"><img data-dz-thumbnail alt="Фото работы"></a>',
        paramName: 'files',
        autoProcessQueue: true
        });

</script>