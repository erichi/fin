<?php

/**
 * UserBusinessUnit form base class.
 *
 * @method UserBusinessUnit getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Eric Usmanov
 */
abstract class BaseUserBusinessUnitForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'          => new sfWidgetFormInputHidden(),
      'business_unit_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'user_id'          => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id', 'required' => false)),
      'business_unit_id' => new sfValidatorPropelChoice(array('model' => 'BusinessUnit', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_business_unit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserBusinessUnit';
  }


}
