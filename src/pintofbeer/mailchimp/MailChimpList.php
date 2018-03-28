<?php

namespace pintofbeer\mailchimp;

class MailChimpList extends MailChimpDataItem{
	
	public function getName(){ return $this->getProperty("name"); }
	public function getId(){ return $this->getProperty("id"); }
	public function getWebId(){ return $this->getProperty("web_id"); }
	public function getData(){ return $this->_data; }
	
	public function getMember($email){
		$data = $this->call("lists/".$this->getId()."/members/".md5($email));
		if(isset($data->status) && $data->status == 404) return false;
		return new MailChimpListMember($data);
	}
	
}