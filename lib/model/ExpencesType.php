<?php


/**
 * Skeleton subclass for representing a row from the 'expences_type' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ExpencesType extends BaseExpencesType {
	public function __toString()
	{
		return $this->getName();
	}
} // ExpencesType
