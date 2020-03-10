<?php

/* @var $this yii\web\View */
/* @var $appleOnTree */
/* @var $appleFallTree */
/* @var $appleBad */
/* @var $htmlPagesOn */
/* @var $htmlPagesFall */
/* @var $htmlPagesBad */


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
            <div class="ground"></div>
            <?php  Pjax::begin(['id' => 'appleTree_pjax', 'class' => 'col-xs-12']);  ?>

            <!-- ************************** -->
            <!-- показ яблок на дереве -->
            <?php
            Pjax::begin(['id' => 'applesOnTree_pjax']);
                foreach ($appleOnTree as $apple){
                    $AppleHtml = new AppleHtml() ;
                    echo $AppleHtml->getAppleSvg($apple["id"], mt_rand(100,230), mt_rand(40,450),$apple["color"], $apple["eaten"]);
                }

            ?>
            <div class="text-center panel-form">
                <h4>Яблоки на дереве</h4>
                <?= $htmlPagesOn ?>
                <br>
                <?= Html::button('Вырастить яблоко', [
                    'id' => 'btnAddApple',
                    'class' => 'btn btn-success',
                    'onclick' => 'appleAction("create");'
                ]); ?>
            </div>
            <?php Pjax::end(); ?>


            <!-- ************************** -->
            <!-- показ упавших яблок -->
            <?php
            Pjax::begin(['id' => 'applesDownTree_pjax']);
                foreach ($appleFallTree as $apple){
                    $AppleHtml = new AppleHtml() ;
                    echo $AppleHtml->getAppleSvg($apple["id"], mt_rand(290,300), mt_rand(40,450),$apple["color"], $apple["eaten"]);
                }
            ?>
            <div class="text-center panel-form">
                <h4>Упавшие яблоки</h4>
                <?= $htmlPagesFall ?>
                <br>
                <?= Html::button('Уронить яблоко', [
                    'id' => 'btnFallApple',
                    'class' => 'btn btn-warning',
                    'onclick' => 'appleAction("down");'
                ]); ?>
            </div>
            <?php Pjax::end(); ?>


            <!-- ************************** -->
            <!-- показ испорченных яблок -->
            <?php
                Pjax::begin(['id' => 'applesBad_pjax']);
                foreach ($appleBad as $apple){
                    $AppleHtml = new AppleHtml() ;
                    echo $AppleHtml->getAppleSvg($apple["id"], mt_rand(250,260), mt_rand(40,450),$apple["color"], $apple["eaten"]);
                }
            ?>

            <div class="text-center panel-form">
                <h4>Ипорченные яблоки</h4>
                <?= $htmlPagesBad ?>
            </div>
            <?php Pjax::end(); ?>
            <!-- ************************** -->
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<?php
    Modal::begin(['id' => 'appleModal']);

    echo Html::tag('div','',['id' => 'appleMdlContent']);
    Modal::end();
?>
