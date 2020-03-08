<?php

/* @var $this yii\web\View */
/* @var $appleOnTree */
/* @var $appleFallTree */
/* @var $htmlPagesOn */
/* @var $htmlPagesFall */


use yii\helpers\Html;
use yii\helpers\Url;
use common\classes\AppleHtml;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

$this->title = 'My Yii Application';
?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
            <?php
                Pjax::begin(['id' => 'appleTree_pjax', 'class' => 'col-xs-12'

                ]);
            ?>


                <?php
                Pjax::begin(['id' => 'applesOnTree_pjax']);
                    foreach ($appleOnTree as $apple){
                        $AppleHtml = new AppleHtml() ;
                        echo $AppleHtml->getAppleSvg($apple["id"], mt_rand(100,230), mt_rand(200,650),$apple["color"], $apple["eaten"]);
                    }

                ?>
                <div class="text-center panel-form">
                    <?= $htmlPagesOn ?>
                    <br>
                    <?= Html::button('Вырастить яблоко', [
                        'id' => 'btnAddApple',
                        'class' => 'btn btn-success',
                        'onclick' => 'appleAction("create");'
                    ]); ?>
                </div>
                <?php Pjax::end(); ?>

                <?php
                Pjax::begin(['id' => 'applesDownTree_pjax']);
                    foreach ($appleFallTree as $apple){
                        $AppleHtml = new AppleHtml() ;
                        echo $AppleHtml->getAppleSvg($apple["id"], mt_rand(610,620), mt_rand(140,650),$apple["color"], $apple["eaten"]);
                    }
                ?>

                <div class="text-center panel-form">
                    <?= $htmlPagesFall ?>
                    <br>
                    <?= Html::button('Уронить яблоко', [
                        'id' => 'btnFallApple',
                        'class' => 'btn btn-warning',
                        'onclick' => 'appleAction("down");'
                    ]); ?>
                </div>
                <?php Pjax::end(); ?>
            <?php Pjax::end(); ?>
        </div>

    </div>
</div>

<?php
    Modal::begin(['id' => 'appleModal']);

    echo Html::tag('div','',['id' => 'appleMdlContent']);
    Modal::end();
?>
