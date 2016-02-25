<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Upload;
use frontend\models\Citymaps;
use frontend\models\CitymapsSearch;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;


//------For Google Map--------------
use tugmaks\GoogleMaps\Map;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $upload = new Upload();
        $model=new Citymaps();
        $maps=new CitymapsSearch();
        $dataMaps = $maps->search(Yii::$app->request->queryParams);

        // ----------Upload CSV and save DB-----------------------
        if ($upload->load(Yii::$app->request->post())) {
            if($upload->file = UploadedFile::getInstance($upload, 'file')){
                $upload->file->saveAs( 'uploads/'.$upload->file->baseName.'.'.$upload->file->extension );
                $csv_file = 'uploads/'.$upload->file->baseName.'.'.$upload->file->extension;
                $filecsv = file($csv_file);
               // print_r($filecsv);
                foreach ($filecsv as $v) {
                    $m=explode('",', $v);
                    $m[0]=str_replace('"', '', $m[0]);
                    $m[1]=str_replace('"', '', $m[1]);
                    $m[2]=str_replace('"', '', $m[2]);

                    // Get coordinates from postcode or address using Google API
                    $address = $m[0];
                    $response = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true');
                    $response = json_decode($response);
                    $coor=$response->results[0]->geometry->location->lat.", ".$response->results[0]->geometry->location->lng;

                    // Date
                    if($this->isValidDate($m[2])==true){
                        $today=$m[2];
                    }else{
                        $today=date("d.m.Y H:i:s"); 
                    }
                    Yii::$app->db->createCommand()->insert('citymaps', ['address'=>$m[0], 'coorYX'=>$coor , 'color'=>$m[1], 'date'=>$today])->execute();
                }
            }
        }
        
        // Google Maps API, Point 
        $gmap=Citymaps::find()->all();
        $getMap=array();
        foreach ($gmap as $v) {
            /**
            * $v->address
            *  OR
            * $v->coorYX
            */
            $aa=array('position' => $v->address, 'color' => $this->rgb2html($v->color) );
            array_push($getMap, $aa);
        }
       
        $map = Map::widget([
            'zoom' => 8,
            'center' => [50.9033057, 31.1398592],
            'width' => 600,
            'height' => 600,
            'mapType' => Map::MAP_TYPE_ROADMAP,
            'markers' => $getMap
        ]);


        return $this->render('index',['dataMaps'=>$dataMaps,'map'=>$map,'gmap'=>$gmap,'upload'=>$upload,'model'=>$maps]);
    }


    // Download CSV
    public function actionDownload(){

        //$path = Yii::getAlias('@webroot') . '/uploads';
        $file = 'download/down'.date("d-m-Y").'.csv';
        $output = fopen($file, "w") or die("Unable to open file!");
        $arr=array();
        $down=null;
        $maps=Citymaps::find()->all();


        $arr=array("Адрес", "Широта", "Долгота", "Колір", "Дата");
        fputcsv($output, $arr);

        foreach ($maps as $m) {
            $me=explode(", ", $m->coorYX);
            $arr=array($m->address,$me[0],$me[1],$m->color,$m->date);
            fputcsv($output, $arr);
        }
        
        if (file_exists($file)) {

           //Yii::$app->response->sendFile($file);
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            die();
        } 
       // fclose($myfile);
        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $dmap=Citymaps::findOne($id);
        $dmap->delete();
        return $this->redirect(['index']);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    // RGB to Hex
    function rgb2html($aaa)
    {
        if(empty($aaa)){return false;}

        $aaa=str_replace("rgb(", "", $aaa);
        $aaa=str_replace("rgba(", "", $aaa);
        $aaa=str_replace("RGB(", "", $aaa);
        $aaa=str_replace("RGBA(", "", $aaa);
        $aaa=str_replace(")", "", $aaa);

        $exp=explode(",", $aaa);

        $r=$exp[0];
        $g=$exp[1];
        $b=$exp[2];

        if (is_array($r) && sizeof($r) == 3)
            list($r, $g, $b) = $r;

        $r = intval($r); $g = intval($g);
        $b = intval($b);

        $r = dechex($r<0?0:($r>255?255:$r));
        $g = dechex($g<0?0:($g>255?255:$g));
        $b = dechex($b<0?0:($b>255?255:$b));

        $color = (strlen($r) < 2?'0':'').$r;
        $color .= (strlen($g) < 2?'0':'').$g;
        $color .= (strlen($b) < 2?'0':'').$b;
        return $color;
    }
    
     //Date validation

    public static function isValidDate($dateVar) {
        if ($dateVar != '') {
            if (strtotime($dateVar) == null) {
                return false;
            }
            $date = date_parse($dateVar);
            if (!checkdate($date["month"], $date["day"], $date["year"])) {
                return false;
            }
        }
        return true;
    }

}
