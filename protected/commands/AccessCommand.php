<?php
class AccessCommand extends CConsoleCommand
{
	public function actionAddRules() 
	{
		$auth=Yii::app()->authManager;
		Yii::import('application.models.User');
		$auth->createOperation('createNote','create a note');
		$auth->createOperation('readNote','read a note');
		$auth->createOperation('updateNote','update a note');
		$auth->createOperation('deleteNote','delete a note');

		$bizRule='return Yii::app()->user->name==$params["author"];';
		$task=$auth->createTask('updateOwnNote','update a note by author himself',$bizRule);
		$task->addChild('updateNote');

		$task=$auth->createTask('deleteOwnNote','delete a note by author himself',$bizRule);
		$task->addChild('deleteNote');

		$role=$auth->createRole('guest');
		$role->addChild('readNote');

		$role=$auth->createRole('author');
		$role->addChild('quest');
		$role->addChild('createNote');
		$role->addChild('updateOwnNote');	
		$role->addChild('deleteOwnNote');

		$role=$auth->createRole('admin');
		$role->addChild('quest');
		$role->addChild('author');
		$role->addChild('deleteNote');
		$role->addChild('updateNote');
		$auth->save();
	}

	public function actionAddAdminUser() {
		Yii::import('application.models.User');		
		$user = new User();
		$user->username = 'admin';
		$user->password = 'admin';
		$user->email = 'admin@site.com';
		$user->role = 'admin';
		$user->save();
		echo "done\n";
	}
}
?>