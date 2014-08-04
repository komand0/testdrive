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
			"Dear fiend",
			"Free membership",
			"asdf",
			);
		$summ=0;
		foreach ($spam as $key => $value) 
		{
			echo "deleting coments with ".$value."\n";
			$model = new Comment();
			$comments = Yii::app()->db->createCommand()
			->select('id, id_Note')
			->from($model->tableName())
			//->join('tbl_profile p', 'u.id=p.user_id')
			->where('Content LIKE :value', array(':value'=>'%'.$value.'%'))
			->queryAll();
			//var_dump($comments);
			foreach ($comments as $num => $comment) 
			{
				echo "id ".$comment['id']."\n";
				$model = Comment::model()->findByPk($comment['id']);
				if($model===null){
					throw new CHttpException(404,'The requested comment does not exist.'.$model->id);
				}
				$model->delete();
				Yii::log("Deleted comment '".$model->id."' to note ".$model->id_Note, "info", "user.command");
			}
			echo 'deleted '.count($comments)." comments\n";
			$summ+=count($comments);
		}
		echo 'Summary deleted '.$summ." comments\n";
		return 0;
	}
}
?>