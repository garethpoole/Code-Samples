<?php 
error_reporting(E_ALL);

require('person.class.php');
require('vcard.class.php');

$person = new Person;

$person->_display_name = "Ricky Gervais";
$person->_first_name = "Ricky";
$person->_surname = "Gervais";
$person->_email1 = "ricky.gervais@xfm.com";
$person->_office_tel = '075555555';

//var_dump($person);die();

$vcard = new Vcard($person);

//$vcard->build();

$vcard->setFilename("test");
/*
die();

$vc = new Vcard;
$vc->filename = $obj->friendlyURL . '.vcf';
$vc->data['display_name'] = $obj->title;
$vc->data['first_name'] = $nameparts[0];
$vc->data['last_name'] = $nameparts[1];

$vc->data['company'] = "Davis Blank Furniss";
$vc->data['title'] = $obj->position;
$vc->data['office_tel'] = $obj->telephone;
$vc->data['fax_tel'] = $obj->fax;
$vc->data['email1'] = $obj->email;
$vc->data['department'] = $obj->office;
$vc->data['url'] = "http://www.dbf-law.co.uk";
$vc->class = "PRIVATE";
*/
$vcard->download();