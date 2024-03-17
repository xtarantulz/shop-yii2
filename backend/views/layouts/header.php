<?php
/* @var $user common\models\User */

use yii\helpers\Html;
use common\models\core\Functional;

?>

<div class="nav_menu">
    <nav class="" role="navigation">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
            <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                   aria-expanded="false">
                    <img src="<?= Functional::getMiniImage($user->photo); ?>">
                    <?= $user->first_name." ".$user->last_name; ?>
                    <span class="fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
                        <?= Html::a('<i class="fa fa-user pull-right"></i> '.
                            Yii::t("app", 'Профіль'),
                            ['/site/profile']
                        ) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-cog pull-right"></i> '.
                            Yii::t("app", 'Налаштуваня'),
                            ['/site/config']
                        ) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-file pull-right"></i> '.
                            Yii::t("app", 'Файловий менеджер'),
                            ['/site/file']
                        ) ?>
                    </li>
                    <li>
                        <?= Html::a('<i class="fa fa-sign-out pull-right"></i> '.
                            Yii::t("app", 'Вийти'),
                            ['/site/logout'],
                            ['data-method' => 'post']
                        ) ?>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>