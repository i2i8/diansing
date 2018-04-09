<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use common\models\Rtype;
use common\models\RtypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response; 

/**
 * RtypeController implements the CRUD actions for Rtype model.
 */
class RtypeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['logout', 'index','create','delete', 'view', 'editable'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Rtype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RtypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable'))
        {            
            $typeiId = Yii::$app->request->post('editableKey');
            $type = Rtype::findOne($typeiId);
            $out = Json::encode(['output' => '','message' => '']);
            
            $post = [];
            $posted = current($_POST['Rtype']);
//             echo "<pre>";
//             var_dump($posted);
//             echo "</pre>";
//             exit;
            $post['Rtype'] = $posted;
            if ($type->load($post)) 
            {
                $type->save();
            }
            return $out;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rtype model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rtype();

        /**
         * Try - 使用异常的函数应该位于 "try" 代码块内。如果没有触发异常，
         * 则代码将照常继续执行。但是如果异常被触发，会抛出一个异常。
         */
        try {
            if ($model->load(Yii::$app->request->post()))
            {
                
                $model->created = date('Y-m-d H:i:s');
                $model->save();
                
                //获取插入主键并作为vid值当前条插入的记录
                $vid = $model->getPrimaryKey();
                $model->vid = $vid;
                $model->save();
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Rtype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rtype::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionEditable() 
    {
        if (Yii::$app->request->post('hasEditable')) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            $model = $this->findModel(Yii::$app->request->post('editableKey'));
            
            $out = [
                'output'    => '',
                'message'   => '',
            ];
            
            // fetch the first entry in posted data (there should
            // only be one entry anyway in this array for an
            // editable submission)
            // - $posted is the posted data for Model without any indexes
            // - $post is the converted array for single model validation
            $posted = current($_POST[$model->formName()]);
            $post[$model->formName()] = $posted;
            Yii::info('processed post:' . print_r($posted,true));
            
            if ($model->load($post)) {
                if (!$model->save()) {
                    $out = [
                        'output'    => '',
                        'message'   => $model->getFirstError(),
                    ];
                }
                Yii::info('editable returns:' . print_r($out,true));
                return $out;
            }
        }
    }
}
