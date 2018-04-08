<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rtype;

/**
 * RtypeSearch represents the model behind the search form of `backend\models\Rtype`.
 */
class RtypeSearch extends Rtype
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vid'], 'integer'],
            //当在联表顶部框搜索，提示是整数之类提示时，要表关联字段由上面的integer属性移到下面的safe属性里
            [['tid', 'type', 'created', 'updated'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Rtype::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //t->来源于Rtype模型尾部的hanone方法，注意，首单词首字母要小写
        $query ->joinWith('t');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'vid' => $this->vid,
            /**此tid行，在下面的like字段里添加后，相应的，这里的这行就要去掉，否则，查不出来结果***Start*教程11*/
            //'tid' => $this->tid,
            /**此tid行，在下面的like字段里添加后，相应的，这里的这行就要去掉，否则，查不出来结果***End*/
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
        //此句，需要在pma里用SQL语句执行测试字段，name对应Rmodel表里的name字段，$this->tid对应上面注释的对象
        ->andFilterWhere(['like', 'name', $this->tid]);

        return $dataProvider;
    }
}
