<?php

/* @var $this yii\web\View */
/* @var $appleSvg  */

use yii\helpers\Html;
use yii\helpers\Url;
use common\classes\AppleHtml;

?>
<div class="row">
    <div class="col-sm-5">
        <?= $appleSvg ?>
    </div>
    <div class="col-sm-7">
        <b>ID: <?= $model->id ?></b>
    </div>
</div>
