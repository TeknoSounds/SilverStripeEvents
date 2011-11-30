<?php
// http://www.ssbits.com/tutorials/2009/create-a-front-end-theme-switcher/
class EventListing extends Page {
 
}
 
class EventListing_Controller extends Page_Controller {
	
	function Events(){
		$date = new DateTime("now");
		$date->modify('-8 hours');
		$today = $date->format('Y-m-d'); 
		return DataObject::get("Event", "Date >= '{$today}' AND Duplicate <> TRUE", "Date, Time, Name");
	}
 
	function Users(){
		return DataObject::get("User", "", "MajorRepPoints, MinorRepPoints, Name");
	}
 
}