<?php


/**
 * This class defines the structure of the 'business_unit' table.
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
class BusinessUnitTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.BusinessUnitTableMap';

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
		$this->setName('business_unit');
		$this->setPhpName('BusinessUnit');
		$this->setClassname('BusinessUnit');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', true, 50, null);
		$this->addColumn('PLAN', 'Plan', 'DECIMAL', true, 10, null);
		$this->addColumn('LOANS', 'Loans', 'DECIMAL', true, 10, 0);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('UserBusinessUnit', 'UserBusinessUnit', RelationMap::ONE_TO_MANY, array('id' => 'business_unit_id', ), 'CASCADE', null);
    $this->addRelation('JobOrder', 'JobOrder', RelationMap::ONE_TO_MANY, array('id' => 'business_unit_id', ), null, null);
    $this->addRelation('Tender', 'Tender', RelationMap::ONE_TO_MANY, array('id' => 'business_unit_id', ), 'SET NULL', null);
    $this->addRelation('Plan', 'Plan', RelationMap::ONE_TO_MANY, array('id' => 'business_unit_id', ), 'SET NULL', null);
    $this->addRelation('CurrentExpenses', 'CurrentExpenses', RelationMap::ONE_TO_MANY, array('id' => 'business_unit_id', ), 'CASCADE', null);
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

} // BusinessUnitTableMap
