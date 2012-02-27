<?php
class Event extends DataObject {
    static $db = array(
        'FlyerLink' => 'Text',
        'Duplicate' => 'Boolean',
        'Name' => 'Varchar(50)',
        'Date' => 'Date',
        'Time' => 'Time',
        'EndDate' => 'Date',
        'EndTime' => 'Time',
        'Venue' => 'Varchar(50)',
        'Address' => 'Varchar(50)',
        'City' => "Enum('Austin, Dallas, Houston, San Antonio, Other, TBA', 'TBA')",
        'OtherCity' => 'Varchar(20)',
        'State' => "Enum('TX, Other', 'TX')",
        'OtherState' => 'Varchar(20)',
        'HeadlinerList' => 'Text',
        'TicketLink' => 'Text',
        'LastKnownPrice' => 'Int',
        'DoorPrice' => 'Int',
        'RSPVLink' => 'Text',
        'FacebookEID' => 'Varchar(20)',
        'Description' => 'Text',
        'Talkback' => 'Text',
        'EventGallery' => 'Text',
    );

    static $summary_fields = array(
        'Name',
        'Date',
        'Venue',
        'City',
        'FacebookEID',
   );

    static $has_one  = array(
        'ProductionCompany' => 'ProductionCompany',
        'User' => 'User',
        'FlyerImage' => 'OriginalImage'
   );

    static $many_many = array(
        'Headliners' => 'Artist',
        'LocalSupport' => 'Artist'
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

        // DOWNLOAD AND LINK FLYER IMAGES
        // Create a Unix friendly filename
        $filename = preg_replace("/[^A-Za-z0-9-_\.]*/", "", $this->Name);

        // Verify that what is being downloaded is a picture
        $ext = strtolower(end(explode('.', $this->FlyerLink)));
        $acceptedExts = array("jpg", "jpeg", "png", "gif", "bmp", "tiff");
        if (in_array($ext, $acceptedExts)) {
            // Download the file to assets/Flyers as EventName.ext
            $flyerFolder = "../assets/Flyers";
            $fullfilename = $filename . '.' . $ext;

            // Create the folder and download and write the file
            if (!file_exists($flyerFolder))
                mkdir($flyerFolder, 0755);
            $flyerBytes = self::downloadFile($this->FlyerLink);
            $file = fopen("$flyerFolder/$fullfilename", 'w');
            fwrite($file, $flyerBytes);
            fclose($file);

            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            // REMOVE shell_exec's
            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

            // Calculates and adds a tailing md5-hash
            $md5hash = md5_file("../assets/Flyers/$fullfilename");
            rename("../assets/Flyers/$fullfilename", "../assets/Flyers/" . $this->ID . "-$md5hash.$ext");
            $fullfilename = $this->ID . "-$md5hash.$ext";

            // Find Folder ID
            $folderToSave = 'assets/Flyers/';
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

                    $this->FlyerImageID = DataObject::get_one('OriginalImage', "`Name` = '{$fullfilename}'")->ID;
               } else {
                    $this->FlyerImageID = DataObject::get_one('OriginalImage', "`Name` = '{$fullfilename}'")->ID;
                }
            }
        }
        parent::onBeforeWrite();
    }

    public function OrderedHeadliners(){
        $orderedList = array();
        $hlList = explode(';', trim(trim($this->HeadlinerList), ';'));
        foreach ($hlList as $hl) {
            $hl = trim($hl);
            if ($hl){
                $hlEscaped = Convert::raw2sql($hl);
                array_push($orderedList, DataObject::get_one('Artist', "`Name` = '{$hlEscaped}'"));
            }
        }
        return new DataObjectSet($orderedList);
    }

    public function OrderedLocalSupport(){
        $localsupport = $this->LocalSupport();
        return $localsupport;
    }
}
