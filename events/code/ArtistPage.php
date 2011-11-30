<?php

class ArtistPage extends Page {

}

class ArtistPage_Controller extends Page_Controller {

	public function ArtistForm() {
		// print_r($record = DataObject::get_one('Artist', "`Artist`.`Name` = 'Spring Love 3'"));
		$URLParams = Director::urlParams();
		if ($URLParams['ID']){
			$formAction = new FieldSet (
				new FormAction('doSubmit', _t('Artist','Edit Artist'))
			);
		} else {
			$formAction = new FieldSet (
				new FormAction('doSubmit', _t('Artist','Create New Artist'))
			);
		}
		$form = new Form (
			$this,
			"ArtistForm",
			new FieldSet (
				$ImageLink = new TextField('ImageLink', _t('Artist.ImageLink','Image Link')),
				$NameField = new TextField('Name', _t('Artist.Name','Name')),
				$YoutubeSingle1Field = new TextField('YoutubeSingle1', _t('Artist.YoutubeSingle1','YoutubeSingle1')),
				$YoutubeSingle2Field = new TextField('YoutubeSingle2', _t('Artist.YoutubeSingle2','YoutubeSingle2')),
				$YoutubeSingle3Field = new TextField('YoutubeSingle3', _t('Artist.YoutubeSingle3','YoutubeSingle3')),
				$OfficialWebpageField = new TextField('OfficialWebpage', _t('Artist.OfficialWebpage','OfficialWebpage')),
				$SoundcloudField = new TextField('Soundcloud', _t('Artist.Soundcloud','Soundcloud')),
				$FacebookField = new TextField('Facebook', _t('Artist.Facebook','Facebook')),
				$TwitterField = new TextField('Twitter', _t('Artist.Twitter','Twitter')),
				$MyspaceField = new TextField('Myspace', _t('Artist.Myspace','Myspace')),
				$OfficialYoutubeField = new TextField('OfficialYoutube', _t('Artist.OfficialYoutube','OfficialYoutube')),
				$GenreListField = new TextField('GenreList', _t('Artist.GenreList','GenreList')),
				$IDField = new HiddenField('ID','', '')
			),
			$formAction,
			// new RequiredFields('Name','Date','Address','City')
			new RequiredFields('Name', 'Date', 'Venue')
		);
		
		// Grab previous data if editing an existing DataObject
		// URLParams can be visited at artist/edit/#
		if ($URLParams['ID']){
			$thisID = Convert::raw2sql($URLParams['ID']);
			$artist = DataObject::get_by_id('Artist', $thisID);

			$FlyerLinkField->value = $artist->ImageLink;
			$NameField->value = $artist->Name;
			$YoutubeSingle1Field->value = $artist->YoutubeSingle1;
			$YoutubeSingle2Field->value = $artist->YoutubeSingle2;
			$YoutubeSingle3Field->value = $artist->YoutubeSingle3;
			$OfficialWebpageField->value = $artist->OfficialWebpage;
			$SoundcloudField->value = $artist->Soundcloud;
			$FacebookField->value = $artist->Facebook;
			$TwitterField->value = $artist->Twitter;
			$MyspaceField->value = $artist->Myspace;
			$OfficialYoutubeField->value = $artist->OfficialYoutube;
			$GenreListField->value = $artist->GenreList;
			$IDField->value = $thisID;
		}
		return $form;
	}

	public function edit($request){
		return $this->renderWith(array('EditArtistPage', 'Page'));
	}
	
	public function show(){
		$URLParams = Director::urlParams();
		if ($URLParams['ID']){
			$thisID = Convert::raw2sql($URLParams['ID']);
			$artist = DataObject::get_by_id('Artist', $thisID);
			return $this->customise($artist)->renderWith(array('ArtistPage','Page'));
		}
	}
	
	public function repAssign($originalDO, $newDO, $field, $newValue){
		$originalArtist = $originalDO->$field;
		$newDO->$field = $newValue;
		$repPoint = ($originalArtist != $newDO->$field);
		return $repPoint;
	}
	
	public function doSubmit($data, $form) {
		if ($data['ID']){
			$thisID = Convert::raw2sql($data['ID']);
			$artist = DataObject::get_by_id('Artist', $thisID);
			$originalArtist = DataObject::get_by_id('Artist', $thisID);
			
			$theseMinorRepPoints = 0;
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'ImageLink', $data['ImageLink']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'Name', $data['Name']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'YoutubeSingle1', $data['YoutubeSingle1']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'YoutubeSingle2', $data['YoutubeSingle2']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'YoutubeSingle3', $data['YoutubeSingle3']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'OfficialWebpage', $data['OfficialWebpage']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'Soundcloud', $data['Soundcloud']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'Facebook', $data['Facebook']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'Twitter', $data['Twitter']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'Myspace', $data['Myspace']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'OfficialYoutube', $data['OfficialYoutube']);
			$theseMinorRepPoints += self::repAssign($originalArtist, $artist, 'GenreList', $data['GenreList']);
			
			// Check User
			$username = Session::get('username');
			if (DataObject::get_one('User', "`Name` = '{$username}'")){
				$artist->write();
			} else {
				// Something funny has happened or the user has logged off.
				Director::redirect(Director::baseURL());
				return;
			}
			
			$user = DataObject::get_one('User', "`Name` = '{$username}'");
			$userMajorRep = count($user->Events());
			$user->MajorRepPoints = $userMajorRep;
			if ($data['ID']){
				$user->MinorRepPoints += $theseMinorRepPoints;
				if ($theseMinorRepPoints)
					$user->History = date('H:i:s') . '-' . $artist->ID . '-' . $theseMinorRepPoints . ',' . $user->History;
				$user->write();
				Director::redirect(Director::baseURL(). $this->URLSegment . "/show/$thisID/?update=1");
			}
		}
	}
	
	public function UpdateSucccess() {
		return isset($_REQUEST['update']) && $_REQUEST['update'] == "1";
	} 
	

}
