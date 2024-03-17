<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use toxor88\switchery\Switchery;

yii\widgets\MaskedInputAsset::register($this);

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $login_model common\models\forms\LoginForm */
/* @var $reset_model common\models\forms\ResetPasswordForm */

$this->title = Yii::t('app', 'Вхід');
?>

<div>
    <a class="hiddenanchor" id="signin"></a>
    <a class="hiddenanchor" id="reset"></a>

    <div class="login_wrapper">
        <div id="login" class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <h1><?= Yii::t('app', 'Форма входа'); ?></h1>

                <?= $form->field($login_model, 'email')->input('email', ['placeholder' => Yii::t('app', 'E-mail')])->label(false) ?>

                <?= $form->field($login_model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Пароль')])->label(false) ?>

                <?= $form->field($login_model, 'rememberMe')->widget(Switchery::className())->label(false); ?>

                <?= Html::submitButton(Yii::t('app', 'Увійти'), ['class' => 'btn btn-default submit']) ?>
                <?= Html::a(Yii::t('app', 'Забули пароль?'), '#reset', ['class' => 'to_register']) ?>

                <div class="clearfix"></div>

                <div class="separator">
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

        <div id="reset" class="animate form reset_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <h1><?= Yii::t('app', 'Форма скидання пароля'); ?></h1>

                <?= $form->field($reset_model, 'email')->input('email', ['placeholder' => Yii::t('app', 'E-mail')])->label(false) ?>

                <?= Html::submitButton(Yii::t('app', 'Надіслати'), ['class' => 'btn btn-default submit']) ?>

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">
                        <?= Yii::t('app', 'Вже зареєстровані?'); ?>
                        <?= Html::a(Yii::t('app', 'Увійти'), '#signin', ['class' => 'to_register']) ?>
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
