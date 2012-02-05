<?php

$GBL_CONFIG = array (
	'dirs'	=> array(
				'shared'	=>	'./_shared',
				'site'		=>	'./_site',
				'ext'		=>	'./external',
	),
    'db'    =>  array(
                'server'    =>  'localhost',
                'username'  =>  'root',
                'password'  =>  '',
                'database'  =>  'linker',
                'connectQueries' => array(
                        "SET NAMES utf-8",
                        "set character_set_client='utf8'",
                        "set character_set_results='utf8'",
                        "set collation_connection='utf8_general_ci'"
                )
    ),
    'site'  =>  array(
                'charset'   =>  'utf-8',
                'timezone'	=>	'Asia/Novosibirsk'
    ),
    'twitter'=>array(
		'key'		=> 'FbjV9Hh3c1MQKZl8jHVOqQ',
		'secret'	=> 'saS5b9GX2SXYEoeYEQrHClb4dH5gUgTzf3nCK8p99E',
		'url'		=>	array(
			'request'	=>	'https://api.twitter.com/oauth/request_token',
			'authorize'	=>	'https://api.twitter.com/oauth/authorize',
			'access'	=>	'https://api.twitter.com/oauth/access_token',
			'request'	=>	'https://api.twitter.com/oauth/request_token'
		)
    )
);