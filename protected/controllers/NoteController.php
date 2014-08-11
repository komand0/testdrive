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
			$criteria->condition = "author LIKE '".($_auth)."'";
			//throw new CHttpException(404,'au='.$criteria->condition);
			// 	$criteria->compare('author',$auth,false);
		}
		if($q!==false)
		{
			if($auth!==false)
				$criteria->condition .= ' AND ';
			$_q = addcslashes($q, "'\\\"%_");
			$_q = addcslashes($_q, "\\");
			//$criteria->addColumnCondition(array('title'=>$q, 'content'=>$q), 'OR');			
			//$criteria->addSearchCondition('title', $q, true);
			//$criteria->addSearchCondition('content', $q."", true, 'OR');
			//$criteria->compare('title','"'.$q.'"',true);
			//$criteria->compare('content','"'.$q.'"',true);
			$criteria->condition .= "(title LIKE '%".$_q."%'";
			$criteria->condition .= " OR content LIKE '%".$_q."%')";
			//throw new CHttpException(404,'au='.$criteria->condition);
		}

		$criteria->order = 'date DESC';

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
				$model->attributes['title']=$_GET['q'];
				$model->attributes['content']=$_GET['q'];
			}
			if(isset($_GET['auth']))
			{
				$model->setAttributes(array("author"=>$_GET['auth']));//attributes["author"]=$_GET['auth'];
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
				'condition'=>'id_note='.$model->id_note,
				'order'=>'date DESC',
			),
			'countCriteria'=>array(
				'condition'=>'id_note='.$model->id_note,
			),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		$CModel=new Comment;
		if(isset($_POST['Comment']))
		{
			$CModel=$this->actionAddComment($model->id_note);			
		}

		$this->render('view',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'CModel'=>$CModel,
		));
	}

	public function actionAddComment($id_note)
	{
		$CModel=new Comment;
		$_POST['Comment']["date"] = date("Y-m-d H:i:s");
		$_POST['Comment']["id_note"] = $id_note;
		$CModel->attributes=$_POST['Comment'];
		if($CModel->validate())
		{
			if($CModel->save())
			{
				Yii::log("Created comment", "info", "user");
				//$this->redirect(array('view','id'=>$model->id_note));
				Yii::app()->user->setFlash('comment','Thank you for your comment.');
				$this->refresh();
			}
		}
		return $CModel;
	}

	public function actionDelComment($id,$id_note)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null){
			throw new CHttpException(404,'The requested comment does not exist.'.$model->id);
		}
		if(Yii::app()->user->checkAccess('editNote',array('author'=>$model->author)))
		{
			$model->delete();

			Yii::log("Deleted comment", "info", "user");
			$this->redirect(array('view','id'=>$model->id_note));
		}
		else
			throw new CHttpException(403,'Forbidden.');
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
			$_POST['Note']["date"]= date("Y-m-d H:i:s");
			$model->attributes=$_POST['Note'];
			if($model->save())
			{
				Yii::log("Created note", "info", "user");
				$this->redirect(array('view','id'=>$model->id_note));
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('updateNote',array('author'=>$model->author)))
		{
		    if(isset($_POST['Note']))
			{
				$_POST['Note']["date"]=date("Y-m-d H:i:s");
				$model->attributes=$_POST['Note'];
				if($model->save()){
					Yii::log("Updated note", "info", "user");
					$this->redirect(array('view','id'=>$model->id_note));
				}
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}
		else
			throw new CHttpException(403,'Forbidden.');
	}

	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('deleteNote',array('author'=>$model->author)))
		{
			$model->delete();
			Yii::log("Deleted note", "info", "user");
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(403,'Forbidden.');
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
			array('application.extensions.yiibooster.filters.BoosterFilter - delete'),
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