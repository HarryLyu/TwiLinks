<?php

class User extends AbstractObjectModel {

	public $TABLE_NAME = "user";

	public $paramsList = array(
			array(
				'name'	=>	'email',
				'description'	=>	'Email',
				'type'	=>	'string',
				'default'	=>	''
				),
			array(
				'name'	=>	'name',
				'description'	=>	'Name',
				'type'	=>	'string',
				'default'	=>	''
				),
			array(
				'name'	=>	'gender',
				'description'	=>	'gender',
				'type'	=>	'string',
				'default'	=>	''
				),
			array(
				'name'	=>	'register_date',
				'description'	=>	'register_date',
				'type'	=>	'int',
				'default'	=>	''
				),
			array(
				'name'	=>	'default_net',
				'description'	=>	'Default social net',
				'type'	=>	'UserNet',
				'default'	=>	0
				)
		);
	
	public function findByExternalId($external_id,$net){
		$userNet = new UserNet();
		$userNets = $userNet->selectAll("WHERE external_id = $external_id and net = '$net'");
		if (count($userNets))
			return $userNets[0]->user;
		else
			return null;
	}
	
	public function getNet($net = 'twitter'){
		$userNet = new UserNet();
		
		$userNets = $userNet->selectAll("WHERE user = '".$this->getId()."' and net = '".$net."'");
		
		if (count($userNets))
			return $userNets[0];
		else
			return null;
	}
	
	public function __toString(){
		return $this->paramValues['name'].' ['.$this->paramValues['email'].']';
	}
}