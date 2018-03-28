<?php

use yii\db\Migration;

/**
 * Class m180327_071348_member
 */
class m180327_071348_member extends Migration
{
    const TBL_MEMBER= '{{%member}}';
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
        $this->createTable(self::TBL_MEMBER, [
            //如下字段，由var_dump($userinfo)获得;
            //自增id
            'mid'	        => $this->primaryKey()->COMMENT('自增id'),
            'userid'   	 	=> $this->string(15)->Null()->COMMENT('成员id'),
            'name'   	 	=> $this->string(15)->Null()->COMMENT('成员名称'),
            'gender'  		=> $this->integer(1)->Null()->COMMENT('性别'),
            'mobile'  	 	=> $this->string(11)->Null()->COMMENT('手机号码'),
            'department' 	=> $this->string()->Null()->COMMENT('所属部门'),
            'depid'   	 	=> $this->integer()->Null()->COMMENT('部门id'),
            'ordernum' 	 	=> $this->string()->Null()->COMMENT('部门排序值'),
            'status'   	 	=> $this->integer()->Null()->COMMENT('激活状态'),
            'enable'     	=> $this->integer()->Null()->COMMENT('启用/禁用'),
            'position'   	=> $this->string(16)->Null()->COMMENT('职位信息'),
            'isleader'   	=> $this->integer(1)->Null()->COMMENT('是否为上级'),
            'join_from'     => $this->string()->Null()->COMMENT('JoinFrom'),
            'email' 		=> $this->string(16)->Null()->COMMENT('邮箱'),
            'created' 	    => $this->dateTime()->notNull()->defaultValue(0)->COMMENT('加入时间'),
            'updated' 	    => $this->timestamp()->COMMENT('更新时间'),
            'authorization' => $this->string()->Null()->COMMENT('内部权限'),
            'hide_mobile' 	=> $this->integer(1)->Null()->COMMENT('隐藏手机号'),
            'openid'    	=> $this->string(28)->Null()->COMMENT('isRegister'),
            'avatar_mediaid'=> $this->string()->Null()->COMMENT('头像mediaid'),
            'avatar'        => $this->string()->Null()->COMMENT('头像URL'),
            'telephone'  	=> $this->string()->Null()->COMMENT('固定电话'),
            'english_name'  => $this->string()->Null()->COMMENT('英文名'),
        ], $tableOptions);
    }
    
    public function safeDown()
    {
        $this->dropTable(self::TBL_MEMBER);
    }
}
