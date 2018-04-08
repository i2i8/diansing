<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "remark".
 *
 * @property int $id
 * @property int $eid 关联索引
 * @property string $remark 备注描述
 * @property string $created 录入时间
 * @property string $updated 调整时间
 *
 * @property Rprice $e
 */
class Remark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'remark';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eid'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['remark'], 'string', 'max' => 255],
            [['eid'], 'exist', 'skipOnError' => true, 'targetClass' => Rprice::className(), 'targetAttribute' => ['eid' => 'pid']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'eid' => '关联索引',
            'remark' => '备注描述',
            'created' => '录入时间',
            'updated' => '调整时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getE()
    {
        return $this->hasOne(Rprice::className(), ['pid' => 'eid']);
    }
}
