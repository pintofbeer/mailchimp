<?php

namespace pintofbeer\mailchimp;

class MailChimpDataItem extends MailChimpBase{
	
	protected $_data;
	
	public function __construct($json){
		if(!is_object($json)){
			$this->_data = json_decode($json);
		}else{
			$this->_data = $json;
		}
	}
	
	protected function getProperty($key){
		if(isset($this->_data->{$key})) return $this->_data->{$key};
		return null;
	}	
}