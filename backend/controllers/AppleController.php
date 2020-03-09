<?php

namespace backend\controllers;

use app\models\Apples;
use common\classes\AppleHtml;
use common\classes\UsefullFunctions;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\db\Expression;
use yii\helpers\Html;


class AppleController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['info','create','down'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'down' => ['post'],
                    'info' => ['get']
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionInfo($id){
       // Yii::$app->response->format = Response::FORMAT_JSON;
        $apple = Apples::findOne(['id' => $id]);

        $timeOnGround = date_diff(new \DateTime(),new \DateTime($apple->fallAt));
        $appleSvg = new AppleHtml();
        return $this->renderAjax('info',[
            'appleSvg' => $appleSvg->getAppleSvg($apple->id,  0, 0, $apple->color, $apple->eaten, true),
            'model' => $apple,
            'timeOnGround' => $timeOnGround
        ]);
    }


    public function actionCreate(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $funcs = new UsefullFunctions();
        $apple = new Apples();
        $apple->color = $funcs->randomColor();
        $apple->createdAt = date($funcs->generateTimestamp());
        $apple->eaten = 0;
        return[
            'success' => $apple->validate() && $apple->save()
        ];

    }

    public function actionDown(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pageOnTree = isset($_GET["pageOn"]) ? $_GET["pageOn"] : 1;
        $applesOnTree = Apples::find()->where(['fallAt' => null])->select(['id'])->offset(3*((int)$pageOnTree-1))
            ->limit(3)->all();
        $fallenID = $applesOnTree[mt_rand(0, count($applesOnTree)-1)];
        $apple = Apples::findOne(['id' => $fallenID]);
        $apple->fallAt = new Expression('NOW()');
        return[
            'success' => $apple->validate() && $apple->save()
        ];

    }
}
