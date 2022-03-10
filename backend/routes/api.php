<?php

$router->get('/', function () use ($router) {
	return 'Beverra SIRESI API';
});

$router->group(['prefix'=>'v1'], function () use ($router)
{
	//auth login
	$router->post('/auth/login', ['uses'=>'AuthController@login','as'=>'auth.login']);

	//untuk uifront
	$router->get('/system/setting/uifront', ['uses'=>'System\UIController@frontend','as'=>'uifront.frontend']);
});