<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BasesfGuardUserProfileForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'user_id'          => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'email'            => new sfWidgetFormInputText(),
      'first_name'       => new sfWidgetFormInputText(),
      'last_name'        => new sfWidgetFormInputText(),
      'address'          => new sfWidgetFormInputText(),
      'phone'            => new sfWidgetFormInputText(),
      'bio'              => new sfWidgetFormTextarea(),
      'business_unit_id' => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'          => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'email'            => new sfValidatorString(array('max_length' => 255)),
      'first_name'       => new sfValidatorString(array('max_length' => 50)),
      'last_name'        => new sfValidatorString(array('max_length' => 50)),
      'address'          => new sfValidatorString(array('max_length' => 255)),
      'phone'            => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'bio'              => new sfValidatorString(array('required' => false)),
      'business_unit_id' => new sfValidatorPropelChoice(array('model' => 'BusinessUnit', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }


}
