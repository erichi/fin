<?php

class FakeModel
{
	protected $factories = array();

	public function __call($method, $args)
	{
		if (isset($this->$method) && is_callable($method)) {
			$closure = $this->$method;
			call_user_func_array($closure, $args);
		} else {
			$verb = substr($method, 0, 3); // get | set
			$factory = strtolower(substr($method, 3)); // factory name
			if ('get' == $verb) {
				if(isset($args[0])){
					$factory .= $args[0];
				}
				return isset($this->factories[$factory]) ? $this->factories[$factory] : NULL ;
			} else
				if ('set' == $verb && isset($args[0])) {
					if(isset($args[1])){
						$factory .= $args[0];
						$args = array($args[1]);
					}
					$this->factories[$factory] = $args[0];
				}
		}
	}
}