<?php
    use yii\helpers\Html;
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta charset="<?= Yii::$app->charset ?>"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<link href="/img/favicon.png" rel="icon">
<link href="/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->