<?php

class EventAdmin extends ModelAdmin {

	static $url_segment = 'events';
	static $menu_title = 'Events';

	static $managed_models=array(
		'Event'
	);

}
?>
