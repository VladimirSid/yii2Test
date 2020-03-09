<?php

/* @var $this yii\web\View */
/* @var $appleSvg  */
/* @var $timeOnGround  */

use yii\helpers\Html;
use yii\helpers\Url;
use common\classes\AppleHtml;

?>
<div class="row">
    <div class="col-sm-5">
        <?= $appleSvg ?>
    </div>
    <div class="col-sm-7">
        <b>ID: <?= $model->id ?></b><br>
        <b>Дата появления:</b> <?= $model->createdAt ?><br>
        <b>Дата падения:</b> <?= $model->fallAt == null ? "не упало" : $model->fallAt ?><br>
        <b>Пролежало на земле:</b> <?= print_r( $timeOnGround) ?><br>
    </div>
</div>
