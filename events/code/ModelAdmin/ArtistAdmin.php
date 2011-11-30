<?php

class ArtistAdmin extends ModelAdmin {
	
	static $url_segment = 'artists';
	static $menu_title = 'Artists';

	static $managed_models=array(
		'Artist'
	);
	
}
?>
