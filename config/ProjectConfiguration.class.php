<?php

require_once '/Applications/MAMP/htdocs/sf/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelPlugin', 'sfGuardExtraPlugin', 'sfGuardPlugin');
  }
}
