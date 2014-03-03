<?php
/**
 * CAdvancedArBehavior class file.
 *
 * @author Herbert Maschke <thyseus@gmail.com>
 * @link http://www.yiiframework.com/
 * @version yum
 */

/* The CAdvancedArBehavior extension adds up some functionality to the default
 * possibilites of yii´s ActiveRecord implementation.
 *
 * To use this extension, just copy this file to your extensions/ directory,
 * add 'import' => 'application.extensions.CAdvancedArBehavior', [...] to your 
 * config/main.php and add this behavior to each model you would like to
 * inherit the new possibilities:
 *
 * public function behaviors(){
 *         return array( 'CAdvancedArBehavior' => array(
 *        	 'class' => 'application.extensions.CAdvancedArBehavior')); 
 *         }                                  
 *
 *
 * Automatically sync your Database Schema when setting new fields by
 * activating $syncdb
 *
 * Better support of MANY_TO_MANY relations:
 *
 * When we have defined a MANY_MANY relation in our relations() function, we
 * are now able to add up instances of the foreign Model on the fly while
 * saving our Model to the Database. Let´s assume the following Relation:
 *
 * Post has:
 *  'categories'=>array(self::MANY_MANY, 'Category',
 *                  'tbl_post_category(post_id, category_id)')
 *
 * Category has:
 * 'posts'=>array(self::MANY_MANY, 'Post',
 *                  'tbl_post_category(category_id, post_id)')
 *
 * Now we can use the attribute 'categories' of our Post model to add up new
 * rows to our MANY_MANY connection Table:
 *
 * $post = new Post();
 * $post->categories = Category::model()->findAll();
 * $post->save();
 *
 * This will save our new Post in the table Post, and in addition to this it
 * updates our N:M-Table with every Category available in the Database.
 * 
 * We can further limit the Objects given to the attribute, and can also go 
 * the other Way around:
 *
 * $category = new Category();
 * $category->posts = array(5, 6, 7, 10);
 * $caregory->save(); 
 *
 * We can pass Object instances like in the first example, or a list of
 * integers that representates the Primary key of the Foreign Table, so that
 * the Posts with the id 5, 6, 7 and 10 get´s added up to our new Category.
 *
 * 5 Queries will be performed here, one for the Category-Model and four for
 * the N:M-Table tbl_post_category. Note that this behavior could be tuned
 * further in the future, so only one query get´s executed for the MANY_MANY
 * Table.
 *
 * We can also pass a _single_ object or an single integer:
 *
 * $category = new Category();
 * $category->posts = Post::model()->findByPk(12);
 * $category->posts = 12;
 * $category->save();
 * 
 * Assign -1 to a attribute to let it be untouched by the behavior.
 */


class CAdvancedArbehavior extends CActiveRecordBehavior
{
	// if $syncdb is set, this behavior will automatically insert new added
	// database fields to the Database
	public $syncdb = false;
	public $freeze = false;

	// Trace syncing 
	public $trace = true;

	// After the save process of the model this behavior is attached to 
	// is finished, we begin saving our MANY_MANY related data 
	public function afterSave($event) 
	{
		parent::afterSave($event);
		$this->writeManyManyTables();
		return true;
	}

	protected function writeManyManyTables() 
	{
		if($this->trace)
			Yii::trace('writing MANY_MANY data for '.get_class($this->owner),
					'system.db.ar.CActiveRecord');

		foreach($this->getRelations() as $relation) 
		{
			$this->cleanRelation($relation);
			$this->writeRelation($relation);
		}
	}

	protected function getRelations()
	{
		$relations = array();

		foreach ($this->owner->relations() as $key => $relation) 
		{
			if ($relation[0] == CActiveRecord::MANY_MANY && 
					$this->owner->hasRelated($key) && 
					$this->owner->$key != -1)
			{
				$info = array();
				$info['key'] = $key;
				$info['foreignTable'] = $relation[1];

					if (preg_match('/^(.+)\((.+)\s*,\s*(.+)\)$/s', $relation[2], $pocks)) 
					{
						$info['m2mTable'] = $pocks[1];
						$info['m2mThisField'] = $pocks[2];
						$info['m2mForeignField'] = $pocks[3];
					}
					else 
					{
						$info['m2mTable'] = $relation[2];
						$info['m2mThisField'] = $this->owner->tableSchema->PrimaryKey;
						$info['m2mForeignField'] = CActiveRecord::model($relation[1])->tableSchema->primaryKey;
					}
				$relations[$key] = $info;
			}
		}
		return $relations;
	}

	/** writeRelation's job is to check if the user has given an array or an 
	 * single Object, and executes the needed query */
	protected function writeRelation($relation) 
	{
		$key = $relation['key'];

		// Only an object or primary key id is given
		if(is_object($this->owner->$key)) 		
		{
			$this->owner->$key = array($this->owner->$key);
		}

		// An array of objects is given
		foreach($this->owner->$key as $foreignobject)
		{
			if(!is_numeric($foreignobject) && is_object($foreignobject))
			{
				$foreignobject = $foreignobject->{$foreignobject->$relation['m2mForeignField']};
			}
			$this->execute($this->makeManyManyInsertCommand($relation, $foreignobject));
		}
	}

	/* before saving our relation data, we need to clean up exsting relations so
	 * they are synchronized */
	protected function cleanRelation($relation)
	{
		$this->execute($this->makeManyManyDeleteCommand($relation));	
	}

	public function execute($query) {
		Yii::app()->db->createCommand($query)->execute();
	}

	public function makeManyManyInsertCommand($relation, $value) {
		return sprintf("insert into %s (%s, %s) values ('%s', '%s')",
				$relation['m2mTable'],
				$relation['m2mThisField'],
				$relation['m2mForeignField'],
				$this->owner->{$this->owner->tableSchema->primaryKey},
				$value);
	}

	public function makeManyManyDeleteCommand($relation) {
		return sprintf("delete ignore from %s where %s = '%s'",
				$relation['m2mTable'],
				$relation['m2mThisField'],
				$this->owner->{$this->owner->tableSchema->primaryKey}
				);
	}

	public function __set($name,$value)
	{
		if($this->syncdb === true) {
			if($this->setAttribute($name,$value)===false)
			{
				if(isset($this->getMetaData()->relations[$name]))
					$this->_related[$name]=$value;
				else
				{
					if ($this->freeze===false)
					{
						$command=$this->getDbConnection()->createCommand('ALTER TABLE `'.$this->tableName().'` ADD `'.$name.'` '.self::getDbType($value).' NOT NULL');
						$command->execute();
						$this->getDbConnection()->getSchema()->refresh();
						$this->refreshMetaData();
					}
					$this->__set($name, $value);
				}
			}
			elseif ($this->freeze === false)
			{
				$cols = $this->getDbConnection()->getSchema()->getTable($this->tableName())->columns;
				if ($name != 'id' && strcasecmp($cols[$name]->dbType, self::getDbType($value)) != 0)
				{
					//prevent TEXT from being downgraded to VARCHAR
					if (!(strcasecmp($cols[$name]->dbType,'TEXT')==0 && strcasecmp(self::getDbType($value),'VARCHAR(255)')==0))
					{
						$command=$this->getDbConnection()->createCommand('ALTER TABLE  `'.$this->tableName().'` CHANGE  `'.$name.'`  `'.$name.'` '.self::getDbType($value));
						$command->execute();
						$this->getDbConnection()->getSchema()->refresh();
						$this->refreshMetaData();
						$this->setAttribute($name,$value);
					}
				}
			}
		}
	}

	/**
	 * Returns a columns datatype based on the value passed.
	 * @param mixed property value
	 */
	public static function getDbType($value)
	{
		if (is_numeric($value) && floor($value)==$value)
			return 'INT(11)';

			if (is_numeric($value))
				return 'DOUBLE';

			if (strlen($value) <= 255)
				return 'VARCHAR(255)';

			return 'TEXT';
	}

		/**
		 * Returns the static model of the specified AR class.
		 * The model returned is a static instance of the AR class.
		 * It is provided for invoking class-level methods (something similar to 
     * static class methods.)
		 *
		 * EVERY derived AR class must override this method as follows,
		 * <pre>
		 * public static function model($className=__CLASS__)
		 * {
		 *     return parent::model($className);
		 * }
		 * </pre>
		 *
		 * @param string active record class name.
		 * @return CActiveRecord active record model instance.
		 */
	public static function model($className=__CLASS__)
	{
		if(isset(self::$_models[$className]))
			return self::$_models[$className];
		else
		{
			$model=self::$_models[$className]=new $className(null);
			$model->attachbehaviors($model->behaviors());
			$model->_md=new ExtendedActiveRecordMetaData($model);
			return $model;
		}
	}

	/**
	 * @return CActiveRecordMetaData the meta for this AR class.
	 */
	public function getMetaData()
	{
		if($this->_md!==null)
			return $this->_md;
		else
			return $this->_md=self::model(get_class($this))->_md;
	}
}
