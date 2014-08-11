<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $role
 */
class User extends CActiveRecord
{
	public function tableName()
	{
		return 'users';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password', 'required'),
			array('username, email, password', 'length', 'max'=>255),
			array('role', 'length', 'max'=>6),
			array('id, username, email, password, role', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'role' => 'Role',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave()
	{
		$salt = md5(uniqid('hedgehog', true));
		$salt = substr(strtr(base64_encode($salt), '+', '.'), 0, 22);
		$this->password = crypt($this->password, '$2a$08$' . $salt);
		return parent::beforeSave();
	}
}
