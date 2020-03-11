<?php

/* @var $this yii\web\View */
/* @var $stat  */


use yii\helpers\Html;


?>
<div class="row">
    <div class="container">
        <h4>На дереве: <?= $stat[0]["onTree"] ?></h4>
        <h4>Упало: <?=$stat[0]["fallenApples"] ?></h4>
        <h4>Испорчено: <?= $stat[0]["badApples"] ?></h4>
    </div>
</div>
<div class="footer">

</div>
