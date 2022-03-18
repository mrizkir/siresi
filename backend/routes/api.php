<?php

$router->get('/', function () use ($router) {
	return 'Beverra SIRESI API';
});

$router->group(['prefix'=>'v1'], function () use ($router)
{
	//auth login
	$router->post('/auth/login', ['uses'=>'AuthController@login','as'=>'auth.login']);

	//untuk uifront
	$router->get('/setting/uifront', ['uses'=>'Setting\UIController@frontend','as'=>'uifront.frontend']);
});

$router->group(['prefix'=>'v1', 'middleware'=>'auth:api'], function () use ($router)
{
	//authentication
	$router->post('/auth/logout', ['uses'=>'AuthController@logout', 'as'=>'auth.logout']);
	$router->get('/auth/refresh', ['uses'=>'AuthController@refresh', 'as'=>'auth.refresh']);
	$router->get('/auth/me', ['uses'=>'AuthController@me', 'as'=>'auth.me']);

	//setting - permissions
	$router->get('/setting/pengguna/permissions',['middleware'=>['role:superadmin'],'uses'=>'Setting\PermissionsController@index','as'=>'permissions.index']);
	$router->post('/setting/pengguna/permissions/store',['middleware'=>['role:superadmin'],'uses'=>'Setting\PermissionsController@store','as'=>'permissions.store']);
	$router->delete('/setting/pengguna/permissions/{id}',['middleware'=>['role:superadmin'],'uses'=>'Setting\PermissionsController@destroy','as'=>'permissions.destroy']);

	//setting - roles
	$router->get('/setting/pengguna/roles',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@index','as'=>'roles.index']);
	$router->post('/setting/pengguna/roles/store',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@store','as'=>'roles.store']);
	$router->post('/setting/pengguna/roles/storerolepermissions',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@storerolepermissions','as'=>'roles.storerolepermissions']);
	$router->post('/setting/pengguna/roles/revokerolepermissions',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@revokerolepermissions','as'=>'users.revokerolepermissions']);
	$router->put('/setting/pengguna/roles/{id}',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@update','as'=>'roles.update']);
	$router->delete('/setting/pengguna/roles/{id}',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@destroy','as'=>'roles.destroy']);
	$router->get('/setting/pengguna/roles/{id}/permission',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@rolepermissions','as'=>'roles.permission']);
	$router->get('/setting/pengguna/rolesbyname/{id}/permission',['middleware'=>['role:superadmin'],'uses'=>'Setting\RolesController@rolepermissionsbyname','as'=>'roles.permissionbyname']);

	//setting - user
	// $router->get('/setting/users',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@index','as'=>'users.index']);
	// $router->post('/setting/users/store',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@store','as'=>'users.store']);
	// $router->put('/setting/users/updatepassword/{id}',['uses'=>'Setting\UsersController@updatepassword','as'=>'users.updatepassword']);
	// $router->post('/setting/users/uploadfoto/{id}',['uses'=>'Setting\UsersController@uploadfoto','as'=>'users.uploadfoto']);
	// $router->post('/setting/users/resetfoto/{id}',['uses'=>'Setting\UsersController@resetfoto','as'=>'users.resetfoto']);
	$router->post('/setting/users/syncallpermissions',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@syncallpermissions','as'=>'users.syncallpermissions']);
	// $router->post('/setting/users/storeuserpermissions',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@storeuserpermissions','as'=>'users.storeuserpermissions']);
	// $router->post('/setting/users/revokeuserpermissions',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@revokeuserpermissions','as'=>'users.revokeuserpermissions']);
	// $router->put('/setting/users/{id}',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@update','as'=>'users.update']);
	// $router->get('/setting/users/{id}',['uses'=>'Setting\UsersController@show','as'=>'users.show']);
	// $router->delete('/setting/users/{id}',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@destroy','as'=>'users.destroy']);
	//lokasi method userpermission ada di file UsersController
	$router->get('/setting/users/{id}/permission',['middleware'=>['role:superadmin'],'uses'=>'Setting\UsersController@userpermissions','as'=>'users.permission']);
	$router->get('/setting/users/{id}/mypermission',['uses'=>'Setting\UsersController@mypermission','as'=>'users.mypermission']);	
	$router->get('/setting/users/{id}/roles',['uses'=>'Setting\UsersController@roles','as'=>'users.roles']);

	//setting - pengguna - admin
	$router->get('/setting/pengguna/admin',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserAdminController@index','as'=>'useradmin.index']);
	$router->post('/setting/pengguna/admin/store',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserAdminController@store','as'=>'useradmin.store']);
	$router->put('/setting/pengguna/admin/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserAdminController@update','as'=>'useradmin.update']);    
	$router->delete('/setting/pengguna/admin/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserAdminController@destroy','as'=>'useradmin.destroy']);
	
	//setting - pengguna - picker
	$router->get('/setting/pengguna/picker',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserPickerController@index','as'=>'userpicker.index']);
	$router->post('/setting/pengguna/picker/store',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserPickerController@store','as'=>'userpicker.store']);
	$router->put('/setting/pengguna/picker/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserPickerController@update','as'=>'userpicker.update']);    
	$router->delete('/setting/pengguna/picker/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserPickerController@destroy','as'=>'userpicker.destroy']);
	
	//setting - pengguna - checker
	$router->get('/setting/pengguna/checker',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserCheckerController@index','as'=>'userchecker.index']);
	$router->post('/setting/pengguna/checker/store',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserCheckerController@store','as'=>'userchecker.store']);
	$router->put('/setting/pengguna/checker/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserCheckerController@update','as'=>'userchecker.update']);    
	$router->delete('/setting/pengguna/checker/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserCheckerController@destroy','as'=>'userchecker.destroy']);
	
	//setting - pengguna - hand offer
	$router->get('/setting/pengguna/handoffer',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserHandOfferController@index','as'=>'handoffer.index']);
	$router->post('/setting/pengguna/handoffer/store',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserHandOfferController@store','as'=>'handoffer.store']);
	$router->put('/setting/pengguna/handoffer/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserHandOfferController@update','as'=>'handoffer.update']);    
	$router->delete('/setting/pengguna/handoffer/{id}',['middleware'=>['role:superadmin|admin'],'uses'=>'Setting\UserHandOfferController@destroy','as'=>'handoffer.destroy']);


});