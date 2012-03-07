<?php
// http://www.ssbits.com/tutorials/2009/create-a-front-end-theme-switcher/
class EventListing extends Page {

}

class EventListing_Controller extends Page_Controller {

    function Events(){
        // Return all events that happened at least 8 hours ago
        $date = new DateTime("now");
        $date->modify('-8 hours');
        $today = $date->format('Y-m-d');
        return DataObject::get("Event", "Date >= '{$today}' AND Duplicate <> TRUE", "Date, Time, Name, City, OtherCity");
    }

    function Users(){
        return DataObject::get("User", "", "MajorRepPoints, MinorRepPoints, Name");
    }

    function Cities(){
        // Get all events on this page
        $events = self::Events();

        $result = array();
        foreach ($events as $event) {
            // Read the city of each event
            $city = ($event->OtherCity) ? ($event->OtherCity) : ($event->City);
            $fullCity = $city;
            $city = explode(' ', $city);
            $city = $city[0];
            $cityObject = array('ShortCity' => $city, 'FullCity' => $fullCity);

            // If the city is not in result object,
            if (!in_array($cityObject, $result)){
                // add city
                array_push($result, $cityObject);
            }
        }

        return new DataObjectSet($result);
    }

}
