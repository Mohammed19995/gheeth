<?php

use Dompdf\Dompdf;

Route::get('foo', function () {
    return 'Hello World';
});

Route::group(['middleware' => 'auth'], function () {


    Route::get('/', 'HomeController@index');

    Route::patch('users/updateUserInfo/{id}', 'UserController@updateInfo')->name('updateUserInfo');


    Route::get('roles/newRole', 'RoleController@newRole')->name('roles.newRole');
    Route::get('roles/view', 'RoleController@view')->name('roles.view');
    Route::get('roles/editRole/{id}', 'RoleController@editRole')->name('roles.editRole');
    Route::patch('roles/updateRole/{id}', 'RoleController@updateRole')->name('roles.updateRole');
    Route::delete('roles/destroyRole/{id}', 'RoleController@destroyRole')->name('roles.destroyRole');


    Route::get('users/profile', 'UserController@profile')->name('users.profile');
    Route::post('users/changePassword', 'UserController@changePassword')->name('users.changePassword');


    Route::get('delUser/{id}', 'UserController@destroy');
    Route::get('delBroker/{id}', 'BrokerController@destroy');
    Route::get('delDonor/{id}', 'DonorController@destroy');
    Route::get('delProject/{id}', 'ProjectController@destroy');
    Route::get('delDonation/{id}', 'DonationController@destroy');


    Route::post('roles/storeRole', 'RoleController@storeRole')->name('roles.store_role');
    Route::get('project/generate_project_number/{num}', 'ProjectController@generate_project_number');


    Route::post('user/contentListData', 'UserController@contentListData');
    Route::post('user/contentListData/{status}', 'UserController@contentListData');

    Route::post('broker/contentListData', 'BrokerController@contentListData');
    Route::get('viewBroker', 'BrokerController@viewBroker');

    Route::post('donor/contentListData', 'DonorController@contentListData');
    Route::get('viewDonor', 'DonorController@viewDonor');

    Route::post('project/contentListData', 'ProjectController@contentListData');
    Route::get('viewProject', 'ProjectController@viewProject');


    Route::post('donation/contentListData', 'DonationController@contentListData');
    Route::post('donation/contentListData2', 'DonationController@contentListData2');


    Route::resource('users', 'UserController');
    Route::resource('brokers', 'BrokerController');
    Route::resource('donors', 'DonorController');
    Route::resource('projects', 'ProjectController');
    Route::resource('donations', 'DonationController');
    Route::post('donations/{id}', 'DonationController@update');

     Route::post('updateDonation' ,'DonationController@updateDonation' );


    Route::get('import', 'DatabaseController@import');
    Route::post('import', 'DatabaseController@import');
    Route::get('export', 'DatabaseController@export');
    Route::post('export', 'DatabaseController@export');
    /*               check jquery validation                  */
    Route::get('checkExistEmail', 'BrokerController@checkExistEmail');

    /*                                 */

    /*                              */

    Route::get('searchDonor', 'DonorController@search');
    Route::post('searchDonor', 'DonorController@search');

    Route::get('searchProject', 'ProjectController@search');
    Route::post('searchProject', 'ProjectController@search');


    Route::get('searchBroker', 'BrokerController@search');
    Route::post('searchBroker', 'BrokerController@search');

    Route::get('searchDonation', 'DonationController@search');
    Route::post('searchDonation', 'DonationController@search');

    Route::get('searchBrokerDonor', 'BrokerController@searchBrokerDonor');
    Route::post('searchBrokerDonor', 'BrokerController@searchBrokerDonor');
    /*                              */

    Route::post('getDonorForBroker', 'DonationController@getDonorForBroker');
    Route::get('getDonations', 'DonationController@getDonations');


    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    });

});


Route::get('test', function () {

    $donations = \App\DonationDetail::leftJoin('brokers', 'brokers.id', '=', 'donation_details.broker_id')
        ->leftJoin('donors', 'donors.id', '=', 'donation_details.donor_id')
        ->leftJoin('projects', 'projects.id', '=', 'donation_details.project_id')
        ->select('projects.id as project_id', 'projects.name as project_name', 'donors.id as donor_id', 'donors.name as donor_name', 'brokers.id as broker_id', 'brokers.name as broker_name'
            , 'donation_details.*')
        ->get();
    dd($donations);
    /*
        $date = \Carbon\Carbon::createFromFormat('Y-m-d' , '2018-7-2');
        $date2 = \Carbon\Carbon::parse($date)->format('d M,Y');
        dd($date2);
        /*
        $ds = DIRECTORY_SEPARATOR;

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $ts = time();
        $path = public_path() . $ds . 'backups' . $ds . date('Y', $ts) . $ds . date('m', $ts) . $ds . date('d', $ts) . $ds;
        $file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';

        $command = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username, $password, $database, $path . $file);
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        exec($command);

        /*$path = public_path() . "/db/mytable.sql";
        $command = "mysqldump -u root -p  > " . $path;
        exec($command);
        /*$tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
        foreach($tables as $table)
        {
            echo $table->Tables_in_donate."<br>";
        }
        */
    /*
    $file = public_path()."/"."db/mytable.sql";
    $f = \Illuminate\Support\Facades\File::get($file);
    $result = mysql_query("SELECT * INTO OUTFILE '$file' FROM `##table##`");
    \Illuminate\Support\Facades\DB::select("SELECT * INTO OUTFILE '$f' FROM users");

    $file = public_path()."/"."db/mytable.sql";
    $a = \Illuminate\Support\Facades\DB::select("SELECT * from users");

    /*
        $a = \App\DonationDetail::all();


        $a = $a->map(function($value) {
            $data = [];
            $data['total_price'] = $value->donation->total_price;
            $data['title'] = $value->donation->title;

            $data['project_id'] = $value->project_id;
            $data['project_name'] = $value->projects->first()->name;

            $data['donor_id'] = $value->donor_id;
            $data['donor_name'] = $value->donor->name;

            $data['broker_id'] = $value->broker_id;
            $data['broker_name'] = $value->broker->name;

            $data['price'] = $value->price;
            $data['asr'] = $value->sar;
            $data['donation_date'] =$value->add_date->format('d-m-Y');
            return $data;
        });
        dd($a);*/

});

Auth::routes();
