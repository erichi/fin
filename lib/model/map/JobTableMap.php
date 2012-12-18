<?php


/**
 * This class defines the structure of the 'job' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class JobTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.JobTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('job');
		$this->setPhpName('Job');
		$this->setClassname('Job');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('JOB_ORDER_ID', 'JobOrderId', 'INTEGER', 'job_order', 'ID', false, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 255, null);
		$this->addForeignKey('JOB_TYPE_ID', 'JobTypeId', 'INTEGER', 'job_type', 'ID', true, null, null);
		$this->addColumn('SUPPLIER', 'Supplier', 'VARCHAR', true, 100, null);
		$this->addColumn('AMOUNT', 'Amount', 'DECIMAL', true, 10, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('JobOrder', 'JobOrder', RelationMap::MANY_TO_ONE, array('job_order_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('JobType', 'JobType', RelationMap::MANY_TO_ONE, array('job_type_id' => 'id', ), null, null);
    $this->addRelation('JobPayment', 'JobPayment', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // JobTableMap
