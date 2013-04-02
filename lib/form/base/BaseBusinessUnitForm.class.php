<?php

/**
 * BusinessUnit form base class.
 *
 * @method BusinessUnit getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Eric Usmanov
 */
abstract class BaseBusinessUnitForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'name'  => new sfWidgetFormInputText(),
      'plan'  => new sfWidgetFormInputText(),
      'loans' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'  => new sfValidatorString(array('max_length' => 50)),
      'plan'  => new sfValidatorNumber(),
      'loans' => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('business_unit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BusinessUnit';
  }


}
