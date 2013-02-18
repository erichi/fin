<?php

/**
 * JobOrderManager filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseJobOrderManagerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('job_order_manager_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'JobOrderManager';
  }

  public function getFields()
  {
    return array(
      'job_order_id' => 'ForeignKey',
      'user_id'      => 'ForeignKey',
    );
  }
}
