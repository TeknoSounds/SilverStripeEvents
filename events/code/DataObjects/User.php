<?php
class User extends DataObject {
    static $db = array(
        'Name' => 'Varchar(20)',
        'Password' => 'Text',
        'MajorRepPoints' => 'Int',
        'MinorRepPoints' => 'Int',
        'History' => 'Varchar(2048)',
        'Email' => 'Varchar(50)',
        'CanFBPost' => 'Boolean',
        'CanEditPost' => 'Boolean',
        'FirstName' => 'Varchar(20)',
        'LastName' => 'Varchar(20)',
        'Birthday' => 'Date',
        'City' => "Enum('Austin, Dallas, Houston, San Antonio, Other', 'Austin')",
        'OtherCity' => 'Varchar(20)',
        'State' => "Enum('TX, Other', 'TX')",
        'OtherState' => 'Varchar(20)',
        'Facebook' => 'Varchar(50)',
        'Twitter' => 'Varchar(50)',
        'Myspace' => 'Varchar(50)',
        'Soundcloud' => 'Varchar(50)',
        'Youtube' => 'Varchar(50)',
        'Picture' => 'Text'
    );

    static $summary_fields = array(
        'Name',
        'City',
   );

    static $has_one  = array(
        'UserImage' => 'OriginalImage'
   );

    static $has_many  = array(
        'Events' => 'Event'
   );

    function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }

    // function canCreate() {return true;}
    // function canEdit() {return true;}
    // function canDelete() {return true;}

}
