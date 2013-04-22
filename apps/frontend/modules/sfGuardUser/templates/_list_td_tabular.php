<td class="sf_admin_text sf_admin_list_td_username">
  <?php echo link_to($sf_guard_user->getUsername(), 'sf_guard_user_edit', $sf_guard_user) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_email">
  <?php echo $sf_guard_user->getEmail() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_first_name">
  <?php echo $sf_guard_user->getFirstName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_last_name">
  <?php echo $sf_guard_user->getLastName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_phone">
  <?php echo $sf_guard_user->getPhone() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_business_unit">
    <?php if($sf_guard_user->getProfile()->getBusinessUnitId() != null) echo $sf_guard_user->getProfile()->getBusinessUnit()->getName(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_permissions">
    <?php
        $perms = $sf_guard_user->getPermissions();
        foreach($perms as $permission){
            echo $permission->getDescription();
        }
    ?>
</td>
<td class="sf_admin_boolean sf_admin_list_td_is_active">
  <?php echo get_partial('sfGuardUser/list_field_boolean', array('value' => $sf_guard_user->getIsActive())) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($sf_guard_user->getCreatedAt()) ? format_date($sf_guard_user->getCreatedAt(), "f") : '&nbsp;' ?>
</td>
