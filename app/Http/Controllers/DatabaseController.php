<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use mysqli;

class DatabaseController extends Controller
{
    public $data;

    public function __construct()
    {
        // $this->middleware('role:admin');

        $this->middleware('permission:import', ['only' => ['import']]);
        $this->middleware('permission:export', ['only' => ['export']]);


        $this->data['menu'] = '';


    }

    public function import(Request $request)
    {
        if ($request->isMethod('post')) {

            // $message = $this->import_database($_FILES['file']);
            $message = $this->import_database2($_FILES['file']);
            return redirect()->back()->with('status', $message);

        } else {
            $this->data['selected'] = 'import';
            $this->data['sub_menu'] = 'import';
            $this->data['location'] = trans('main.import');
            $this->data['location_title'] = trans('main.import');


            return view('database.import', $this->data);
        }


    }

    public function export(Request $request)
    {


        if ($request->isMethod('post')) {
            //ENTER THE RELEVANT INFO BELOW
            $user = env('DB_USERNAME');
            $pass = env('DB_PASSWORD');
            $host = env('DB_HOST');
            $name = env('DB_DATABASE');
            $backup_name = "backup.sql";
            $tables = false;
            $this->export_Database($host, $user, $pass, $name, $tables, $backup_name);

        } else {
            $this->data['selected'] = 'export';
            $this->data['sub_menu'] = 'export';
            $this->data['location'] = trans('main.export');
            $this->data['location_title'] = trans('main.export');
        }


        return view('database.export', $this->data);
    }

    public function import_database($file)
    {
        /*
        $filename = $path;
// MySQL host
        $mysql_host = 'localhost';
// MySQL username
        $mysql_username = 'root';
// MySQL password
        $mysql_password = '';
// Database name
        $mysql_database = 'testdonate';

// Connect to MySQL server

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
        // echo "Tables imported successfully";
        */


        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $db = env('DB_DATABASE');
        $message = '';

        if ($file["name"] != '') {
            $array = explode(".", $file["name"]);
            $extension = end($array);
            if ($extension == 'sql') {

                $connect = mysqli_connect($host, $username, $password, $db);
                mysqli_query($connect, "SET NAMES 'utf8'");
                $output = '';
                $count = 0;
                $this->dropAllTablesDB();
                $file_data = file($file["tmp_name"]);
                foreach ($file_data as $row) {
                    $start_character = substr(trim($row), 0, 2);
                    if ($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '') {
                        $output = $output . $row;
                        $end_character = substr(trim($row), -1, 1);
                        if ($end_character == ';') {
                            if (!mysqli_query($connect, $output)) {
                                $count++;
                                dd($output);
                            }
                            $output = '';
                        }
                    }
                }
                if ($count > 0) {
                    $message = ['msg' => 'هناك خطأ في استيراد قاعد البيانات', 'type' => 'danger'];
                } else {
                    $message = ['msg' => 'تمت العملية بنجاح', 'type' => 'success'];
                }
            } else {
                $message = ['msg' => 'الملف غير صالح', 'type' => 'danger'];

            }
        } else {
            $message = ['msg' => 'من فضلك اختار ملف sql', 'type' => 'danger'];

        }

        return $message;
    }

    public function import_database2($file)
    {
        // Name of the file

// MySQL host
        $mysql_host = 'localhost';
// MySQL username
        $mysql_username = 'root';
// MySQL password
        $mysql_password = '';
// Database name
        $mysql_database = 'donate';

        $connect = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database) or die('Error connecting to MySQL server: ' . mysql_error());

        mysqli_query($connect, "SET NAMES 'utf8'");

        $templine = '';


        $this->dropAllTablesDB();
        $count = 0;
        if ($file["name"] != '') {
            $array = explode(".", $file["name"]);
            $extension = end($array);
            if ($extension == 'sql') {
                $filename = file($file["tmp_name"]);
                $lines = $filename;
                foreach ($lines as $line) {

                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;

                    $templine .= $line;
                    if (substr(trim($line), -1, 1) == ';') {
                        // mysqli_query($connect, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
                        if (!mysqli_query($connect, $templine)) {
                            $count++;
                        }
                        $templine = '';
                    }
                }
                if ($count > 0) {
                    $message = ['msg' => 'هناك خطأ في استيراد قاعد البيانات', 'type' => 'danger'];
                } else {
                    $message = ['msg' => 'تمت العملية بنجاح', 'type' => 'success'];
                }
            } else {
                $message = ['msg' => 'الملف غير صالح', 'type' => 'danger'];
            }
        } else {
            $message = ['msg' => 'من فضلك اختار ملف sql', 'type' => 'danger'];
        }

        return $message;
    }

    public function export_Database($host, $user, $pass, $name, $tables = false, $backup_name = false)
    {
        $mysqli = new mysqli($host, $user, $pass, $name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables = $mysqli->query('SHOW TABLES ');

        /* $queryTables = $mysqli->query("SELECT  TABLE_NAME
          FROM   information_schema.tables WHERE  TABLE_SCHEMA = 'donate'
 Order by create_time asc");*/


        $target_tables = [];
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }

        if (($key = array_search("users", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("roles", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("role_user", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("permissions", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("permission_role", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("permission_user", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("password_resets", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("migrations", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("lookups", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }


        if (($key = array_search("donation_details", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }

        $target_tables = array_reverse($target_tables);
        $target_tables[] = "donation_details";

        if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }
        foreach ($target_tables as $table) {
            $result = $mysqli->query('SELECT * FROM ' . $table);
            $fields_amount = $result->field_count;
            $rows_num = $mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $TableMLine = $res->fetch_row();
            $content = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO " . $table . " VALUES";
                    }
                    $content .= "\n(";
                    for ($j = 0; $j < $fields_amount; $j++) {
                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                        if (isset($row[$j])) {
                            $content .= '"' . $row[$j] . '"';
                        } else {
                            $content .= '""';
                        }
                        if ($j < ($fields_amount - 1)) {
                            $content .= ',';
                        }
                    }
                    $content .= ")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                        $content .= ";";
                    } else {
                        $content .= ",";
                    }
                    $st_counter = $st_counter + 1;
                }
            }
            $content .= "\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        $backup_name = $backup_name ? $backup_name : $name . ".sql";
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        echo $content;
        exit;

    }


    public function dropAllTablesDB()
    {
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $name = env('DB_DATABASE');

        $mysqli = new mysqli($host, $user, $pass, $name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables = $mysqli->query('SHOW TABLES ');

        $target_tables = [];
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        }

        if (($key = array_search("users", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("roles", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("role_user", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("permissions", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("permission_role", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("permission_user", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("password_resets", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("migrations", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("lookups", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }
        if (($key = array_search("donation_details", $target_tables)) !== false) {
            unset($target_tables[$key]);
        }

        $target_tables = array_values($target_tables);

        DB::statement('SET foreign_key_checks = 0');

        $target_tables = array_reverse($target_tables);

        $target_tables[] = "donation_details";

        $table_db = "Tables_in_" . $name;
        foreach ($target_tables as $table) {
            Schema::dropIfExists($table);
        }
        DB::statement('SET foreign_key_checks = 1');

    }

    public function test()
    {
        /*   DB::beginTransaction();
           try {
               Project::create([
                   'name' => 'sss' ,
                   'information' => 'sss'
               ]);
               Project::find(755)->update([
                   'name' => "xxc"
               ]);
               DB::commit();
           }catch (\Error $e) {
               DB::rollback();
           }
        */

    }


}
