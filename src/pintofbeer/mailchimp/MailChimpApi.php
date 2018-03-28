<?php

namespace pintofbeer\mailchimp;

class MailChimpApi extends MailChimpBase{
	private $_lists;
	private $_read_all_lists = false;
	
	public function __construct($api_key){
		MailChimpBase::setApiKey($api_key);
	}
	
	public function getLists(){
		if(!empty($this->_lists) && $this->_read_all_lists) return $this->_lists;
		$count = 10; // how many to fetch per API call
		$page = 0;
		$lists = false;
		$this->_lists = [];
		do{
			$lists = $this->call("lists", ["count" => $count, "offset" => $page * $count]);
			if(isset($lists->lists)){
				foreach($lists->lists as $list){
					if(!isset($this->_lists[$list->id])){
						$this->_lists[$list->id] = new MailChimpList($list);
					}
				}
			}
			$page++;
		}while(isset($lists->total_items) && $page * $count < $lists->total_items);
		$this->_read_all_lists = true;
		return $this->_lists;
	}
	
	public function getListByName($name){
		$lists = $this->getLists();
		foreach($lists as $list){
			if($list->getName() == $name) return $list;
		}
		return false;
	}
	
	public function getListById($id){
		if(!is_array($this->_lists) || !isset($this->_lists[$id])){
			if(!is_array($this->_lists)) $this->_lists = [];
			$list = $this->call("lists/$id");
			if(isset($list->id)){
				$list_o = new MailChimpList($list);
				$this->_lists[] = $list_o;
				return $list_o;
			}
		}elseif(isset($this->_lists[$id])){
			return $this->_lists[$id];
		}
		return false;
	}
}