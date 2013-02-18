<?php
class UserAdminForm extends sfGuardUserAdminForm
{
	 public function configure()
	{
		parent::configure();
		
		$this->widgetSchema['sf_guard_user_permission_list']->setOption('add_empty', true);
		$this->widgetSchema['sf_guard_user_permission_list']->setOption('multiple', false);
		
		$this->validatorSchema['sf_guard_user_permission_list']->setOption('required', true);
		$this->validatorSchema['address']->setOption('required', false);
		$this->validatorSchema['email'] = new sfValidatorEmail();
		
		if ($this->isNew())	{
			$this->validatorSchema['password']->setOption('required', true);
			$this->validatorSchema['password_again']->setOption('required', true);
		}
	}

}