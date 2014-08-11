<?php

class m140804_084110_create_notes extends CDbMigration
{
	public function up()//works with mysql
	{
		if(Yii::app()->db->getDriverName()=="mysql")
		{
			if (Yii::app()->db->schema->getTable('notes',true)===null) {
				$this->createTable('notes', array(
					'id_note' => 'pk',
					'author' => 'CHAR(255) NOT NULL',
					'title' => 'CHAR(255) NOT NULL',
					'content' => 'TEXT NOT NULL',
					'date' => 'DATETIME',
				),'ENGINE InnoDB  CHARACTER SET=UTF8');
			} else {
				echo "table notes already exist\n";
			}

			if (Yii::app()->db->schema->getTable('comments',true)===null) {
				$this->createTable('comments', array(
					'id' => 'pk',
					'author' => 'CHAR(255) NOT NULL',
					'content' => 'TEXT NOT NULL',
					'date' => 'DATETIME',
					'id_note' => 'INT',
				),'ENGINE InnoDB  CHARACTER SET=UTF8');
				$this->addForeignKey('FK_comment_note', 'comments', 'id_note', 
					'notes', 'id_note', 'CASCADE', 'CASCADE');
			} else {
				echo "table comments already exist\n";
			}
		}
		elseif(Yii::app()->db->getDriverName()=="pgsql")
		{
			if (Yii::app()->db->schema->getTable('notes',true)===null) {
				$this->createTable('notes', array(
					'id_note' => 'pk',
					'author' => 'varchar(255) NOT NULL',
					'title' => 'varchar(255) NOT NULL',
					'content' => 'text NOT NULL',
					'date' => 'timestamp without time zone',
				));
			} else {
				echo "table notes already exist\n";
			}

			if (Yii::app()->db->schema->getTable('comments',true)===null) {
				$this->createTable('comments', array(
					'id' => 'pk',
					'author' => 'varchar(255) NOT NULL',
					'content' => 'text NOT NULL',
					'date' => 'timestamp without time zone',
					'id_note' => 'integer',
				),'ENGINE InnoDB  CHARACTER SET=UTF8');
				$this->addForeignKey('FK_comment_note', 'comments', 'id_note', 
					'notes', 'id_note', 'CASCADE', 'CASCADE');
			} else {
				echo "table comments already exist\n";
			}		
		}
	}

	public function down()
	{
		echo "m140804_084110_create_notes does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
