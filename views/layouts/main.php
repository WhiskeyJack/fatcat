<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        $timezone = Yii::$app->user->isGuest ? 'Europe/Amsterdam' : Yii::$app->user->identity->timezone;
        // date_default_timezone_set($timezone);
        Yii::$app->timeZone = $timezone;
            NavBar::begin([
                'brandLabel' => 'FatCat 0.1',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
                        echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left    '],
                'items' => [
//                    ['label' => 'Home', 'url' => ['/site/index']],
//                    ['label' => 'About', 'url' => ['/site/about']],
//                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    ['label' => date('l F j g:i A')],
                     ],
            ]);               
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
//                    ['label' => 'Home', 'url' => ['/site/index']],
//                    ['label' => 'About', 'url' => ['/site/about']],
//                    ['label' => 'Contact', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ? ['label' => ''] : ['label' => 'Periodic Events', 'url' => ['/periodic-event']],
                    Yii::$app->user->isGuest ? ['label' => ''] : ['label' => 'Events', 'url' => ['/event']],
                    Yii::$app->user->isGuest ? ['label' => ''] : ['label' => 'Event Types', 'url' => ['/event-type']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['user/security/login']] :
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
