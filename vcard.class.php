<?php
/*
* Filename.......: class_vcard.php
* Author.........: Troy Wolf [troy@troywolf.com]
* Last Modified..: 2005/07/14 13:30:00
* Description....: A class to generate vCards for contact data.
*/
date_default_timezone_set('Europe/London');

class Vcard extends Person
{
	private $details;
	private $filename 	= 'vcard.vcf'; //filename for download file naming
	private $class 		= 'PUBLIC'; //PUBLIC, PRIVATE, CONFIDENTIAL
	private $revision_date;
	private $card;

	/*
  		The class constructor. You can set some defaults here if desired.
  	*/
	public function __construct($person_obj = null){
		$this->details = $person_obj;
		return true;
	}
	
	
	public function setFilename($filename = 'vcard.vcf'){	
		$this->filename = str_replace(" ", "_", $filename);
	}
	

	public function build()
	{
		$this->details->_display_name 	= $this->displayName();
		$this->details->_sort_string 	= $this->sortString(); 
		$this->details->_timezone 		= $this->timezone();
		$this->revision_date 			= $this->revision();

		$this->card = "BEGIN:VCARD\r\n";
		$this->card .= "VERSION:3.0\r\n";
		$this->card .= "CLASS:".$this->class."\r\n";
		$this->card .= "PRODID:-//class_vcard//NONSGML Version 1//EN\r\n";
		$this->card .= "REV:".$this->revision_date."\r\n";
		$this->card .= "FN:".$this->details->_display_name."\r\n";
		$this->card .= "N:"
			.$this->details->_surname.";"
			.$this->details->_first_name.";"
			.$this->details->_additional_name.";"
			.$this->details->_name_prefix.";"
			.$this->details->_name_suffix."\r\n";
		if ($this->details->_nickname) { $this->card .= "NICKNAME:".$this->details->_nickname."\r\n"; }
		if ($this->details->_title) { $this->card .= "TITLE:".$this->details->_title."\r\n"; }
		if ($this->details->_company) { $this->card .= "ORG:".$this->details->_company; }
		if ($this->details->_department) { $this->card .= ";".$this->details->_department; }
		$this->card .= "\r\n";

		if ($this->details->_work_po_box
			|| $this->details->_work_extended_address
			|| $this->details->_work_address
			|| $this->details->_work_city
			|| $this->details->_work_state
			|| $this->details->_work_postal_code
			|| $this->details->_work_country) {
			$this->card .= "ADR;TYPE=work:"
				.$this->details->_work_po_box.";"
				.$this->details->_work_extended_address.";"
				.$this->details->_work_address.";"
				.$this->details->_work_city.";"
				.$this->details->_work_state.";"
				.$this->details->_work_postal_code.";"
				.$this->details->_work_country."\r\n";
		}
		if ($this->details->_home_po_box
			|| $this->details->_home_extended_address
			|| $this->details->_home_address
			|| $this->details->_home_city
			|| $this->details->_home_state
			|| $this->details->_home_postal_code
			|| $this->details->_home_country) {
			$this->card .= "ADR;TYPE=home:"
				.$this->details->_home_po_box.";"
				.$this->details->_home_extended_address.";"
				.$this->details->_home_address.";"
				.$this->details->_home_city.";"
				.$this->details->_home_state.";"
				.$this->details->_home_postal_code.";"
				.$this->details->_home_country."\r\n";
		}
		if ($this->details->_email1) { $this->card .= "EMAIL;TYPE=internet,pref:".$this->details->_email1."\r\n"; }
		if ($this->details->_email2) { $this->card .= "EMAIL;TYPE=internet:".$this->details->_email2."\r\n"; }
		if ($this->details->_office_tel) { $this->card .= "TEL;TYPE=work,voice:".$this->details->_office_tel."\r\n"; }
		if ($this->details->_home_tel) { $this->card .= "TEL;TYPE=home,voice:".$this->details->_home_tel."\r\n"; }
		if ($this->details->_cell_tel) { $this->card .= "TEL;TYPE=cell,voice:".$this->details->_cell_tel."\r\n"; }
		if ($this->details->_fax_tel) { $this->card .= "TEL;TYPE=work,fax:".$this->details->_fax_tel."\r\n"; }
		if ($this->details->_pager_tel) { $this->card .= "TEL;TYPE=work,pager:".$this->details->_pager_tel."\r\n"; }
		if ($this->details->_url) { $this->card .= "URL;TYPE=work:".$this->details->_url."\r\n"; }
		if ($this->details->_birthday) { $this->card .= "BDAY:".$this->details->_birthday."\r\n"; }
		if ($this->details->_role) { $this->card .= "ROLE:".$this->details->_role."\r\n"; }
		if ($this->details->_note) { $this->card .= "NOTE:".$this->details->_note."\r\n"; }
		$this->card .= "TZ:".$this->details->_timezone."\r\n";
		$this->card .= "END:VCARD\r\n";
	}

	
	public function download()
	{
		if(!$this->card)
			$this->build();
			
		if(!$this->filename){
			$this->setFilename($this->details->_display_name);
		}
				
		header("Content-type: text/directory");
		header("Content-Disposition: attachment; filename=".$this->filename);
		header("Pragma: public");
		echo $this->card;
		return true;
	}
	
	
	
	private function displayName(){
		if(!$this->details->_display_name)
			return trim($this->details->_first_name . " " . $this->details->_surname);
		else
			return $this->details->_display_name;
	}
	
	
	// needs testing
	private function sortString(){
		if(!$this->details->_sort_string)
			return $this->details->_surname;
		
		if(!$this->details->_sort_string){
			return $this->details->_company;
		}
	}
	
	
	private function timezone(){
		if(!$this->details->_timezone)
			return date("O");
	}
	
	
	private function revision(){
		if(!$this->revision_date)
			return date('Y-m-d H:i:s');
	}
	
	
}