<?php

class UserAdmin extends ModelAdmin {
	
	static $url_segment = 'users';
	static $menu_title = 'Users';

	static $managed_models=array(
		'User'
	);
	
}
?>
