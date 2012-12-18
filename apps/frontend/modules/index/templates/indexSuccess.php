<?php 

if ($sf_user->hasCredential('sharer')) {
	include_component('business_unit', 'reportTable');
}
