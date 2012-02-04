<?php

class UserNet extends AbstractObjectModel {
	public $TABLE_NAME = "user_net";

	public $paramsList = array(
		array(
			'name'	=>	'user',
			'description'	=>	'user',
			'type'	=>	'User',
			'default'	=>	''
			),
		array(
			'name'	=>	'net',
			'description'	=>	'Social net',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'external_id',
			'description'	=>	'External ID',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'username',
			'description'	=>	'username',
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
			'name'	=>	'email',
			'description'	=>	'email',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'auth_key',
			'description'	=>	'auth_key',
			'type'	=>	'string',
			'default'	=>	''
			),
		array(
			'name'	=>	'profile',
			'description'	=>	'serialized profile',
			'type'	=>	'string',
			'default'	=>	''
			)
	);
}