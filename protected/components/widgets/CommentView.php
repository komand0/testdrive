<?php
class CommentView extends CWidget
{
	public $dataProvider;
	public $itemView;
	public $title;

	public function run()
	{
		if($this->title=='')
		{
			$this->title='Comments';
		}
		echo "<p>".$this->title."</p>\n";
		// $this->renderPartial('CommentView', 
		// 	array('dataProvider'=>$this->dataProvider,
		//	'itemView'=>$this->itemView,//'_commentItem',));

		$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$this->dataProvider,
			'itemView'=>$this->itemView,//'_commentItem',
		));
	}
}
?>