<?php
class CheckCommentsCommand extends CConsoleCommand
{
	public function run($args) 
	{ 
		echo "Start\n";
		Yii::import('application.models.Comment');
		$spam = array(
			"100% satisfied",
			"Buy direct",
			"Click to remove",
			"Dear friend",
			"Free membership",
			"asdf",
			);
		$summ=0;
		foreach ($spam as $key => $value) 
		{
			echo "deleting coments with ".$value."\n";
			$model = new Comment();
			$comments = Yii::app()->db->createCommand()
			->select('id, id_note')
			->from($model->tableName())
			->where('LOWER(content) LIKE :value', array(':value'=>'%'.strtolower($value).'%'))
			->queryAll();
			foreach ($comments as $num => $comment) 
			{
				echo "id ".$comment['id']."\n";
				$model = Comment::model()->findByPk($comment['id']);
				if($model===null){
					echo 'The requested comment does not exist.';
					return 1;
				}
				$model->delete();
				Yii::log("Deleted comment '".$model->id."' to note ".$model->id_note, "info", "user.command");
			}
			echo 'deleted '.count($comments)." comments\n";
			$summ+=count($comments);
		}
		echo 'Summary deleted '.$summ." comments\n";
		return 0;
	}
}
?>