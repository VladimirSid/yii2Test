<?php

/* @var $this yii\web\View */
/* @var $appleOnTree */
/* @var $pagesOn */
/* @var $selPage */
use yii\helpers\Html;
use yii\helpers\Url;
use common\classes\AppleHtml;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

$this->title = 'My Yii Application';
?>
<div class="site-index">


    <div class="body-content">
        <?php Pjax::begin(['id' => 'appleTree_pjax'])?>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9" style="min-height:600px; border:0px solid red;background:url('<?=Url::to(['/images/tree.png'])?>') no-repeat;background-size: contain;">
                    <?php foreach ($appleOnTree as $apple){
                        $AppleHtml = new AppleHtml() ;
                        echo $AppleHtml->getAppleSvg($apple["id"], mt_rand(100,230), mt_rand(1,530),$apple["color"], $apple["eaten"]);
                    }
                    ?>
                </div>

                <div class="col-md-3" style="background-color: #fff">
                    <ul class="pagination">
                        <li class="page-item <?php if($selPage==1) echo 'disabled'; ?>">
                            <?= Html::a('<<', null, ['class' => 'page-link', 'onclick' => 'changePageOn('.$selPage.', "down")'])?>
                        </li>
                        <?php

                            if ($selPage > $pagesOn - 2) $start = $pagesOn - 2;
                            elseif ($pagesOn > 3 && $selPage > 2) $start = $selPage - 1;
                            else $start = 1;

                            if ($selPage < 3 && $pagesOn > 2) $end = 3;
                            elseif ($selPage >= $pagesOn - 1) $end = $pagesOn;
                            else $end = $selPage + 1;


                            for ($i = $start; $i <= $end; $i++){
                                $li = $i == $selPage ? '<li class="page-item active">' : '<li class="page-item">';
                                echo $li.Html::a($i, null, ['class' => 'page-link', 'onclick' =>'setPage(this)']).'</li>';
                            }
                        ?>

                        <li class="page-item <?php if($selPage==$pagesOn) echo 'disabled'; ?>">
                            <?= Html::a('>>', null, ['class' => 'page-link', 'onclick' => 'changePageOn('.$selPage.', "up")'])?>
                        </li>
                    </ul>
                    <?= Html::button('Вырастить яблоко', [
                        'id' => 'btnAddApple',
                        'class' => 'btn btn-success',
                        'style' => '',
                        'onclick' => 'createApple();'
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <?php Pjax::end()?>
    </div>
</div>

<?php
    Modal::begin(['id' => 'appleModal']);

    echo Html::tag('div','',['id' => 'appleMdlContent']);
    Modal::end();
?>
