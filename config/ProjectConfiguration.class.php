<?php

require_once '/home/h46720/data/www/monoklon.ru/lib/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelPlugin', 'sfGuardExtraPlugin', 'sfGuardPlugin');
  }
}
