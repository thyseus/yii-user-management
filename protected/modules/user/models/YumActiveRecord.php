<?php
/**
 * Base class for all active records
 * @author tomasz.suchanek
 * @since 0.6
 * @package Yum.core
 *
 */
abstract class YumActiveRecord extends CActiveRecord {
	protected $_tableName;

	/**
	 * Adds the CAdvancedArBehavior and, if enabled, the LoggableBehavior to
	 * every YUM Active Record model
	 * @return array
	 */
	public function behaviors() {
		$behaviors = array( 'CAdvancedArBehavior' );
		if(Yum::module()->enableAuditTrail)
			$behaviors = array_merge($behaviors, array( 
						'LoggableBehavior' => 'application.modules.auditTrail.behaviors.LoggableBehavior')
					);

		return $behaviors;
	}	

	public function limit($limit = 10)
	{
		$this->getDbCriteria()->mergeWith(array(
					'limit' => $limit,
					));
		return $this;
	}

	public function order($order = 'id')
	{
		$this->getDbCriteria()->mergeWith(array(
					'order' => $order,
					));
		return $this;
	}


	/**
	 * @return CActiveRecordMetaData the meta for this AR class.
	 */	
	public function getMetaData( )
	{
		$md = parent::getMetaData( );
		if($this->getScenario()==='search')
		{
			$md->attributeDefaults  = array ();
		}

		return $md;
	}

}
?>
