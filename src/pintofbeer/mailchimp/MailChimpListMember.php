<?php

namespace pintofbeer\mailchimp;

class MailChimpListMember extends MailChimpDataItem{
	
	public function getId(){ return $this->getProperty("id"); }
	public function getEmailAddress(){ return $this->getProperty("email_address"); }
	public function getUniqueEmailId(){ return $this->getProperty("unique_email_id"); }
	public function getEmailType(){ return $this->getProperty("email_type"); }
	public function getStatus(){ return $this->getProperty("status"); }
	public function getMergeField($field){
		$merge = $this->getProperty("merge_fields");
		if(is_object($merge) && isset($merge->{$field})) return $merge->{$field};
		return false;
	}
	public function getFirstName(){ return $this->getMergeField("FNAME"); }
	public function getLastName(){ return $this->getMergeField("LNAME"); }
	public function getStats(){ return $this->getProperty("stats"); }
	public function getLocation(){ return $this->getProperty("location"); }
	
}