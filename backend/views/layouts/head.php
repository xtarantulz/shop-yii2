<?php
    use yii\helpers\Html;
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta charset="<?= Yii::$app->charset ?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta id="vp" name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->