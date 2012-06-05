<?php if(Yum::module('profile')->enableProfileComments 
		&& $model->allow_comments) { ?>
	<h2> <?php echo Yum::t('Profile Comments'); ?> </h2>

<?php 
$dataProvider = new CActiveDataProvider('YumProfileComment', array(
			'criteria'=>array(
				'condition'=>'profile_id = :profile_id',
				'params' => array(':profile_id' => $model->id),
				'order'=>'createtime DESC')
			)
		);

$this->renderPartial(Yum::module('profile')->profileCommentCreateView, array(
			'comment' => new YumProfileComment,
			'profile' => $model));

$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>Yum::module('profile')->profileCommentView,
			));  

}
?>
