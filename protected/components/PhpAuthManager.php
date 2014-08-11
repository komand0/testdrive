<?php
class PhpAuthManager extends CPhpAuthManager{
	public function init(){

		parent::init();

		// Для гостей у нас и так роль по умолчанию guest.
		if(!Yii::app()->user->isGuest){
			$this->assign(Yii::app()->user->role, Yii::app()->user->id);
		}
	}
}
?>