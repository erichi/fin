<?php

class business_unitComponents extends sfComponents
{
	public function executeReportTable()
	{
		$this->bu = BusinessUnitPeer::retrieveByPk($this->bu_id);
	}
	
}