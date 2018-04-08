<?php

namespace backend\models;

use Yii;
use common\models\Rmodel;
use common\models\Rtype;

/**
 * This is the model class for table "rprice".
 *
 * @property int $id
 * @property int $pid EQtoID
 * @property int $index_mid 品牌型号
 * @property int $index_tid 维修类型
 * @property int $nowprice 当前价格
 * @property int $willprice 出库价格
 * @property string $remark 备注描述
 * @property string $created 录入时间
 * @property string $updated 调整时间
 *
 * @property Remark[] $remarks
 * @property Rmodel $indexM
 * @property Rtype $indexT
 */
class Rprice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rprice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'index_mid', 'index_tid', 'nowprice', 'willprice'], 'integer'],
            [['index_mid', 'index_tid'], 'required'],
            [['created', 'updated'], 'safe'],
            [['remark'], 'string', 'max' => 255],
            [['index_mid'], 'exist', 'skipOnError' => true, 'targetClass' => Rmodel::className(), 'targetAttribute' => ['index_mid' => 'mid']],
            [['index_tid'], 'exist', 'skipOnError' => true, 'targetClass' => Rtype::className(), 'targetAttribute' => ['index_tid' => 'vid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'EQtoID',
            'index_mid' => '品牌型号',
            'index_tid' => '维修类型',
            'nowprice' => '当前价格',
            'willprice' => '出库价格',
            'remark' => '备注描述',
            'created' => '录入时间',
            'updated' => '调整时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemarks()
    {
        return $this->hasMany(Remark::className(), ['eid' => 'pid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndexM()
    {
        return $this->hasOne(Rmodel::className(), ['mid' => 'index_mid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndexT()
    {
        return $this->hasOne(Rtype::className(), ['vid' => 'index_tid']);
    }
}
