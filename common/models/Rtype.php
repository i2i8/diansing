<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rtype".
 *
 * @property int $id
 * @property int $vid EQtoID
 * @property int $tid 关联索引
 * @property string $type 维修类型
 * @property string $created 录入时间
 * @property string $updated 调整时间
 *
 * @property Rprice[] $rprices
 * @property Rmodel $t
 */
class Rtype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rtype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid', 'tid'], 'integer'],
            [['tid'], 'required'],
            [['created', 'updated'], 'safe'],
            [['type'], 'string', 'max' => 28],
            [['tid'], 'exist', 'skipOnError' => true, 'targetClass' => Rmodel::className(), 'targetAttribute' => ['tid' => 'mid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vid' => 'EQtoID',
            'tid' => '关联索引',
            'type' => '维修类型',
            'created' => '录入时间',
            'updated' => '调整时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRprices()
    {
        return $this->hasMany(Rprice::className(), ['index_tid' => 'vid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasOne(Rmodel::className(), ['mid' => 'tid']);
    }
    
    public static function getSubCatList($categoryID, $dependent = false)
    {
        $subCategory = self::find()
        ->where(['tid' => $categoryID]);
        
        $out = [];
        $isAjax = Yii::$app->request->isAjax;
        if ($isAjax == true) {
            //echo 'update';
            $result = $subCategory->select(['vid', 'type'])->asArray()->all();
//             $result = self::find()
//             ->select(['id', 'type'])
//             ->where(['tid' => $categoryID])
//             ->asArray()
//             ->all();
            //                             echo "<pre>";
            //                             var_dump($result);
            //                             echo "</pre>";
            //             exit;
            
            foreach ($result as $i => $me) {
                //                 echo "<pre>";
                //                 var_dump($me);
                //                 echo "</pre>";
                //                 exit;
                $out[] = [
                    'id' => $me['vid'],
                    'name' => $me['type'],
                ];
                
            }
            
            return $out;
        } else {
            //return $subCategory->select(['type'])->indexBy('id')->column();
            return self::find()->select(['type'])->where(['tid' => $categoryID])->indexBy('vid')->column();
        }
        
    }
}
