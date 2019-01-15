<?php

namespace App\Providers;

use App\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use mysqli;
use Psy\Exception\FatalErrorException;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        ini_set('max_execution_time', 120);


        try {
            $host = env('DB_HOST');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $db = env('DB_DATABASE');
            $conn = new mysqli($host, $username, $password, $db);

        } catch (\ErrorException $e) {
           $this->createDB();
        }



        /*if (DB::connection()->getDatabaseName()) {
          //  $this->createDB();
        }*/

        Validator::extend('is_zero', function ($attribute, $value, $parameters, $validator) {
            return $value == 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function createDB()
    {

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $db = env('DB_DATABASE');


        $conn = new mysqli($host, $username, $password);

        $sql = "CREATE DATABASE $db";
        $conn->query($sql);
        $this->import_database();

    }

    public function import_database()
    {


        $filename = public_path()."/db_first/donate.sql";

        $mysql_host = env('DB_HOST');
        $mysql_username =  env('DB_USERNAME');
        $mysql_password = env('DB_PASSWORD');
        $mysql_database =env('DB_DATABASE');

        $mysqli = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
        $mysqli->select_db($mysql_database);

        $templine = '';

        $lines = file($filename);

            foreach ($lines as $line) {

                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;


                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {

                    $mysqli->query($templine);
                    $templine = '';
                }
            }




    }
}
