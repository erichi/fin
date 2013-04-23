<?php

class myUser extends sfGuardSecurityUser
{
    public function hasBusinessUnit($id)
    {
        return $this->getGuardUser()->hasBusinessUnit($id);
    }
}
