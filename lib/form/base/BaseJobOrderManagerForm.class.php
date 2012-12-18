<?php

/**
 * JobOrderManager form base class.
 *
 * @method JobOrderManager getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseJobOrderManagerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'job_order_id' => new sfWidgetFormInputHidden(),
      'user_id'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'job_order_id' => new sfValidatorPropelChoice(array('model' => 'JobOrder', 'column' => 'id', 'required' => false)),
      'user_id'      => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('job_order_manager[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'JobOrderManager';
  }


}
