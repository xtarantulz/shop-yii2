<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\forms\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Скинути пароль');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password">
    <div class="login_wrapper">
        <div id="login" class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <h1><?= $this->title; ?></h1>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Новий пароль')])->label(false) ?>

                <?= Html::submitButton(Yii::t('app', 'Зміна пароля'), ['class' => 'btn btn-default submit']) ?>

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">
                        <?= Yii::t('app', 'Ви хочете перейти на форму входа?'); ?>
                        <?= Html::a(Yii::t('app', 'Увійти'), '/admin', ['class' => 'to_register']) ?>
                    </p>

                    <div class="clearfix"></div>
                    <br/>

                    <div>
                        <h1 class="company-name"><i class="fa fa-paw"></i> <?= Yii::$app->name; ?></h1>
                        <p>
                            <?= $this->render('/blocks/_copyright'); ?>
                        </p>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</div>
