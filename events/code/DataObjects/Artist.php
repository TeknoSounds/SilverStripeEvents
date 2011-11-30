<?php
class Artist extends DataObject {
	static $db = array(
		'ImageLink' => 'Text',
		'Name' => 'Varchar(50)',
		'YoutubeSingle1' => 'Text',
		'YoutubeSingle2' => 'Text',
		'YoutubeSingle3' => 'Text',
		'OfficialWebpage' => 'Text',
		'Soundcloud' => 'Varchar(50)',
		'Facebook' => 'Varchar(50)',
		'Twitter' => 'Varchar(50)',
		'Myspace' => 'Varchar(50)',
		'OfficialYoutube' => 'Varchar(50)',
		'GenreList' => 'Text'
	);
	
	static $summary_fields = array(
   		'Name',
   		'OfficialWebpage'
   );
   
	static $has_one  = array(
		'ArtistImage' => 'OriginalImage'
   );
   
	static $has_many_many  = array(
		'Genres' => 'Genre'
   );
   
	static $belongs_many_many  = array(
   		'Events' => 'Event'
   );
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		return $fields;
	}
	
	// function canCreate() {return true;} 
	// function canEdit() {return true;} 
	// function canDelete() {return true;}
	
	function downloadFile($url){
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function onBeforeWrite() {
		
		// DOWNLOAD AND LINK Artist IMAGES
		// Create a Unix friendly filename
		$filename = preg_replace("/[^A-Za-z0-9-_\.]*/", "", $this->Name);
		
		// Verify that what is being downloaded is a picture
		$ext = strtolower(end(explode('.', $this->ArtistImage)));
		$acceptedExts = array("jpg", "jpeg", "png", "gif", "bmp", "tiff");
		if (in_array($ext, $acceptedExts)) {
			// Download the file to assets/Artists as EventName.ext
			$artistImageFolder = "../assets/Artists";
			$fullfilename = $filename . '.' . $ext;
			
			// Create the folder and download and write the file
			if (!file_exists($artistImageFolder))
				mkdir($artistImageFolder, 0755);
			$artistImageBytes = self::downloadFile($this->ArtistImage);
			$file = fopen("$artistImageFolder/$fullfilename", 'w');
			fwrite($file, $artistImageBytes);
			fclose($file);
			
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			// REMOVE shell_exec's
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			
			// Calculates and adds a tailing md5-hash
			$md5hash = md5_file("../assets/Artists/$fullfilename");
			rename("../assets/Artists/$fullfilename", "../assets/Artists/" . $this->ID . "-$md5hash.$ext");
			$fullfilename = $this->ID . "-$md5hash.$ext";
			
			// Find Folder ID
			$folderToSave = 'assets/Artists/';
			$folderObject = DataObject::get_one("Folder", "`Filename` = '{$folderToSave}'");
			if($folderObject){
				// Create OriginalImage
				if(!DataObject::get_one('OriginalImage', "`Name` = '{$fullfilename}'")){
					$imageObject = Object::create('OriginalImage');
					$imageObject->ParentID = $folderObject->ID;
					$imageObject->Name = $fullfilename;
					$imageObject->write();
					
					// TODO
					// Remove old flyer, if it exists.
					
					$this->ArtistImageID = DataObject::get_one('OriginalImage', "`Name` = '{$fullfilename}'")->ID;
			   } else {
					$this->ArtistImageID = DataObject::get_one('OriginalImage', "`Name` = '{$fullfilename}'")->ID;
				}
			}
		}
		parent::onBeforeWrite();
	}

}
