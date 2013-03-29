<?php

class contentComponents extends sfComponents
{
	public function executeMenu()
	{
		$this->bus = BusinessUnitPeer::getBusByUser($this->getUser());
	}
	
}