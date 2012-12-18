<?php

/**
 * Job form base class.
 *
 * @method Job getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseJobForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'job_order_id' => new sfWidgetFormPropelChoice(array('model' => 'JobOrder', 'add_empty' => true)),
      'name'         => new sfWidgetFormInputText(),
      'job_type_id'  => new sfWidgetFormPropelChoice(array('model' => 'JobType', 'add_empty' => false)),
      'supplier'     => new sfWidgetFormInputText(),
      'amount'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'job_order_id' => new sfValidatorPropelChoice(array('model' => 'JobOrder', 'column' => 'id', 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'job_type_id'  => new sfValidatorPropelChoice(array('model' => 'JobType', 'column' => 'id')),
      'supplier'     => new sfValidatorString(array('max_length' => 100)),
      'amount'       => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('job[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Job';
  }


}
