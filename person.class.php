<?php
/**
 * The Person class - set the properties that you want to display in the vCard
 * 
 * @package
 * @author Gareth Poole
 * @copyright Gareth Poole 2010
 * @version 0.2
 */
class Person {

	private $_display_name;
	private $_first_name;
	private $_surname;
	private $_additional_name;
	private $_name_prefix;
	private $_name_suffix;
	private $_nickname;
	private $_title;
	private $_role;
	private $_department;
	private $_company;
	private $_work_po_box;
	private $_work_extended_address;
	private $_work_address;
	private $_work_city;
	private $_work_state;
	private $_work_postal_code;
	private $_work_country;
	private $_home_po_box;
	private $_home_extended_address;
	private $_home_address;
	private $_home_city;
	private $_home_state;
	private $_home_postal_code;
	private $_home_country;
	private $_office_tel;
	private $_home_tel;
	private $_cell_tel;
	private $_fax_tel;
	private $_pager_tel;
	private $_email1;
	private $_email2;
	private $_url;
	private $_photo;
	private $_birthday;
	private $_timezone;
	private $_sort_string;
	private $_note;
	
	public function __set($var, $val){
		if(property_exists('Person', $var)){
			$this->$var = $val;
		}
		else{
			throw new Exception('Property "' . $var . '" not supported.');
		}
	}
	
	public function __get($val){
		if($this->$val)
			return $this->$val;
	}
	
}