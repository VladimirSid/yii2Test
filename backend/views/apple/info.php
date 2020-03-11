<?php

/* @var $this yii\web\View */
/* @var $appleSvg  */
/* @var $timeOnGround  */
/* @var $canEat  */
/* @var $canFall  */


use yii\helpers\Html;


?>
<div class="row">
    <div class="col-sm-5">
        <?= $appleSvg ?>
    </div>
    <div class="col-sm-7">
        <b>ID: <?= $model->id ?></b><br>
        <b>Дата появления:</b> <?= $model->createdAt ?><br>
        <b>Дата падения:</b> <?= $model->fallAt == null ? "не упало" : $model->fallAt ?><br>
        <b>Пролежало на земле:</b> <?= $timeOnGround ?><br>
        <b>Съедено:</b> <?= $model->eaten.'%' ?><br>
    </div>
</div>
<div class="footer">
    <?php
        if ($canEat){
            echo Html::button('Откусить', ['class' => 'btn btn-success', 'onclick' => 'eatApple('.$model->id.')']);
            echo Html::button('Съесть', ['class' => 'btn btn-danger', 'onclick' => 'eatApple('.$model->id.',100)']);
        }
        elseif ($canFall){
            echo Html::button('Сорвать', ['class' => 'btn btn-warning',
                'onclick' => 'appleAction("down", '.$model->id.'); $("#appleModal").modal("toggle");']);
        }
    ?>

</div>
