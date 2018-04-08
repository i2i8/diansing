<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rmodel".
 *
 * @property int $id
 * @property int $mid 关联索引
 * @property string $name 品牌型号
 * @property string $created 录入时间
 * @property string $updated 调整时间
 *
 * @property Rprice[] $rprices
 * @property Rtype[] $rtypes
 */
class Rmodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rmodel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['name'], 'string', 'max' => 28],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mid' => 'EQtoID',
            'name' => '品牌型号',
            'created' => '录入时间',
            'updated' => '调整时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRprices()
    {
        return $this->hasMany(Rprice::className(), ['index_mid' => 'mid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRtypes()
    {
        return $this->hasMany(Rtype::className(), ['tid' => 'mid']);
    }
    
    public static function getCategories()
    {
        return Self::find()->select(['name', 'mid'])->indexBy('mid')->column();
    }
}
