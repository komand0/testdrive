<?php

class NoteController extends Controller
{
	public $layout='//layouts/column2';

	public function actionIndex($q=false,$auth=false)
	{		
		$criteria=new CDbCriteria;
		if($auth!==false)
		{
			$auth = urldecode($auth);
			$_auth=addCslashes($auth, '\%_"\\');
			$_auth = str_replace(array('\\\\'), array('\\\\\\\\'), $_auth);
			$criteria->condition = 'Author LIKE "'.($_auth).'"';
			//throw new CHttpException(404,'au='.$criteria->condition);
			// 	$criteria->compare('Author',$auth,false);
		}
		if($q!==false)
		{
			if($auth!==false)
				$criteria->condition .= ' AND ';
			$_q = addcslashes($q, "'\\\"%_");
			$_q = addcslashes($_q, "\\");
			//$criteria->addColumnCondition(array('Title'=>$q, 'Content'=>$q), 'OR');			
			//$criteria->addSearchCondition('Title', $q, true);
			//$criteria->addSearchCondition('Content', $q."", true, 'OR');
			//$criteria->compare('Title','"'.$q.'"',true);
			//$criteria->compare('Content','"'.$q.'"',true);
			$criteria->condition .= "(Title LIKE '%".$_q."%'";
			$criteria->condition .= " OR Content LIKE '%".$_q."%')";
			//throw new CHttpException(404,'au='.$criteria->condition);
		}
		
		$criteria->order = 'Date DESC';

		$dataProvider = new CActiveDataProvider('Note', array(
			'criteria'=>$criteria,
			'countCriteria'=>array(
				'condition'=>$criteria->condition,
			),
			'pagination'=>array(
				'pageSize'=>8,
			),
		));
		//*/
		
		/*
		if(0){
			$model=new Note('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['q']))
			{
				$model->attributes['Title']=$_GET['q'];
				$model->attributes['Content']=$_GET['q'];
			}
			if(isset($_GET['auth']))
			{
				$model->setAttributes(array("Author"=>$_GET['auth']));//attributes["Author"]=$_GET['auth'];
			}
			$dataProvider = $model->search();
		}//*/

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'q'=>$q,
			'auth'=>$auth,
		));
	}

	public function actionView($id)
	{
		$model=$this->loadModel($id);
		
		$dataProvider=new CActiveDataProvider('Comment', array(
			'criteria'=>array(
				'condition'=>'id_Note='.$model->id_Note,
				'order'=>'Date DESC',
			),
			'countCriteria'=>array(
				'condition'=>'id_Note='.$model->id_Note,
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		$CModel=new Comment;
		if(isset($_POST['Comment']))
		{
			$CModel=$this->actionAddComment($model->id_Note);			
		}

		$this->render('view',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'CModel'=>$CModel,
		));

		// $this->widget(
		// 		'booster.widgets.TbSelect2', array(
		// 	'asDropDownList' => false,
		// 	'name' => 'clevertech',
		// 	'options' => array(
		// 		'tags' => array('clever', 'is', 'better', 'clevertech'),
		// 		'placeholder' => 'type clever, or is, or just type!',
		// 		'width' => '40%',
		// 		'tokenSeparators' => array(',', ' ')
		// 	)
		// 		)
		// );
		// // Set up several flashes
		// // (this should be done somewhere in controller, of course).
		// $user = Yii::app()->getComponent('user');
		// $user->setFlash(
		// 	'success',
		// 	"<strong>Well done!</strong> You're successful in reading this."
		// );
		// $user->setFlash(
		// 	'info',
		// 	"<strong>Heads up!</strong> I'm a valuable information!."
		// );
		// $user->setFlash(
		// 	'warning',
		// 	"<strong>Warning!</strong> Check yourself, you're not looking too good."
		// );
		// $user->setFlash(
		// 	'error',
		// 	'<strong>Oh snap!</strong> Change something and try submitting again.'
		// );
		 
		// // Render them all with single `TbAlert`		
		// $this->widget('yiibooster.widgets.TbAlert', array(
		// 	'fade' => true,
		// 	'closeText' => '&times;', // false equals no close link
		// 	'events' => array(),
		// 	'htmlOptions' => array(),
		// 	'userComponentId' => 'user',
		// 	'alerts' => array( // configurations per alert type
		// 		// success, info, warning, error or danger
		// 		'success' => array('closeText' => '&times;'),
		// 		'info', // you don't need to specify full config
		// 		'warning' => array('closeText' => false),
		// 		'error' => array('closeText' => 'AAARGHH!!')
		// 	),
		// ));
	}

	public function actionAddComment($id_Note)
	{
		$CModel=new Comment;
		$_POST['Comment']["Date"] = date("Y-m-d H:i:s");
		$_POST['Comment']["id_Note"] = $id_Note;
		$CModel->attributes=$_POST['Comment'];
		if($CModel->validate())
		{
			if($CModel->save())
			{
				Yii::log("Created comment", "info", "user");
				//$this->redirect(array('view','id'=>$model->id_Note));
				Yii::app()->user->setFlash('comment','Thank you for your comment.');
				$this->refresh();
			}
		}
		return $CModel;
	}

	public function actionDelComment($id,$id_Note)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested comment does not exist.'.$model->id);
		}
		$model->delete();

		Yii::log("Deleted comment", "info", "user");
		//if(!isset($_GET['ajax']))
			//$this->refresh();
		$this->redirect(array('view','id'=>$model->id_Note));
	}

	public function loadModel($id)
	{
		$model=Note::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionCreate()
	{
		$model=new Note;
		if(isset($_POST['Note']))
		{
			$_POST['Note']["Date"]= date("Y-m-d H:i:s");
			$model->attributes=$_POST['Note'];
			if($model->save())
			{
				Yii::log("Created note", "info", "user");
				$this->redirect(array('view','id'=>$model->id_Note));
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Note']))
		{
			$_POST['Note']["Date"]=date("Y-m-d H:i:s");
			$model->attributes=$_POST['Note'];
			if($model->save()){
				Yii::log("Updated note", "info", "user");
				$this->redirect(array('view','id'=>$model->id_Note));
			}
		}
		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		Yii::log("Deleted note", "info", "user");
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
			//array('booster.filters.BootstrapFilter - delete')
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','captcha','page','login','logout','error'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','delcomment'),
				'users'=>array('@'),
			),
			// array('allow', // allow admin user to perform 'admin' and 'delete' actions
			// 	'actions'=>array('admin','delete'),
			// 	'users'=>array('admin'),
			// ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				Yii::log("User ".Yii::app()->user->name." login", "info", "user");
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
?>