<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $Author
 * @property string $Content
 * @property string $Date
 * @property integer $id_Note
 *
 * The followings are the available model relations:
 * @property Notes $idNote
 */
class Comment extends CActiveRecord
{
	public $Author;
	public $Content;
	public $Date;
	public $verifyCode;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Author, Content, id_Note', 'required'),
			array('id_Note', 'numerical', 'integerOnly'=>true),
			array('Author', 'length', 'max'=>255),
			array('Date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Author, Content, Date, id_Note', 'safe', 'on'=>'search'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idNote' => array(self::BELONGS_TO, 'Notes', 'id_Note'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Author' => Yii::t('Comment', 'Author'),
			'Content' => Yii::t('Comment', 'Content'),
			'Date' => Yii::t('Comment', 'Date'),
			'id_Note' => 'Id Note',
			'verifyCode'=>Yii::t('app', 'Verification Code'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('Author',$this->Author,true);
		$criteria->compare('Content',$this->Content,true);
		$criteria->compare('Date',$this->Date,true);
		$criteria->compare('id_Note',$this->id_Note);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
