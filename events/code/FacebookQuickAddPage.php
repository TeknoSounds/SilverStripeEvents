<?php

class FacebookQuickAddPage extends Page {

}

class FacebookQuickAddPage_Controller extends Page_Controller {

    public function NewEventForm() {
        $form = new Form (
            $this,
            "NewEventForm",
            new FieldSet (
                new TextField('FacebookEvent', 'Facebook Event (Full Link)')
            ),
            new FieldSet (
                new FormAction('doCreate', _t('Event','Create New Event'))
            ),
            // new RequiredFields('Name','Date','Address','City')
            new RequiredFields('FacebookEvent')
        );
        return $form;
    }

    public function proper($str){
        return ucwords(strtolower($str));
    }

    public function create_new_vb_thread($date, $name, $venue, $city, $state, $description) {
        include('../events/secure/def.inc');
        //set POST variables
        $url = 'http://teknosounds.com/messageboard/create_thread.php';
        $fields = array(
                    'date'=>urlencode($date),
                    'name'=>urlencode($name),
                    'venue'=>urlencode($venue),
                    'city'=>urlencode($city),
                    'state'=>urlencode($state),
                    'description'=>urlencode($description),
                    'secret_key'=>urlencode($vb_secret_key)
                );

        //url-ify the data for the POST
        $fields_string = '';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string,'&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        $threadID = $result;

        //close connection
        curl_close($ch);

        return $threadID;
    }

    public function doCreate($data, $form) {
        include('../events/secure/def.inc');

        // Find facebook eid
        if ($data){
            // Executes during first pass
            $facebookURL = $data['FacebookEvent'];
            // Strip EID from Address
            eregi('facebook.com/events/(.*)/', $facebookURL, $facebookEID);
            // Set the EID accordingly, -1 if we didn't get one out
            if (count($facebookEID) > 0){
                $facebookEID = $facebookEID[1];
            } else {
                $facebookEID = '-1';
            }
            Session::set('facebookEID', $facebookEID);
        }

        // Session variable used due to manipulation during Silverstripe's second function run.
        $facebookEID = Session::get('facebookEID');

        if(!DataObject::get_one('Event', "FacebookEID = '$facebookEID' ")) {
            // Facebook Pull
            $graphUrl = 'https://graph.facebook.com/' . $facebookEID . '&accessToken=' . $FBappID;
            $response = @file_get_contents($graphUrl);
            // If not a valid URL exit function
            if (!$response){
                Director::redirect(Director::baseURL(). $this->URLSegment . "/?failure=2");
                return;
            }

            $results = json_decode($response, true);
            // If valid events page...
            if (!isset($results['error']) && isset($results['location'])){

                // Event.*
                $form->saveInto($event = new Event());
                $event->Name = self::proper($results['name']);
                $event->Venue = self::proper($results['location']);
                if (isset($results['venue']) && isset($results['venue']['street']))
                    $event->Address = self::proper($results['venue']['street']);
                $event->FacebookEID = $facebookEID;
                if (isset($results['description'])) {
                    $event->Description = $results['description'];
                }
                else {
                    $event->Description = "";
                }

                $graphUrl = 'https://graph.facebook.com/' . $facebookEID . '&fields=picture&type=large&accessToken=' . $FBappID;
                $response = @file_get_contents($graphUrl);
                $pictureResponse = json_decode($response, true);
                $event->FlyerLink = $pictureResponse['picture'];

                // Event.Date&Time
                $dateAndTime = $results['start_time'];
                $event->Date = substr($dateAndTime, 0, strrpos($dateAndTime, 'T'));
                $event->Time = substr($dateAndTime, strrpos($dateAndTime, 'T') + 1);

                // Event.EndDate&Time
                $dateAndTime = $results['end_time'];
                $event->EndDate = substr($dateAndTime, 0, strrpos($dateAndTime, 'T'));
                $event->EndTime = substr($dateAndTime, strrpos($dateAndTime, 'T') + 1);

                // Event.City
                $city = '';
                if (isset($results['venue']) && isset($results['venue']['city'])){
                    if (in_array(self::proper($results['venue']['city']), singleton('Event')->dbObject('City')->enumValues())){
                        $event->City = self::proper($results['venue']['city']);
                    } else {
                        $event->OtherCity = self::proper($results['venue']['city']);
                    }
                    $city = self::proper($results['venue']['city']);
                }

                // Event.State
                if (isset($results['venue']) && isset($results['venue']['state'])){
                    $tempState = '';
                    if (array_search(self::proper($results['venue']['state']), $abbr_to_state_list)) {
                        // The full state name is provided
                        $tempState = array_search($results['venue']['state'], $abbr_to_state_list);
                    } elseif (array_search(strtoupper($results['venue']['state']), $state_to_abbr_list)) {
                        // The abbreviation is provided
                        $tempState = strtoupper($results['venue']['state']);
                    }
                    if (strlen($tempState) && in_array($tempState, singleton('Event')->dbObject('State')->enumValues())){
                        // $tempState is not empty and $tempState is in Event.State Enum
                        $event->State = $tempState;
                    } else {
                        $event->OtherState = $tempState;
                    }
                    $state = $tempState;
                }   else {
                    $state = "TX";
                }

                // Check User
                $username = Session::get('username');
                if (DataObject::get_one('User', "`Name` = '{$username}'")){
                    $user = DataObject::get_one('User', "`Name` = '{$username}'");
                    $event->UserID = $user->ID;

                    //Info gathered for VB Thread, create
                    $event->Talkback = self::create_new_vb_thread($event->Date, $event->Name, $event->Venue, $city, $state, $event->Description);

                    $event->write();
                    $userMajorRep = count($user->Events());
                    $user->MajorRepPoints = $userMajorRep;
                    $user->write();
                    $currentdir = getcwd();

                    //Change back working directories
                    chdir($currentdir);

                    Director::redirect(Director::baseURL(). $this->URLSegment . "/?success=1");
                } else {
                    // Something funny has happened or the user has logged off.
                    Director::redirect(Director::baseURL() . "/login");
                    return;
                }
            } else {
                Director::redirect(Director::baseURL(). $this->URLSegment . "/?failure=2");
            }
        } else {
            Director::redirect(Director::baseURL(). $this->URLSegment . "/?failure=1");
        }
        return;
    }

    public function Success() {
        return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
    }

    public function Duplicate() {
        return isset($_REQUEST['failure']) && $_REQUEST['failure'] == "1";
    }

    public function NonFBEvent() {
        return isset($_REQUEST['failure']) && $_REQUEST['failure'] == "2";
    }

}
