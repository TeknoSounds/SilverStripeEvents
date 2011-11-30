<?php

class ProductionCompanyAdmin extends ModelAdmin {
	
	static $url_segment = 'productioncompanies';
	static $menu_title = 'Production Companies';

	static $managed_models=array(
		'ProductionCompany'
	);
	
}
?>
