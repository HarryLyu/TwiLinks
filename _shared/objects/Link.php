<?php

class Link extends AbstractObjectModel {

	public $TABLE_NAME = "links";

	public $paramsList = array(
		array(
			'name'	=>	'user',
			'description'	=>	'user',
			'type'	=>	'User',
			'default'	=>	''
			),
		array(
			'name'	=>	'link',
			'description'	=>	'href',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'description',
			'description'	=>	'description',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'domain',
			'description'	=>	'domain for stat',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'add_date',
			'description'	=>	'add link date',
			'type'	=>	'int',
			'default'	=>	''
			)
	);
	
	public function __toString(){
		return $this->paramValues['link'];
	}
}