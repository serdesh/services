<?php

namespace app\controllers;

use app\models\Journal;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\Fias;
use app\models\Stat;
use app\models\Test;
use yii\web\UploadedFile;

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
                'only' => ['logout'],
                'rules' => [
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
     * @return string
     */
    public function actionIndex()
    {
        if (!app()->user->isGuest){
            $executor = User::getShortnameWitchoutDecodeChars(Yii::$app->user->identity->fio);
            $dataProvider = new ActiveDataProvider([
                'query' => Journal::find()
                    ->select('*')
                    ->where(['like', 'EXECUTOR_MAIL', $executor])
                    ->andWhere(['ISPOLNENO' => '0'])
                    ->andWhere(['not', ['SROK' => null]])
                    ->orderBy(['ID_MAIL' => SORT_DESC, 'NUM_MAIL' => SORT_DESC]),
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('index');

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) { // Если есть, загружаем post данные в модель через родительский метод load класса Model
            // $model->openpass = $model->password_repeat;
            if ($user = $model->signup()) { //Если регистрация
                if (Yii::$app->getUser()->login($user)) { //Логиним пользователя, если регистрация успешна
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [//Просто рендерим вид, если один из if вернул false
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionFias()
    {
        $model = new Fias();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->render('fias-confirm', ['model' => $model,]);
        } else {
            return $this->render('fias', ['model' => $model,]);
        }
        //return $this->render('fias', ['model' => $model,]);
    }

    public function actionStat()
    {
        $model = new Stat();
//        if (Yii::$app->request->isPjax) {
//            $answer = true;
//            return $this->render('stat', compact('model', 'answer'));
//        }
        //return $this->render('stat', compact('model'));
        return $this->render('stat', ['model' => $model,]);
    }

    public function actionStreetLists()
    {
        $city_code = Yii::$app->request->post('citycode');
        $content = file_get_contents('http://basicdata.ru/api/json/fias/addrobj/' . $city_code . '/');
        $data = json_decode($content, true);

        foreach ($data['data'] as $street) {
            if ($street) {
                if ($street['actstatus'] == '1') {
                    $option[] = '<option value ="' . $street['aoguid'] . '">' . $street['shortname'] . '. ' . $street['formalname'] . '</option>';
                }
            }
        }

        if (count($option) > 0) {
            foreach ($option as $value) {
                echo $value;
            }
        } else {
            echo '<option> -Выберите значение-</option>';
            echo '<option value="' . $city_code . '"> -Улицы отсутствуют-</option>';
        }
    }

    public function actionHouseLists()
    {
        $street_code = Yii::$app->request->post('streetcode');
        $content = file_get_contents('http://basicdata.ru/api/json/fias/house/' . $street_code . '/');
        $data = json_decode($content, true);
        if (count($data) > 0) {
            foreach ($data['data'] as $house) {
                $stat = '';
                if ($house['eststatus'] == '1') {
                    $stat = 'владение';
                } elseif ($house['eststatus'] == '2') {
                    $stat = 'дом';
                } elseif ($house['eststatus'] == '3') {
                    $stat = 'домовладение';
                }
                echo '<option>' . $stat . ' ' . $house['housenum'] . '</option>';
            }
        } else {
            echo '<option>--Нет домов--</option>';
        }
    }

    public function actionTest()
    {
        $model = new Test();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->files = UploadedFile::getInstances($model, 'files');
            Test::compressImg($model->files);
        }
        return $this->render('test', ['model' => $model]);

    }

    public function actionJournal()
    {
        $executor = User::getShortnameWitchoutDecodeChars(Yii::$app->user->identity->fio);
        $dataProvider = new ActiveDataProvider([
            'query' => Journal::find()
                ->select('*')
//                ->where(['like', 'EXECUTOR_MAIL', $executor])
                ->orderBy(['ID_MAIL' => SORT_DESC, 'NUM_MAIL' => SORT_DESC])
                ->limit(100),
        ]);
        return $this->render('journal', [
            'dataProvider' => $dataProvider
        ]);
    }


}
