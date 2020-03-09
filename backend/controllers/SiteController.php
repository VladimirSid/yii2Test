<?php
namespace backend\controllers;

use app\models\Apples;
use common\classes\AppleHtml;
use common\classes\UsefullFunctions;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\Response;
use yii\db\Expression;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','apple-info'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        /* выбранные страницы */
        $pageOnTree = isset($_GET["pageOn"]) ? $_GET["pageOn"] : 1;
        $pageFallTree = isset($_GET["pageFall"]) ? $_GET["pageFall"] : 1;
        $pageBadApple = isset($_GET["pageBad"]) ? $_GET["pageBad"] : 1;

        /* яблоки на дереве */
        $pagesOn = Apples::find()->where(['fallAt' => null])->count()/3;
        $applesOnTree = Apples::find()->where(['fallAt' => null])->offset(3*((int)$pageOnTree-1))->limit(3)->all();

        /* упавшие яблоки */
        $pagesFall = Apples::find()->where(['>', 'DATE_ADD(`fallAt`, INTERVAL 5 HOUR)', new Expression("NOW()")])->count()/3;
        $applesFallTree = Apples::find()->where(['>', 'DATE_ADD(`fallAt`, INTERVAL 5 HOUR)', new Expression("NOW()")])->offset(3*((int)$pageFallTree-1))->limit(3)->all();

        /* испорченные яблоки */
        $pagesBad = Apples::find()->where(['<=', 'DATE_ADD(`fallAt`, INTERVAL 5 HOUR)', new Expression("NOW()")])->count()/3;
        $applesBad = Apples::find()->where(['<=', 'DATE_ADD(`fallAt`, INTERVAL 5 HOUR)', new Expression("NOW()")])->offset(3*((int)$pageBadApple-1))->limit(3)->all();

        /* html <ul>...</ul> пагинация для 3 типов яблок */
        $htmlPagesOn = $this->paginationHtml($pageOnTree, ceil($pagesOn), $applesOnTree, "on");
        $htmlPagesFall = $this->paginationHtml($pageFallTree, ceil($pagesFall), $applesFallTree, "fall");
        $htmlPagesBad = $this->paginationHtml($pageBadApple, ceil($pagesBad), $applesBad, "bad");

        return $this->render('index', [
            'appleOnTree' => $applesOnTree,
            'appleFallTree' => $applesFallTree,
            'appleBad' => $applesBad,
            'pagesOn' => ceil($pagesOn),
            'htmlPagesOn' => $htmlPagesOn,
            'htmlPagesFall' => $htmlPagesFall,
            'htmlPagesBad' => $htmlPagesBad
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    private function paginationHtml($selPage, $pages, $apples, $type){
        $disabled = $selPage==1 || $pages < 2 ? 'disabled' : '';
        $listOfLi = '<li class="page-item '.$disabled.'">'
            .Html::a('<<', null, ['class' => 'page-link',
                'onclick' => 'changePageOn(this,'.$selPage.', "down", "'.$type.'")']).
        '</li>';

        if (count($apples) == 0) {
            $listOfLi = '<li class="page-item disabled"><a>...</a></li>';
        }
        else {
            if ($pages < 3){
                $start = 1;
                $end = $pages;
            }
            else/* ($pagesOn >= 3)*/{
                if ($selPage > $pages - 2) $start = $pages - 2;
                elseif ($pages > 3 && $selPage > 2) $start = $selPage - 1;
                else $start = 1;

                if ($selPage < 3 && $pages > 2) $end = 3;
                elseif ($selPage >= $pages - 1) $end = $pages;
                else $end = $selPage + 1;
            }
            for ($i = $start; $i <= $end; $i++){
                $listOfLi .= $i == $selPage ? '<li class="page-item active">' : '<li class="page-item">';
                $listOfLi .= Html::a($i, null, ['class' => 'page-link', 'onclick' =>'setPage(this, "'.$type.'")']).'</li>';
            }


        }
        $disabled = $pages < 2 || $pages == $selPage ? 'disabled' : '';
        $listOfLi .= '<li class="page-item '.$disabled.'">'
            .Html::a('>>', null, ['class' => 'page-link',
                'onclick' => 'changePageOn(this,'.$selPage.', "up", "'.$type.'")']).
        '</li>';
        return
            '<ul class="pagination">'.$listOfLi.'</ul>';
    }


}
