<?php

namespace backend\controllers;

use Yii;
use common\models\Rtype;
use backend\models\Rprice;
use backend\models\RpriceSearch;
use backend\models\Remark;
use backend\models\Model;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RpriceController implements the CRUD actions for Rprice model.
 */
class RpriceController extends Controller
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
                        'actions' => ['logout', 'index','create','delete','update','view', 'subcat'],
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
     * Lists all Rprice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RpriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rprice model.
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
     * Creates a new Rprice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rprice();
        $modelsRemark = [new Remark];
        /**
         * Try - 使用异常的函数应该位于 "try" 代码块内。如果没有触发异常，
         * 则代码将照常继续执行。但是如果异常被触发，会抛出一个异常。
         */
        try {
            if ($model->load(Yii::$app->request->post()))
            {
                
                $model->created = date('Y-m-d H:i:s');
                $model->save();
                //获取插入主键并作为amid值当前条插入的记录
                $pid = $model->getPrimaryKey();
                $model->pid = $pid;
                $model->save();
                //exit;
                //-----------------------------------------------------------------
                $modelsRemark = Model::createMultiple(Remark::classname());
                
                Model::loadMultiple($modelsRemark, Yii::$app->request->post());
                
                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($modelsRemark) && $valid;
                
                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->save(false)) {
                            foreach ($modelsRemark as $modelsRemarks) {
                                $modelsRemarks->eid = $model->pid;
                                $modelsRemarks->created = date('Y-m-d H:i:s');
                                if (! ($flag = $modelsRemarks->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
                //-----------------------------------------------------------------
                
                //                 return $this->redirect(['view', 'id' => $model->id]);
            }
            
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
        
        
        return $this->render('create', [
            'model' => $model,
            'modelsRemark' => (empty($modelsRemark)) ? [new Remark] : $modelsRemark
        ]);
    }

    /**
     * Updates an existing Rprice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsRemark = $model->remarks;
//                 echo "<pre>";
//                 var_dump($model);
//                 echo "</pre>";
//                 exit;
        //$modelsRemark = [new Aremark];
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //备注字段之前有两条记录，例如id为8和id为9，9是准备减掉的，点保存后，列出这两条记录的id
            $oldIDs = ArrayHelper::map($modelsRemark, 'id','id');
            //$oldIDs = Aremark::findOne(['rid' => $id]);
//                         echo "<pre>";
//                         var_dump($oldIDs);
//                         echo "</pre>";
//                         exit;
            //剔除了id为9的记录
            $modelsRemark = Model::createMultiple(Remark::classname(), $modelsRemark);
            Model::loadMultiple($modelsRemark, Yii::$app->request->post());
            //$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRemark, 'rid', 'remarks')));
            //将要剔除的id为9的记录赋值给$deletedIDS，准备删除
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRemark, 'id', 'id')));
//                         echo "<pre>";
//                         var_dump($deletedIDs);
//                         echo "</pre>";
//                         exit;
            // validate all models 验证通过，返回true
            $valid = $model->validate();
            //                 echo "<pre>";
            //                 var_dump($valid);
            //                 echo "</pre>";
            //                 exit;
            //验证通过，返回true
            $valid = Model::validateMultiple($modelsRemark) && $valid;
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Remark::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsRemark as $modelsRemarks) {
                            //                             echo "<pre>";
                            //                             var_dump($modelsRemarks);
                            //                             echo "<hr>";
                            //                             var_dump($model->aprid);
                            //                             echo "<hr>";
                            //                             var_dump($modelsRemarks->rid);
                            //                             echo "</pre>";
                            //                             exit;
                            $modelsRemarks->eid = $model->pid;
                            if (! ($flag = $modelsRemarks->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'modelsRemark' => (empty($modelsRemark)) ? [new Remark] : $modelsRemark
        ]);
    }

    /**
     * Deletes an existing Rprice model.
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
     * Finds the Rprice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rprice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rprice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionSubcat()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        if (isset(Yii::$app->request->post()['depdrop_parents'])) {
            $parents = Yii::$app->request->post('depdrop_parents');
            if ($parents != null) {
                $cat_id = $parents[0];
                return [
                    'output' => Rtype::getSubCatList($cat_id),
                    'selected' => ''
                ];
            }
        }
        return [
            'output' => '',
            'selected' => ''
        ];
    }
}
