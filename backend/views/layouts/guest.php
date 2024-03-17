<?php
use common\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <?= $this->render('head.php'); ?>
</head>

<body class="login">
    <div class="container">
        <?php $this->beginBody() ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
    </div>
</body>
</html>
<?php $this->endPage() ?>
