<?php


/**
 * This class defines the structure of the 'job_order' table.
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
class JobOrderTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.JobOrderTableMap';

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
		$this->setName('job_order');
		$this->setPhpName('JobOrder');
		$this->setClassname('JobOrder');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('BUSINESS_UNIT_ID', 'BusinessUnitId', 'INTEGER', 'business_unit', 'ID', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 50, null);
		$this->addForeignKey('CLIENT_ID', 'ClientId', 'INTEGER', 'client', 'ID', false, null, null);
		$this->addColumn('INDULGENCE', 'Indulgence', 'VARCHAR', false, 10, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('BusinessUnit', 'BusinessUnit', RelationMap::MANY_TO_ONE, array('business_unit_id' => 'id', ), null, null);
    $this->addRelation('Client', 'Client', RelationMap::MANY_TO_ONE, array('client_id' => 'id', ), null, null);
    $this->addRelation('JobOrderManager', 'JobOrderManager', RelationMap::ONE_TO_MANY, array('id' => 'job_order_id', ), 'CASCADE', null);
    $this->addRelation('IncomePayment', 'IncomePayment', RelationMap::ONE_TO_MANY, array('id' => 'job_order_id', ), 'CASCADE', null);
    $this->addRelation('Job', 'Job', RelationMap::ONE_TO_MANY, array('id' => 'job_order_id', ), 'CASCADE', null);
    $this->addRelation('Tender', 'Tender', RelationMap::ONE_TO_MANY, array('id' => 'job_order_id', ), null, null);
    $this->addRelation('Plan', 'Plan', RelationMap::ONE_TO_MANY, array('id' => 'job_order_id', ), 'SET NULL', null);
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

} // JobOrderTableMap
