<?php
class ProductionCompany extends DataObject {
    static $db = array(
        'Name' => 'Varchar(20)',
        'Username' => 'Varchar(20)',
        'Password' => 'Text',
        'PrimaryPromoter' => 'Varchar(50)',
        'PrimaryPromoterEmail' => 'Varchar(50)',
        'PrimaryPressContact' => 'Varchar(50)',
        'PrimaryPressEmail' => 'Varchar(50)',
        'Facebook' => 'Varchar(50)',
        'Twitter' => 'Varchar(50)',
        'Myspace' => 'Varchar(50)',
        'Soundcloud' => 'Varchar(50)',
        'Youtube' => 'Varchar(50)'
    );

    static $summary_fields = array(
        'Name',
        'PrimaryPromoter'
   );

    static $has_one  = array(
        'PromoImage' => 'OriginalImage'
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
