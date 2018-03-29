<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property int $mid 自增id
 * @property string $userid 成员id
 * @property string $name 成员名称
 * @property int $gender 性别
 * @property string $mobile 手机号码
 * @property string $department 所属部门
 * @property int $depid 部门id
 * @property string $ordernum 部门排序值
 * @property int $status 激活状态
 * @property int $enable 启用/禁用
 * @property string $position 职位信息
 * @property int $isleader 是否为上级
 * @property string $join_from JoinFrom
 * @property string $email 邮箱
 * @property string $created 加入时间
 * @property string $updated 更新时间
 * @property string $authorization 内部权限
 * @property int $hide_mobile 隐藏手机号
 * @property string $openid isRegister
 * @property string $avatar_mediaid 头像mediaid
 * @property string $avatar 头像URL
 * @property string $telephone 固定电话
 * @property string $english_name 英文名
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'depid', 'status', 'enable', 'isleader', 'hide_mobile'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['userid', 'name'], 'string', 'max' => 15],
            [['mobile'], 'string', 'max' => 11],
            [['department', 'ordernum', 'join_from', 'authorization', 'avatar_mediaid', 'avatar', 'telephone', 'english_name'], 'string', 'max' => 255],
            [['position', 'email'], 'string', 'max' => 16],
            [['openid'], 'string', 'max' => 28],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mid' => '自增id',
            'userid' => '成员id',
            'name' => '成员名称',
            'gender' => '性别',
            'mobile' => '手机号码',
            'department' => '所属部门',
            'depid' => '部门id',
            'ordernum' => '部门排序值',
            'status' => '激活状态',
            'enable' => '启用/禁用',
            'position' => '职位信息',
            'isleader' => '是否为上级',
            'join_from' => 'JoinFrom',
            'email' => '邮箱',
            'created' => '加入时间',
            'updated' => '更新时间',
            'authorization' => '内部权限',
            'hide_mobile' => '隐藏手机号',
            'openid' => 'isRegister',
            'avatar_mediaid' => '头像mediaid',
            'avatar' => '头像URL',
            'telephone' => '固定电话',
            'english_name' => '英文名',
        ];
    }
}
