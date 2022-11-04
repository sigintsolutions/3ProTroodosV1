<?php

Route::redirect('/', '/argus/login');

Route::redirect('/home', '/argus/admin');

Route::redirect('/home2', '/argus/agent');

Auth::routes(['register' => false]);
//Route::get('/multilogin', 'HomeController@multilogin')->name('multilogin');
//Route::redirect('/multilogin', 'HomeController@multilogin')->name('multilogin');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
Route::get('multilogin', 'HomeController@multilogin')->name('multilogin');
Route::get('sessionexpiry', 'HomeController@sessionexpiry')->name('sessionexpiry');

Route::get('testadminhubchart','ReportController@test');
Route::get('deletetempdata','ReportController@deletetempdata');
Route::post('pushmsgreset', 'ReportController@pushmsgreset');
Route::get('getdata','ReportController@getdata');
Route::get('getdataall','ReportController@getdataall');
Route::get('getdataandor','ReportController@getdataandor');
Route::post('savecharttempdata','ReportController@savecharttempdata');
Route::post('getsensortimefetchpage','ReportController@getsensortimefetchpage');
Route::post('getsensortimefetchpagehub','AlgorithmsController@getsensortimefetchpagehub');
Route::get('duplicatedelete','AlgorithmsController@duplicatedelete');
Route::post('getchartpage', 'ReportController@getchartpage');

//Route::post('getchart2', 'ReportController@getChart');
Route::post('getsensortimefetchpageprev','ReportController@getsensortimefetchpageprev');
Route::post('getsensortimefetchpageprevhub','AlgorithmsController@getsensortimefetchpageprevhub');

Route::get('getallrecords','ReportController@getallrecords');

Route::get('dashsensedetails', 'AgentsController@dashsensedetails');
Route::get('getpushmsgload', 'ReportController@getpushmsgload');
Route::get('getpushmsg', 'ReportController@getpushmsg');
Route::get('getpushnotmsg', 'ReportController@getpushnotmsg');

Route::get('getpushnotmsgandor', 'ReportController@getpushnotmsgandor');
Route::get('uppushmsgreadflag', 'ReportController@uppushmsgreadflag');

Route::get('uppushmsgreadflagcount', 'ReportController@uppushmsgreadflagcount');
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');
	
    //Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    //Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');
	
	//oute::delete('products/destroy', 'SettingsController@massDestroy')->name('settings.massDestroy');

    Route::resource('settings', 'SettingsController');
	
	Route::post('insertgroup', 'SettingsController@insertGroup');
	
	Route::get('deleteGroup/{id}', 'SettingsController@deleteGroup');
	Route::get('deleteGroupcnt', 'SettingsController@deleteGroupcnt');
	Route::post('updategroup', 'SettingsController@updateGroup');
	
	Route::post('inserthub', 'SettingsController@insertHub');
	
	Route::get('deleteHub/{id}', 'SettingsController@deleteHub');
	
	Route::post('updatehub', 'SettingsController@updateHub');
	
	Route::post('inserttype', 'SettingsController@insertType');
	
	Route::get('deleteType/{id}', 'SettingsController@deleteType');
	Route::get('deleteTypecnt', 'SettingsController@deleteTypecnt');
	Route::post('updatetype', 'SettingsController@updateType');
	
	Route::post('insertbrand', 'SettingsController@insertBrand');
	
	Route::get('deleteBrand/{id}', 'SettingsController@deleteBrand');
	Route::get('getsensoreditdetails', 'SettingsController@getsensoreditdetails');
	Route::get('getsensoreditdetailscount', 'SettingsController@getsensoreditdetailscount');
Route::get('getsensoreditdetailstype', 'SettingsController@getsensoreditdetailstype');
Route::get('getsensoreditdetailschart','SettingsController@getsensoreditdetailschart');
Route::get('getsensoreditdetailstypecount', 'SettingsController@getsensoreditdetailstypecount');

Route::get('getchartcount','SettingsController@getchartcount');
	Route::post('updatebrand', 'SettingsController@updateBrand');
	
	Route::post('insertunit', 'SettingsController@insertUnit');
	
	Route::get('deleteUnit/{id}', 'SettingsController@deleteUnit');
	
	Route::post('updateunit', 'SettingsController@updateUnit');
	
	Route::post('insertmeasureunit', 'SettingsController@insertMeasureUnit');
	
	Route::get('deleteMeasureUnit/{id}', 'SettingsController@deleteMeasureUnit');
	
	Route::post('updatemeasureunit', 'SettingsController@updateMeasureUnit');
	
	Route::resource('users', 'AdminsController');
	
	Route::get('adduser', 'AdminsController@addUser');
	
	Route::post('insertuser', 'AdminsController@insertUser');
	
	Route::get('deleteUser/{id}', 'AdminsController@deleteUser');
	
	Route::get('editUser/{id}', 'AdminsController@editUser');
	
	Route::post('updateuser', 'AdminsController@updateUser');
	
	
	Route::resource('algorithms', 'AlgorithmsController');
	
	Route::get('addalgorithm', 'AlgorithmsController@addAlgorithm');
	
	Route::post('insertalgorithm', 'AlgorithmsController@insertAlgorithm');
	
	Route::get('deleteAlgorithm/{id}', 'AlgorithmsController@deleteAlgorithm');
	
	Route::get('editAlgorithm/{id}', 'AlgorithmsController@editAlgorithm');
	
	Route::post('updatealgorithm', 'AlgorithmsController@updateAlgorithm');
	
	Route::post('getgroup', 'AlgorithmsController@getGroup');
	Route::post('getgroup2', 'AlgorithmsController@getGroup2');
	Route::post('getgroup3', 'AlgorithmsController@getGroup3');
	
	Route::post('gethub', 'AlgorithmsController@getHub');
	Route::post('gethub2', 'AlgorithmsController@getHub2');
	Route::post('gethub3', 'AlgorithmsController@getHub3');
	Route::post('getsensor', 'AlgorithmsController@getSensor');
	Route::post('getsensorreport', 'ReportController@getsensorreport');
	Route::post('getsensorreport3', 'ReportController@getsensorreport3');
	Route::post('getunit', 'ReportController@getunit');
	Route::post('getunit2', 'ReportController@getunit2');
	Route::post('getunit3', 'ReportController@getunit3');
	Route::post('getchart', 'AlgorithmsController@getChart');
	Route::post('getsensordata', 'AlgorithmsController@getSensordata');
	Route::post('getsensordatachart', 'AlgorithmsController@getSensordatachart');
Route::post('getsensordatachartdy', 'AlgorithmsController@getsensordatachartdy');

	Route::post('getsensordatachartnextsens', 'AlgorithmsController@getsensordatachartnextsens');
	Route::post('getsensordatachartnextsens3', 'AlgorithmsController@getsensordatachartnextsens3');

Route::post('getsensordatachartnextsens3dy', 'AlgorithmsController@getsensordatachartnextsens3dy');

	Route::resource('emails', 'EmailsController');
	
	Route::post('insertemail', 'EmailsController@insertEmail');
	
	Route::post('updateemail', 'EmailsController@updateEmail');
	
	Route::post('insertemail2', 'EmailsController@insertEmail2');
	
	Route::post('updateemail2', 'EmailsController@updateEmail2');
	Route::resource('agents', 'AgentsController');	
	Route::get('addagent', 'AgentsController@addAgent');
	Route::post('insertagent', 'AgentsController@insertAgent');
	Route::get('deleteAgent/{id}', 'AgentsController@deleteAgent');
	Route::get('deleteagnt/{id}', 'AgentsController@deleteagnt');
	Route::get('editAgent/{id}', 'AgentsController@editAgent');
	Route::get('editAgenttree/{id}', 'AgentsController@editAgenttree');
	Route::get('editAgentpop/{id}', 'AgentsController@editAgentpop');
	Route::post('updateagent', 'AgentsController@updateAgent');
	Route::post('import_excel/import', 'AgentsController@import');
	Route::post('import_excel/profileimport', 'AgentsController@profileimport');
	Route::post('import_excel/groupeditimport', 'AgentsController@groupeditimport');
	Route::post('import_excel/hubeditimport', 'AgentsController@hubeditimport');
	Route::post('import_excel/sensoreditimport', 'AgentsController@sensoreditimport');
	Route::get('/groups/{agentid}', 'AgentsController@groups');
	Route::post('/import_excel/importgroup', 'AgentsController@importgroup');
	Route::get('sensorhubs/{agentid}/{groupid}', 'AgentsController@sensorhubs');
	Route::post('/import_excel/importhub', 'AgentsController@importhub');
	Route::get('editgrouppop/{id}', 'AgentsController@editgrouppop');
	Route::get('editSensorhubpop/{id}', 'AgentsController@editSensorhubpop');
	Route::get('/sensors/{agentid}/{groupid}/{hubid}', 'AgentsController@sensors');
	Route::post('/import_excel/importsensor', 'AgentsController@importsensor');
	Route::get('editSensorpop/{id}', 'AgentsController@editSensorpop');
	Route::get('addgrouppop/{id}', 'AgentsController@addgrouppop');
	Route::get('addsensorpop/{id}', 'AgentsController@addsensorpop');
	Route::get('addsensorpopval/{id}', 'AgentsController@addsensorpopval');
	Route::get('/addsensordrop/{val}', 'AgentsController@addsensordrop');
	Route::get('/addsensordrop/{val1}/{val2}', 'AgentsController@addsensordropedit');
	Route::get('addsensorpopval2/{val1}/{val2}', 'AgentsController@addsensorpopval2');
	Route::get('editSensorhubpoptree/{id}', 'AgentsController@editSensorhubpoptree');
	Route::get('editSensorpoptree/{id}', 'AgentsController@editSensorpoptree');
	Route::post('/import_excel/importmulgroup', 'AgentsController@importmulgroup');
	Route::post('/import_excel/importmulhub', 'AgentsController@importmulhub');
	Route::post('/import_excel/importmulsensor', 'AgentsController@importmulsensor');
	Route::get('exportagent/{id}', 'AgentsController@exportagent');
	Route::get('exportgroup/{id}', 'AgentsController@exportgroup');
	Route::get('exporthub/{id}', 'AgentsController@exporthub');
	Route::get('exportsensor/{id}', 'AgentsController@exportsensor');
	Route::get('/dashboard/{id}', 'AgentsController@dashboard');
	Route::post('/gethublist', 'AgentsController@gethublist');
	Route::post('/getsensorlist', 'AgentsController@getsensorlist');
	Route::post('/getchartlist', 'AgentsController@getchartlist');
	Route::post('/import_excel/importgroupname', 'AgentsController@importgroupname');
	Route::post('/import_excel/importhubname', 'AgentsController@importhubname');
	Route::post('/import_excel/importunit', 'AgentsController@importunit');
	Route::post('/import_excel/importtype', 'AgentsController@importtype');
	Route::post('/import_excel/importbrand', 'AgentsController@importbrand');
	Route::get('/exportgroupname', 'AgentsController@exportgroupname');
	Route::get('/exporthubname', 'AgentsController@exporthubname');
	Route::get('/exportunit', 'AgentsController@exportunit');
	Route::get('/exporttype', 'AgentsController@exporttype');
	Route::get('/exportbrand', 'AgentsController@exportbrand');
	Route::post('/createsensorgraph', 'AgentsController@createsensorgraph');
	Route::get('/editgraph/{id}', 'AgentsController@editgraph');
	Route::post('/updategraph', 'AgentsController@updategraph');
	Route::get('/sensortype/{id}', 'AgentsController@sensortype');
	Route::get('/addgraph/{type}', 'AgentsController@addgraph');
	Route::post('insertgrouppop', 'AgentsController@insertgrouppop');
	Route::post('inserthubpop', 'AgentsController@inserthubpop');
	Route::post('insertsensorpop', 'AgentsController@insertsensorpop');
	Route::post('/autocomplete/fetch', 'AgentsController@fetch')->name('autocomplete.fetch');
	Route::post('/autocomplete/fetchagent', 'AgentsController@fetchagent')->name('autocomplete.fetchagent');
	Route::get('/sensordata', 'AgentsController@sensordata')->name('sensordata');
	Route::get('/weather', 'AgentsController@weather');
	Route::post('/insertloc', 'AgentsController@insertloc');
	Route::get('/loc', 'AgentsController@loc');
	Route::post('/editloc', 'AgentsController@editloc');
	Route::get('/deleteloc/{val}', 'AgentsController@deleteloc');
	Route::get('/getwea/{val}', 'AgentsController@getwea');
	Route::post('/insertwea', 'AgentsController@insertwea');
	Route::post('/editwea', 'AgentsController@editwea');
	Route::get('/deletewea/{val}', 'AgentsController@deletewea');
	Route::post('/addunit', 'AgentsController@addunit');
	Route::post('/editunit', 'AgentsController@editunit');
	Route::get('/deleteunit/{val}', 'AgentsController@deleteunit');
	Route::post('/searchlog', 'HomeController@searchlog');
	Route::get('/hubgetinsert', 'AgentsController@hubgetinsert');
	Route::get('/getsensordrop', 'AgentsController@getsensordrop');
	Route::get('/gethubdrop', 'AgentsController@gethubdrop');

	Route::post('updatesensorhub', 'SensorhubController@updateSensorhub');
	
	Route::resource('gatewaygroups', 'GatewaygroupController');
	Route::get('addgatewaygroup', 'GatewaygroupController@addGatewaygroup');
	Route::post('insertgatewaygroup', 'GatewaygroupController@insertGatewaygroup');
	
	Route::get('deleteGatewaygroup/{id}', 'GatewaygroupController@deleteGatewaygroup');
	Route::get('/deleteGatewaygroups/{id}', 'GatewaygroupController@deleteGatewaygroups');
	Route::get('editGatewaygroup/{id}', 'GatewaygroupController@editGatewaygroup');
	Route::get('editGatewaygrouptree/{id}', 'GatewaygroupController@editGatewaygrouptree');
	Route::post('updategatewaygroup', 'GatewaygroupController@updateGatewaygroup');
	
	Route::resource('sensorhubs', 'SensorhubController');	
	Route::get('addsensorhub', 'SensorhubController@addSensorhub');
	Route::post('insertsensorhub', 'SensorhubController@insertSensorhub');
	Route::post('insertsensorhubalert', 'SensorhubController@insertsensorhubalert');
	Route::get('deleteSensorhub/{id}', 'SensorhubController@deleteSensorhub');
	Route::get('deleteSensorhubs/{id}', 'SensorhubController@deleteSensorhubs');
	Route::get('editSensorhub/{id}', 'SensorhubController@editSensorhub');	
	Route::get('editSensorhubtree/{id}', 'SensorhubController@editSensorhubtree');
	//Route::get('generateid', 'GatewaygroupController@generateId');
	Route::get('checkmacid','SensorhubController@checkmacid');
	Route::resource('sensors', 'SensorController');
	
	Route::get('showsensor/{hubid}', 'SensorController@showSensor');
	
	Route::get('addsensor/{hubid}', 'SensorController@addSensor');
	
	Route::post('insertsensor', 'SensorController@insertSensor');
	
	Route::get('deleteSensor/{id}', 'SensorController@deleteSensor');
	Route::get('deleteSensors/{id}', 'SensorController@deleteSensors');
	Route::get('editSensor/{id}/{hubid}/{agentid}/{groupid}', 'SensorController@editSensor');
	Route::post('updatesensor', 'SensorController@updateSensor');
	Route::get('userlogdemochart', 'ReportController@userlogdemochart');
	Route::get('userlog', 'ReportController@userlog');
	Route::get('userlogtest', 'ReportController@userlogtest');
	Route::post('pushmsg', 'ReportController@pushmsg');	
	Route::post('getlog', 'ReportController@getlog');
	
	Route::post('getchart2', 'ReportController@getChart');	
	
	Route::post('getchart3', 'ReportController@getChart3');	
	
	Route::get('fetch_data', 'ReportController@fetch_data');
	
	Route::post('getsensortime', 'ReportController@getsensortime');	
	
	Route::get('fetch_data2', 'ReportController@fetch_data2');
	Route::post('export', 'ReportController@export');	
	Route::post('/exporthub', 'ReportController@exporthub');
	Route::post('export3', 'ReportController@export3');
	Route::get('/getchartcount', 'ReportController@getchartcount');
	Route::get('/getchartcounthub/{val}', 'ReportController@getchartcounthub');
	Route::get('/getchartcounthubdy/{val}', 'ReportController@getchartcounthubdy');
Route::post('savecharttempdatahub','AlgorithmsController@savecharttempdatahub');


	
});



### For Agents


Route::group(['prefix' => 'agent', 'as' => 'agent.', 'namespace' => 'Agent', 'middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('sessionexpiry', 'HomeController@sessionexpiry')->name('sessionexpiry');
	
Route::post('savecharttempdata','ReportController@savecharttempdata');

Route::get('deletetempdata','ReportController@deletetempdata');
Route::post('pushmsgreset', 'ReportController@pushmsgreset');


Route::post('getsensortimefetchpage','ReportController@getsensortimefetchpage');
Route::post('getsensortimefetchpageprev','ReportController@getsensortimefetchpageprev');

Route::post('getsensortimefetchpagealg','AlgorithmsController@getsensortimefetchpage');
Route::post('getsensortimefetchpageprevalg','AlgorithmsController@getsensortimefetchpageprev');
//Route::post('getchartpage', 'ReportController@getchartpage');

//Route::post('getchart2', 'ReportController@getChart');

Route::post('savecharttempdatahub','AlgorithmsController@savecharttempdatahub');




	Route::get('dashsensedetails', 'HomeController@dashsensedetails');
	Route::get('userlog', 'ReportController@userlog');
	
	Route::post('getlog', 'ReportController@getlog');
	
	Route::post('getchart2', 'ReportController@getChart');	
	
	Route::post('getchart3', 'ReportController@getChart3');
	Route::get('getpushmsgload', 'ReportController@getpushmsgload');	
	Route::get('getpushmsg', 'ReportController@getpushmsg');
Route::get('uppushmsgreadflag', 'ReportController@uppushmsgreadflag');

Route::get('uppushmsgreadflagcount', 'ReportController@uppushmsgreadflagcount');
	

	Route::get('fetch_data', 'ReportController@fetch_data');
	
	Route::post('getsensortime', 'ReportController@getsensortime');	
	Route::post('pushmsg', 'ReportController@pushmsg');		
	Route::get('fetch_data2', 'ReportController@fetch_data2');
	//Route::get('/fetch_data2/{val1}/{val2}/{val3}/{val4}/{val5}/{val6}', 'ReportController@fetch_data2');
	Route::post('export', 'ReportController@export');
	Route::post('/exporthub', 'ReportController@exporthub');
	Route::post('export3', 'ReportController@export3');
	Route::get('/getchartcount', 'ReportController@getchartcount');
	Route::get('/getchartcounthub/{val}', 'ReportController@getchartcounthub');
	//Route::post('getsensortime', 'ReportController@getsensortime');
	
	
	
	Route::post('export', 'ReportController@export');
	
	Route::post('gethub', 'AlgorithmsController@getHub');
	Route::post('gethub2', 'AlgorithmsController@getHub2');  
	Route::post('gethub3', 'AlgorithmsController@getHub3'); 
	Route::post('getsensor', 'AlgorithmsController@getSensor');
	Route::post('getsensorreport', 'AlgorithmsController@getsensorreport');
	Route::post('getchart', 'AlgorithmsController@getChart');
	
	Route::post('getgroup', 'AlgorithmsController@getGroup');
	
	Route::post('gethub', 'AlgorithmsController@getHub');
	
	Route::post('getsensor', 'AlgorithmsController@getSensor');
	Route::post('getsensordata', 'AlgorithmsController@getSensordata');
	Route::post('getsensordatachart', 'AlgorithmsController@getSensordatachart');
    Route::resource('profile', 'ProfileController');
	
	Route::get('editAlgorithm/{id}', 'AlgorithmsController@editAlgorithm');
	
	Route::post('updatealgorithm', 'AlgorithmsController@updateAlgorithm');
	
	Route::post('getchart', 'AlgorithmsController@getChart');
//	Route::resource('sensors', 'SensorController');
    Route::get('gateway', 'GatewayController@showGateway');
	Route::get('addview', 'GatewayController@addView');
	Route::get('profileagent/{id}', 'GatewayController@profileagent');
	Route::get('/sensorhubs/{agentid}/{groupid}', 'GatewayController@sensorhubs');
	Route::get('profileSensorhub/{id}', 'GatewayController@profileSensorhub');
	Route::get('/sensors/{agentid}/{groupid}/{hubid}', 'GatewayController@sensors');
	Route::get('editSensor/{id}/{hubid}/{agentid}/{groupid}', 'GatewayController@editSensor');
	Route::get('/algorithm', 'GatewayController@algorithm');
	Route::get('/editalgorithm/{id}', 'GatewayController@editalgorithm');
	Route::get('editGatewaygrouptree/{id}', 'GatewayController@editGatewaygrouptree');
	Route::get('editSensorhubtree/{id}', 'GatewayController@editSensorhubtree');
});

