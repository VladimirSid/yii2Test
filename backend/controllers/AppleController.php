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


class AppleController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['info','create','down','eat', 'stat'],
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
                    'eat' => ['post'],
                    'info' => ['get'],
                    'stat' => ['get']
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }


    /*** ИНФО О ЯБЛОКЕ ***/
    public function actionInfo($id){
        $apple = Apples::findOne(['id' => $id]);

        $diffTime = date_diff(new \DateTime(),new \DateTime($apple->fallAt));
        $canEat = false;
        $canFall = false;
        if ($apple->fallAt == null) {
            $timeOnGround = "не упало";
            $canFall = true;
        }
        elseif ($diffTime->h >= 5 || $diffTime->d > 0) $timeOnGround = "более 5 часов";
        else {
            $timeOnGround = $diffTime->h." ч. ".$diffTime->i." мин.";
            $canEat = true;
        }

        $appleSvg = new AppleHtml();
        return $this->renderAjax('info',[
            'appleSvg' => $appleSvg->getAppleSvg($apple->id,  0, 0, $apple->color, $apple->eaten, true),
            'model' => $apple,
            'timeOnGround' => $timeOnGround,
            'canEat' => $canEat,
            'canFall' => $canFall
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

    /*** ПАДЕНИЕ ЯБЛОКА ***/
    /* $fallenID - id яблока либо явно указывается из карточки яблока,
        либо рандомно из висящих на дереве на текущей странице */
    public function actionDown(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pageOnTree = isset($_GET["pageOn"]) ? $_GET["pageOn"] : 1;
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        if ($id != null){
            $fallenID = $id;
        }
        else{
            $applesOnTree = Apples::find()->where(['fallAt' => null])->select(['id'])->offset(3*((int)$pageOnTree-1))
                ->limit(3)->all();
            if ($applesOnTree == null) return ['success' => false];
            $fallenID = $applesOnTree[mt_rand(0, count($applesOnTree)-1)];
        }
        $apple = Apples::findOne(['id' => $fallenID]);
        if ($apple == null) return ['success' => false];
        $apple->fallAt = new Expression('NOW()');
        return[
            'success' => $apple->validate() && $apple->save()
        ];

    }

    /**** ОТКУСЫВАНИЕ ЯБЛОКА ****/
    /*  1 укус от 2% до 17%
        при достижении 100% яблоко удаляется */
    public function actionEat(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax && isset($_POST["percent"]) && isset($_POST["id"])){
            $id = $_POST["id"];
            $eat = $_POST["percent"];
            if (is_numeric($eat) && ($eat == 100 || ($eat <= 17 && $eat > 1))) {
                $apple = Apples::find()->where(['id' => $id])
                    ->andWhere(['not', ['fallAt' => null]])
                    ->andWhere(['>', 'DATE_ADD(`fallAt`, INTERVAL 5 HOUR)', new Expression("NOW()")])
                    ->one();
                if ($apple == null)  return['success' => false];
                $apple->eaten += $eat;
                if ($apple->eaten >= 100) return ['success' => $apple->delete()];
                return[
                    'success' => $apple->save()
                ];
            }
        }
        return[
            'success' => false
        ];
    }


    public function actionStat(){
        $appleStat = Apples::find()->select([
            'count(case when `fallAt` is null then 1 end) onTree',
            'count(case when DATE_ADD(`fallAt`, INTERVAL 5 HOUR) > NOW() then 1 end) fallenApples',
            'count(case when DATE_ADD(`fallAt`, INTERVAL 5 HOUR) <= NOW() then 1 end) badApples',
        ])->asArray()->all();


        return $this->renderAjax('stat',[
            'stat' => $appleStat
        ]);
    }
}
