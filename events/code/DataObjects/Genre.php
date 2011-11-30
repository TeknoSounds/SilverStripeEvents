<?php
class Genre extends DataObject {
	static $db = array(
		'Name' => 'Varchar(20)',
		'Description' => 'Text'
	);
	
	static $summary_fields = array(
   		'Name'
   );
   
	static $belongs_many_many  = array(
		'Artists' => 'Artist'
   );
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		return $fields;
	}
	
	// function canCreate() {return true;} 
	// function canEdit() {return true;} 
	// function canDelete() {return true;}

}
