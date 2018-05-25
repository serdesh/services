<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;
use yii\helpers\Url;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => 'img/favshmr.ico']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode('Сервисы ШМР') ?></title>
        <link href="fontawesome/css/font-awesome.min.css" rel="stylesheet">
        <?php $this->head() ?>
        <style media='print' type='text/css'>
            #navbar-iframe {display: none; height: 0px; visibility: hidden;}
            .noprint {display: none;}
            body {background:#FFF; color:#000;}
            a {text-decoration: underline; color:#00F;}
        </style>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="before-load">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
        <div class="wrap">

            <header>
                <?php
                NavBar::begin([
                    'brandLabel' => Html::img('@web/img/gerb.png', ['alt' => Yii::$app->name, 'class' => 'pull-left img-responsive']) . '<span class="brand-label">' . Yii::$app->name . '</span>',
                    //'brandLabel' => Html::img('@web/img/gerb.png', ['alt' => Yii::$app->name, 'class' => 'pull-left img-responsive', 'style' => ['width' => '40px', 'padding' => '0px 5px 0px 5px']]) . '<span>' . Yii::$app->name . '</span>',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed',
                    ],
                    
                ]);

                $menuItems = [
                    ['label' => 'Главная', 'url' => ['/site/index']],
                        //['label' => 'О сайте', 'url' => ['/site/about']],
                        //['label' => 'Контакты', 'url' => ['/site/contact']],
                ];

                if (Yii::$app->user->isGuest) {
                    $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
                    $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
                }

                if (User::isUserAdmin()) {
                    $menuItems[] = ['label' => 'Управление', 'items' => [
                            ['label' => 'Задачник', 'url' => ['/task/index']],
                            ['label' => 'Закупки оборудования', 'url' => ['/invoice/index']],
                            ['label' => 'GII', 'url' => ['/gii']],
                            ['label' => 'ФИАС', 'url' => ['/site/fias']],
                            ['label' => 'ФТП аккаунты', 'url' => ['/ftpaccounts/index']],
                            ['label' => 'Тестовая страница', 'url' => ['/site/test']],
                    ]];

                    $menuItems[] = ['label' => 'Справочники', 'items' => [
                            ['label' => 'Общие'],
                            ['label' => 'Органы', 'url' => ['/organ/index']],
                            ['label' => 'Подразделения', 'url' => ['/division/index']],
                            ['label' => 'Пользователи', 'url' => ['/user/index']],
                            ['label' => 'Роли', 'url' => ['/role/index']],
                            '<li class="divider">Информация для сайта</li>',
                            ['label' => 'Информация для сайта'],
                            ['label' => 'Статусы информации', 'url' => ['/statusinfo/index']],
                            ['label' => 'Карта сайта', 'url' => ['/mapinfo/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Журнал адм. правонарушений'],
                            ['label' => 'Нарушители', 'url' => ['/violator/index']],
                            ['label' => 'Населенные пункты', 'url' => ['/settlement/index']],
                            ['label' => 'Адреса', 'url' => ['/address/index']],
                            ['label' => 'Улицы', 'url' => ['/streets/index']],
                            '<li class="divider"></li>',
                            ['label' => 'Учет покупок'],
                            ['label' => 'Продаваны', 'url' => ['/seller/index']],
                    ]];
                }
                if (!Yii::$app->user->isGuest) {
                    $menuItems[] = ['label' => 'Сервисы', 'items' => [
                            ['label' => 'Информация для сайта', 'url' => ['/siteinfo/index']],
                            ['label' => 'Журнал корреспонденции', 'url' => ['#']],
                            ['label' => 'База Документов', 'url' => ['/npa/index']],
                            ['label' => 'Вестник ШМР', 'url' => ['/vestnik/index']],
                            ['label' => 'Журнал административных правонарушений', 'url' => ['/wrongdoing/index']],
                    ]];

                    $menuItems[] = '<li>'
                            . Html::beginForm(['/site/logout'], 'post') // Форма логаута, смотрим виджет ActiveForm
                            . Html::submitButton(
                                    'Выйти (<b>' . Yii::$app->user->identity->username . '</b>)<br>' . User::getShortname(Yii::$app->user->identity->fio), ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm()
                            . '</li>';
                }

                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $menuItems,
                ]);

                NavBar::end();
                ?>
            </header>
            <main>
                <div class="container-fluid">
                    <div class="row noprint">
                        <?=
                        Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'class' => 'noprint',
                        ])
                        ?>
                    </div>
                    <?php // echo \yii\helpers\VarDumper::dump(Yii::$app->user->identity->username); ?>
                    <div class="row">
                        <?= $content ?>
                    </div>
                </div>
            </main>
        </div>

        <footer class="footer noprint">
            <div class="container-fluid">
                <p class="pull-left">&copy; Администрация Шарьинского муниципального района <?= date('Y') ?></p>

                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<script>
    $(window).load(function () {
        $('#before-load').find('i').fadeOut().end().delay(400).fadeOut('slow');
    });
</script>
<?php $this->endPage() ?>
