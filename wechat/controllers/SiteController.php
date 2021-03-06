<?php
namespace wechat\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

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
                        'actions' => ['logout', 'index'],
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
    public function init()
    {
        if ($this->isMobileBrowser()) {
            echo 'Mobile';
            //Yii::app()->theme = "mobile-white-blue";
        }
        parent::init();
    }
    
    public function beforeAction($action)
    {
        /**
         * 审计这个动作执行之前的要求，全局生效
         * @this:通过自定义菜单访问到控制器后，首先访问的是这个beforeAction,因此，必须从这里获取到随URL传来的code，而后，再传递给其它控制器用
         * @See:http://hudeyong926.iteye.com/blog/1396317
         * 指定控制器要执行的方法
         *   if($this->action->id == 'index')
         *       { ...... }
         * */
         //@See:http://www.yiiframework.com/doc-2.0/guide-runtime-sessions-cookies.html
         $session = Yii::$app->session;
         // check if a session is already open
         if (!$session->isActive)
         {
             $session->open();
         }
         
         // destroys all data registered to a session.
         // $session->destroy();
         // $session->removeAll();
         return parent::beforeAction($action);
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $session = Yii::$app->session;
        $code = Yii::$app->request->get('code');
        if (!isset($session['userid'])) {
            $this->valiData($code);
        }
        exit($session['userid']);
//         $model = new LoginForm();
//         if ($model->load(Yii::$app->request->post()) && $model->login()) {
//             return $this->goBack();
//         } else {
//             $model->password = '';

//             return $this->render('login', [
//                 'model' => $model,
//             ]);
//         }
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

    public function isMobileBrowser()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        return preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4));
    }
    
    private function valiData($code)
    {
        $session = Yii::$app->session;
        $code    = isset($code)?$code:'Code Null.';
        $wechat  = Yii::$app->agent_0;
        $result  = $wechat->getUserInfo($code, $agentId = '');
        /**OpenId与UserId，为方便，让仅存其一，当用户手机激活后，OpenId即刻由session删除*/
        if (isset($result['OpenId'])) {
            return $openid  = isset($result['OpenId'])?$session['openid'] = $result['OpenId']:'OpenId is Null.';
        }elseif ($result['UserId']) {
            $session->remove('openid');
            $userid  = isset($result['UserId'])?$session['userid'] = $result['UserId']:'UserId is Null.';
            $wichat      = Yii::$app->member;
            $depUser = $wichat->getUser($userid);
            
            /**获取成员所在的部门id-----Begin-----*/
            $departmentId = '';
            foreach($depUser as $valueKey => $valueUser)
            {
                if($valueKey == 'department')
                {
                    foreach($valueUser as $key => $depid)
                    {
                        $departmentId = $depid;
                        break;
                    }
                }
            }
            /**获取成员所在的部门id-----End-----*/
            //获取部门中文名称---Start
            $deplist = $wechat->getDepartmentList($id = $departmentId);
            $userdep = '';
            foreach($deplist as $uKey => $depinfo)
            {
                $userdep = $depinfo;
                break;
            }
            //部门Order值需要转换为string
            $orderString = strval($userdep['order']);
            //var_dump($userdep['order']);
            //exit;
            //获取部门中文名称---End
            $model = new Member();
            $isInsert = Member::findOne(['mobile' => $depUser['mobile']]);
            if (is_null($isInsert)) {
                $model->userid     = $userid;
                $model->name       = $depUser['name'];
                $model->mobile     = $depUser['mobile'];
                $model->gender     = $depUser['gender'];
                $model->status     = $depUser['status'];
                $model->isleader   = $depUser['isleader'];
                $model->enable     = $depUser['enable'];
                $model->avatar     = $depUser['avatar'];
                $model->department = $userdep['name'];
                $model->ordernum   = $orderString;
                $model->created    = date('Y-m-d H:i:s');
                $model->join_from  = 'Batch-Join';
                $model->save() ? $model : null;
                if (!$model->save())
                {
                    /*如果没有save成功就会打印出错误*/
                    var_dump($model->errors);
                }
            }
            
            $isUpdate = Member::findOne(['mobile' => $depUser['mobile'],'status' => '4']);
            
            if (isset($isUpdate)) {
                $isUpdate->userid     = $userid;
                $isUpdate->name       = $depUser['name'];
                $isUpdate->gender     = $depUser['gender'];
                $isUpdate->status     = $depUser['status'];
                $isUpdate->isleader   = $depUser['isleader'];
                $isUpdate->enable     = $depUser['enable'];
                $isUpdate->avatar     = $depUser['avatar'];
                $isUpdate->department = $userdep['name'];
                $isUpdate->ordernum   = $orderString;
                $isUpdate->update();
                if (!$isUpdate->update())
                {
                    /*如果没有save成功就会打印出错误*/
                    var_dump($isUpdate->errors);
                }
            }
            //             echo '<pre>';
            //             var_dump($isUpdate->update());
            //             echo '</pre>';
            //             exit;
        }        
    }
}
