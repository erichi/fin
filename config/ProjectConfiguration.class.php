<?php

require_once dirname(__FILE__).'/../../sf/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfPropelPlugin', 'sfGuardExtraPlugin', 'sfGuardPlugin');

    sfConfig::set('root_dir', dirname(__FILE__).'/../');
    sfConfig::set('upload_files_dir', dirname(__FILE__).'/../web/uploads/files');

  }
}
