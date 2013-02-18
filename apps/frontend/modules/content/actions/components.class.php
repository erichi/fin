<?php

class contentComponents extends sfComponents
{
	public function executeMenu()
	{
		$this->bus = BusinessUnitPeer::doSelect(new Criteria());
	}
	
}