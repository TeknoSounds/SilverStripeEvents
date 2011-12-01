<?php

class EditEventPage extends Page {

}

class EditEventPage_Controller extends Page_Controller {

	public function EventForm() {
		// print_r($record = DataObject::get_one('Event', "`Event`.`Name` = 'Spring Love 3'"));
		$URLParams = Director::urlParams();
		if ($URLParams['ID']){
			$formAction = new FieldSet (
				new FormAction('doSubmit', _t('Event','Edit Event'))
			);
		} else {
			$formAction = new FieldSet (
				new FormAction('doSubmit', _t('Event','Create New Event'))
			);
		}
		$form = new Form (
			$this,
			"EventForm",
			new FieldSet (
				$FlyerLinkField = new TextField('FlyerLink', _t('Event.FlyerLink','Flyer Link')),
				$NameField = new TextField('Name', _t('Event.Name','Name')),
				$dateField = new DateField('Date', _t('Event.Date','Date')),
				$timeField = new TimeField('Time', _t('Event.Time','Time')),
				$endDateField = new DateField('EndDate', _t('Event.EndDate','EndDate')),
				$endTimeField = new TimeField('EndTime', _t('Event.EndTime','EndTime')),
				$VenueField = new TextField('Venue', _t('Event.Venue','Venue')),
				$AddressField = new TextField('Address', _t('Event.Address','Address')),
				$CityField = new DropdownField('City', _t('Event.City','City'), singleton('Event')->dbObject('City')->enumValues()),
				$OtherCityField = new TextField('OtherCity', _t('Event.OtherCity','Other City')),
				$StateField = new DropdownField('State', _t('Event.State','State'), singleton('Event')->dbObject('State')->enumValues()),
				$OtherStateField = new TextField('OtherState', _t('Event.OtherState','Other State')),
				new LabelField('ArtistTopSeparator', ''),
				$HeadlinerListField = new TextField('HeadlinerList', _t('HeadlinerList','Headliner List')),
				$LocalSupportListField = new TextField('LocalSupportList', _t('LocalSupportList','Local List')),
				new LabelField('ArtistDetail', 'Please separate every artist with a \';\'.'),
				new LabelField('ArtistBottomSeparator', ''),
				$TicketLinkField = new TextField('TicketLink', _t('Event.TicketLink','Ticket Link')),
				$RSPVLinkField = new TextField('RSPVLink', _t('Event.RSPVLink','RSPV Link')),
				$LastKnownPriceField = new TextField('LastKnownPrice', _t('Event.LastKnownPrice','Last Known Price')),
				$DoorPriceField = new TextField('DoorPrice', _t('Event.DoorPrice','Door Price')),
				new LabelField('PriceDetail', 'A price of -1 signifies a free event.'),
				new LabelField('PriceBottomSeparator', ''),
				$DescriptionField = new TextareaField('Description', _t('Event.Description','Description')),
				$FacebookEventField = new TextField('FacebookEvent', 'Facebook Event'),
				$FacebookPullField = new CheckboxField ('FacebookPull', 'Pull FB Data', true),
				$TalkbackField = new TextField('Talkback', _t('Event.Talkback','Talkback')),
				$EventGalleryField = new TextField('EventGallery', _t('Event.EventGallery','Event Gallery')),
				$IDField = new HiddenField('ID','', '')
			),
			$formAction,
			// new RequiredFields('Name','Date','Address','City')
			new RequiredFields('Name', 'Date', 'Venue')
		);
		
		$dateField->setConfig('showcalendar', true);
		$dateField->setConfig('dateformat', 'mm/dd/YYYY'); 
		
		$timeField->setConfig('timeformat', 'h:m a');
		$timeField->setConfig('use_strtotime', true);
		$timeField->setConfig('showdropdown',true); 
		
		$endDateField->setConfig('showcalendar', true);
		$endDateField->setConfig('dateformat', 'mm/dd/YYYY'); 
		
		$endTimeField->setConfig('timeformat', 'h:m a');
		$endTimeField->setConfig('use_strtotime', true);
		$endTimeField->setConfig('showdropdown',true); 
		
		// Grab previous data if editing an existing DataObject
		// URLParams can be visited at event/edit/#
		if ($URLParams['ID']){
			$thisID = Convert::raw2sql($URLParams['ID']);
			$event = DataObject::get_by_id('Event', $thisID);

			$FlyerLinkField->value = $event->FlyerLink;
			$NameField->value = $event->Name;
			$dateField->value =  date('m/d/Y', strtotime($event->Date));
			$timeField->value = $event->Time;
			$endDateField->value = date('m/d/Y', strtotime($event->EndDate));
			$endTimeField->value = $event->EndTime;
			$VenueField->value = $event->Venue;
			$AddressField->value = $event->Address;
			$CityField->value = $event->City;
			$OtherCityField->value = $event->OtherCity;
			$StateField->value = $event->State;
			$OtherStateField->value = $event->OtherState;
			$HeadlinerListField->value = $event->HeadlinerList;
				
			$eventLocalSupport = $event->OrderedLocalSupport();
			foreach ($eventLocalSupport as $ls)
				$LocalSupportListField->value .= $ls->Name . ';';
				
			$TicketLinkField->value = $event->TicketLink;
			$RSPVLinkField->value = $event->RSPVLink;
			$LastKnownPriceField->value = $event->LastKnownPrice;
			$DoorPriceField->value = $event->DoorPrice;
			if ($event->FacebookEID)
				$FacebookEventField->value = 'http://www.facebook.com/events/' . $event->FacebookEID;
			$DescriptionField->value = $event->Description;
			$TalkbackField->value = $event->Talkback;
			$EventGalleryField->value = $event->EventGallery;
			$IDField->value = $thisID;
		}
		
		if (true){
				$form->fields->removeByName('Talkback');
				$form->fields->removeByName('EventGallery');
		}
		return $form;
	}
	
	public function edit($request){
		return $this->renderWith(array('EditEventPage', 'Page'));
	}
	
	public function show(){
		$URLParams = Director::urlParams();
		if ($URLParams['ID']){
			$thisID = Convert::raw2sql($URLParams['ID']);
			$event = DataObject::get_by_id('Event', $thisID);
			return $this->customise($event)->renderWith(array('EventPage','Page'));
		}
	}

	public function proper($str){
		return ucwords(strtolower($str));
	}
	
	public function repAssign($originalDO, $newDO, $field, $newValue){
		$originalEvent = $originalDO->$field;
		$newDO->$field = $newValue;
		$repPoint = ($originalEvent != $newDO->$field);
		return $repPoint;
	}
	
	public function doSubmit($data, $form) {
		include('../mysite/secure/def.inc');
		
		// Facebook Parse
		$facebookURL = $data['FacebookEvent'];
		eregi('facebook.com/events/(.*)/', $facebookURL, $facebookEID);
		// Set the EID accordingly, -1 if we didn't get one out
		if (count($facebookEID) > 0){
			$facebookEID = $facebookEID[1];
		} else {
			$facebookEID = '-1';
		}
		
		$eventName = Convert::raw2sql($data['Name']);
		$facebookEID = Convert::raw2sql($facebookEID);
		$existsByName = DataObject::get_one('Event', "`Name` = '{$eventName}'");
		$existsByFB = DataObject::get_one('Event', "`FacebookEID` = '{$facebookEID}'") && strlen($facebookEID) > 0;
		
		// If this event does not exist neither by the same name nor the same FB event
		// or we are editing an exisiting page, we will continue processing...
		
		// else we exit with a failure
		if(!($existsByName || $existsByFB) || $data['ID']) {
			// Event.*
			if ($data['ID']){
				$thisID = Convert::raw2sql($data['ID']);
				$event = DataObject::get_by_id('Event', $thisID);
				$originalEvent = DataObject::get_by_id('Event', $thisID);
				$theseMinorRepPoints = 0;
				
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'FlyerLink', $data['FlyerLink']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'Name', $data['Name']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'Date', date('Y-m-d', strtotime($data['Date'])));
				if ($data['Time'])
					$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'Time', date('H:i:s', strtotime($data['Time'])));
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'EndDate', date('Y-m-d', strtotime($data['EndDate'])));
				if ($data['EndTime'])
					$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'EndTime', date('H:i:s', strtotime($data['EndTime'])));
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'Venue', $data['Venue']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'Address', $data['Address']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'City', $data['City']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'OtherCity', $data['OtherCity']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'State', $data['State']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'OtherState', $data['OtherState']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'HeadlinerList', $data['HeadlinerList']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'LocalSupportList', $data['LocalSupportList']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'TicketLink', $data['TicketLink']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'RSPVLink', $data['RSPVLink']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'LastKnownPrice', $data['LastKnownPrice']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'DoorPrice', $data['DoorPrice']);
				$theseMinorRepPoints += self::repAssign($originalEvent, $event, 'Description', $data['Description']);
				
				// $event->Talkback = $data['Talkback'];
				if (isset($data['EventGallery']))
					$event->EventGallery = $data['EventGallery'];
			} else {
				$form->saveInto($event = new Event());
				$event->Date = date('Y-m-d', strtotime($data['Date']));
				if ($data['Time'])
					$event->Time = date('H:i:s', strtotime($data['Time']));
				$event->EndDate = date('Y-m-d', strtotime($data['EndDate']));
				if ($data['EndTime'])
					$event->EndTime = date('H:i:s', strtotime($data['EndTime']));

				// Only do this later, not now since we need to pull the information!
				// $event->Talkback = FacebookQuickAddPage::create_new_vb_thread($date, $name, $venue, $city, $state, $description);
			}
			
			// Event.City
			$event->OtherCity = self::proper($event->OtherCity);
			
			// Event.State
			if ($event->State == 'Other'){
				$tempState = '';
				if (array_search(self::proper($event->OtherState), $abbr_to_state_list)) {
					// The full state name is provided
					$tempState = array_search($event->OtherState, $abbr_to_state_list);
				} elseif (array_search(strtoupper($event->OtherState), $state_to_abbr_list)) {
					// The abbreviation is provided
					$tempState = strtoupper($event->OtherState);
				}
				$event->OtherState = $tempState;
			}
			
			// Facebook Pull
			$graphUrl = 'https://graph.facebook.com/' . $facebookEID . '&accessToken=' . $FBappID;
			$response = @file_get_contents($graphUrl);
			// If valid URL...
			if ($response && isset($data['FacebookPull'])){
				$results = json_decode($response, true);
				// If valid events page...
				if (!isset($results['error']) && isset($results['location'])){	
					// Facebook Save
					$event->FacebookEID = $facebookEID;
					
					$event->Description = $results['description'];
					
					// Add facebook address if one does not exist
					if (isset($results['venue']) && isset($results['venue']['street']) && strlen($event->Address))
						$event->Address = self::proper($results['venue']['street']);
						
					// Add facebook flyer if one does not exist
					if (strlen($event->FlyerLink) == 0){
						$pictureGraphUrl = 'https://graph.facebook.com/' . $facebookEID . '&fields=picture&type=large&accessToken=' . $FBappID;
						$pictureResponse = @file_get_contents($graphUrl);
						$pictureResults = json_decode($response, true);
						$event->FlyerLink = $pictureResults['picture'];
					}
					
					// Overwrite Date and Time with Facebook Date and Time
					$dateAndTime = $results['start_time'];
					$event->Date = substr($dateAndTime, 0, strrpos($dateAndTime, 'T'));
					$event->Time = substr($dateAndTime, strrpos($dateAndTime, 'T') + 1);
					
					// Overwrite Date and Time with Facebook Date and Time
					$dateAndTime = $results['end_time'];
					$event->EndDate = substr($dateAndTime, 0, strrpos($dateAndTime, 'T'));
					$event->EndTime = substr($dateAndTime, strrpos($dateAndTime, 'T') + 1);
				}
			}
			
			// Credit user and write to DB
			$username = Session::get('username');
			if (DataObject::get_one('User', "`Name` = '{$username}'")){
				if (!$event->UserID)
					$event->UserID = DataObject::get_one('User', "`Name` = '{$username}'")->ID;
				$event->write();
			} else {
				// Something funny has happened or the user has logged off.
				Director::redirect(Director::baseURL());
				return;
			}
			
			// Create Headliner list
			$hlList = explode(';', trim(trim($data['HeadlinerList']), ';'));
			$eventName = Convert::raw2sql($event->Name);
			$eventHeadliners = DataObject::get_one('Event', "`Name` = '{$eventName}'")->Headliners();
			$eventHeadliners->removeAll();
			if (!isset($theseMinorRepPoints))
				$theseMinorRepPoints = 0;
			foreach ($hlList as $hl) {
				$hl = trim($hl);
				if ($hl){
					$hlEscaped = Convert::raw2sql($hl);
					if (!DataObject::get_one('Artist', "`Name` = '{$hlEscaped}'")){
						$artist = new Artist();
						$artist->Name = $hl;
						$artist->write();
					}
					if (!isset($originalEvent) || strpos($originalEvent->HeadlinerList, $hl) === false)
						++$theseMinorRepPoints;
					$eventHeadliners->add(DataObject::get_one('Artist', "`Name` = '{$hlEscaped}'")->ID);
				}
			}
			
			// Create Local Support list
			$lsList = explode(';', trim(trim($data['LocalSupportList']), ';'));
			$eventName = Convert::raw2sql($event->Name);
			$eventLocalSupport = DataObject::get_one('Event', "`Name` = '{$eventName}'")->LocalSupport();
			foreach ($lsList as $ls) {
				$ls = trim($ls);
				if ($ls){
					$lsEscaped = Convert::raw2sql($ls);
					if (!DataObject::get_one('Artist', "`Name` = '{$lsEscaped}'")){
						$artist = new Artist();
						$artist->Name = $ls;
						$artist->write();
					}
					if (!isset($originalEvent) || strpos($originalEvent->LocalSupportList, $ls) === false)
						++$theseMinorRepPoints;
					$eventLocalSupport->add(DataObject::get_one('Artist', "`Name` = '{$lsEscaped}'")->ID);
				}
			}
			
			$user = DataObject::get_one('User', "`Name` = '{$username}'");
			$userMajorRep = count($user->Events());
			$user->MajorRepPoints = $userMajorRep;
			if ($data['ID']){
				$user->MinorRepPoints += $theseMinorRepPoints;
				// if ($user->MinorRepPoints >= 10){
					// $user->MajorRepPoints += $user->MinorRepPoints/10;
					// $user->MinorRepPoints %= 10;
				// }
				if ($theseMinorRepPoints)
					$user->History = date('H:i:s') . '-' . $event->ID . '-' . $theseMinorRepPoints . ',' . $user->History;
				$user->write();
				Director::redirect(Director::baseURL(). $this->URLSegment . "/show/$thisID/?update=1");
			} else {
				$user->MajorRepPoints += 1;
				$user->write();
				Director::redirect(Director::baseURL(). $this->URLSegment . "/?success=1");
			}
		} else {
			Director::redirect(Director::baseURL(). $this->URLSegment . "/?failure=1"); 
		} 
		return;
	}
	
	public function UpdateSucccess() {
		return isset($_REQUEST['update']) && $_REQUEST['update'] == "1";
	} 
	
	public function Success() {
		return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
	} 
	
	public function Duplicate() {
		return isset($_REQUEST['failure']) && $_REQUEST['failure'] == "1";
	} 
}
