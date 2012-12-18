<?php

require_once '/usr/home/ftpaccess/crm.buzzaar.ru/symfony/symfony-1.4.16/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelPlugin', 'sfGuardExtraPlugin', 'sfGuardPlugin');
  }
}
