<?php
namespace App\Http\Controllers\Data;

use App\Models\SystemConfigration\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;  
use App\Models\Data\Backup;
use DB;
use Storage;
use CRUDBooster;
use Illuminate\Support\Facades\Request;

class BackupController{

    public function createBackupDB($backup_name = 'Backup',$backup_notes='',$status = 1) //status = 1 // normal, status = 2 //before rotate data
    {
        $system_temp_stop_status = SystemSetting::where('setting_key', 'system_stop')->first()->setting_value;
        SystemSetting::where('setting_key','system_stop')->update([
            'setting_value'=>'on'
        ]);

        header('Content-type: text/html; charset=UTF-8');
        set_time_limit(1000000);
        $tables = '*';
        $num_rows_query=50;
        $name = env('DB_DATABASE');
        /******************** Tables *********************************** */
        //get all of the tables
        if ($tables == '*') {
            /**
             * assign empty array into $tables
             */
            $tables = array();
            /**
             * query to get all tables in database
             */
            $result =DB::select("SHOW TABLE STATUS"); 
            foreach($result as $row){ 
                $row=array_values((array)$row);
                /**
                 * assign type of row after uppercase
                 */
                $type = strtoupper($row[17]);
                /**
                 * check type is view
                 */
                if ($type == "VIEW") {
                    /**
                     * append into tables array View that's key "table name"
                     */
                    $tables[$row[0]] = "View";
                } else {
                    /**
                     * append into tables array Table that's key "table name"
                     */
                    $tables[$row[0]] = "Table";
                }
            }
            
        } else {
            /**
             * check tables not array then set into $tables explode tables of delimiter ","
             */
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        /**
         * begin file data base
         */
        $return = "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

        /*!40101 SET NAMES utf8 */;

        /*!50503 SET NAMES utf8mb4 */;

        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

        /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

        ";
        //cycle through

        /**
         * loop all tables into key as $table and value as $type
         */
        foreach ($tables as $table => $type) {
            if ($table == 'backups') {
                continue; //don't process backups table. this table must stay in database.
            }
            /**
             * query to get all records in table
             */
            $result =DB::select('SELECT * FROM ' . $table);
            /**
             * append to file comment table name
             * append to file query to drop table
             */
            //$return.="-- *******************Table: $table************************** ;" . "\n\n";
            $return.= 'DROP TABLE IF EXISTS `' . $table . '`;';
            /**
             * check if type is Table
             */
            if ($type == "Table") {
                /**
                 * query to get structre of table (structure fileds)
                 */
                $row2 =DB::select('SHOW CREATE TABLE `' . $table . '`');
                $row2 = $row2[0];
                $row2=array_values((array)$row2);
                $return.= "\n\n" . $row2[1] . ";\n\n";
                $return.= "\n";
                $return.="/*!40000 ALTER TABLE `$table` DISABLE KEYS */;";
                $return.= "\n";
                $counter = 0;
                $temp_insert = "";
                /**
                 * loop all structure fields
                 * and split each 100 records into one query insert
                 */
                
                    foreach ($result as $row) {
                        $record=array();
                        
                        foreach ($row as $key => $value) {
                            $value = addslashes($value);
                            $value=str_replace("\n", "\\n", $value);
                            
                            if ($value == '') {$value = 'NULL';} 
                            $value= "'" . $value . "'";
                            
                            
                            array_push($record, $value);
                        }
                        
                        $arr_values_str=implode(",",$record);
                        $arr_values_str=str_replace("'NULL'", "NULL", $arr_values_str);
                        $temp_insert.= "($arr_values_str),\n";
                        
                        $counter++;
                        if ($counter == $num_rows_query) {
                            $return.= 'INSERT INTO `' . $table . '` VALUES ' . "\n";
                            $temp_insert = rtrim($temp_insert);
                            $temp_insert = rtrim($temp_insert, ",");
                            $return.=$temp_insert;
                            $return.= ";\n";
                            $temp_insert = "";
                            $counter = 0;
                        }
                    }
                if ($counter > 0) {
                    $return.= 'INSERT INTO `' . $table . '` VALUES ' . "\n";
                    $temp_insert = rtrim($temp_insert);
                    $temp_insert = rtrim($temp_insert, ",");
                    $return.=$temp_insert;
                    $return.= ";\n";
                    $temp_insert = "";
                    $counter = 0;
                }
                $return.= "\n";
                $return.="/*!40000 ALTER TABLE `$table` ENABLE KEYS */;";
                $return.= "\n";
                $return.="\n\n\n";
            }
            
            /**
             * check if type view
             */ elseif ($type == "View") {
                $return.= "\n";
                /**
                 * get information schema of view
                 */
                $schema_view =DB::select("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE   TABLE_NAME='$table' AND TABLE_SCHEMA='$name'");

                $create_table = "CREATE TABLE `$table`\n"
                        . "(\n";
                $fields_view = array();
                foreach ($schema_view as $row) {
                    $row=array_values((array)$row);
                    $fields_view[] = "`" . $row[3] . "`" . " " . $row[15] . " " . ($row[6] == "YES" ? "NULL" : "NOT NULL") . " " . ($row[14] != "" ? "COLLATE '" . $row[14] . "'" : "");
                }
                
                $create_table.=implode(",\n", $fields_view);
                $create_table.="\n) ENGINE=MyISAM;";
                $return.=$create_table . "\n\n\n";
            }
        }

        /********************* Functions *********************************** */
        /**
         * get all functions in database
         */
        $functions_result =DB::select("show function status"); 

        $functions = array();
        foreach($functions_result as $row) {
            $row=array_values((array)$row);
            if ($row[0] == $name) {
                $functions[] = $row[1];
            }
        }
        /**
         * loop all functions
         */
        foreach ($functions as $function) {
            /**
             * append to file schema to create function
             */
            $return.="-- *******************Function: $function************************** " . "\n\n";
            $return.= 'DROP FUNCTION IF EXISTS `' . $function . '`;';
            $row2 =DB::select('SHOW CREATE FUNCTION `' . $function . "`"); 
            $row2=array_values((array)$row2);
            $return.= "\n\n";
            $return.="DELIMITER //";
            $return.= "\n\n" . rtrim($row2[2], ';') . "//" . "\n\n";
            $return.="DELIMITER ;";
            $return.= "\n\n";
        }


        /*     * ******************* Views *********************************** */
        /**
         * get all views in database
         */
        $views_result =DB::select("SHOW TABLE STATUS WHERE Engine IS NULL");

        $views = array();
        foreach ($views_result as $row) {
            $row=array_values((array)$row);
            $views[] = $row[0];
        }
        /**
         * loop all views
         */
        foreach ($views as $view) {
            /**
             * append to file schema to create function
             */
            $return.="-- *******************VIEW: $view************************** " . "\n\n";
            $return.= 'DROP VIEW IF EXISTS `' . $view . '`;';
            $return.= 'DROP TABLE IF EXISTS `' . $view . '`;';
            $row2 =DB::select('SHOW CREATE VIEW `' . $view . "`");
            $row2 = $row2[0];
            $row2=array_values((array)$row2);

            $return.= "\n\n" . $row2[1] . ";\n\n";
        }
        /**
         * append to file end of database file
         */
        $return.="/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;

    /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;

    /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;";


        //save backup file
        $file_path = 'backups';
        //Create Directory Monthly
        Storage::makeDirectory($file_path);
        $now_date = Carbon::now()->toDateTimeString(); 
        $backup_date = Carbon::createFromFormat('Y-m-d H:i:s', $now_date)->format('Y-m-d H-i-s');

        $file_name = "Backup-DB-" . $backup_date;
        $final_file = $file_path . '/' . $file_name . ".sql";
        Storage::put($final_file,$return);


        //insert backup to database backups table
        if (Request::input('backup_name')) {
            $backup_name = Request::input('backup_name');
        } 

        if (Request::input('backup_notes')) {
            $backup_notes = Request::input('backup_notes');
        } 

        $backup_attachs_folder_name = $file_name . "_attachs";
        $backup_attachs_status = $this->backupAttatchs($backup_attachs_folder_name);

        SystemSetting::where('setting_key','system_stop')->update([
            'setting_value'=>$system_temp_stop_status
        ]);

        if($backup_attachs_status){
            $id=Backup::insertGetId([
                'name'=>$backup_name,
                'file_name'=>$file_name,
                'attachs_folder'=>$backup_attachs_folder_name,
                'note'=> $backup_notes,
                'date'=> $now_date,
                'status'=>$status
            ]);
            if ($id) {
                CRUDBooster::insertLog(trans("crudbooster.log_create_backup", ['name' => $backup_name]));
                
                return json_encode(array('status'=>'success','massege'=>trans('messages.create_database_backup_successfully')));
            } else {
                return json_encode(array('status'=>'error','massege'=>trans('messages.create_database_backup_failed_Please_try_again')));
            }
        }else{
            return json_encode(array('status'=>'error','massege'=>trans('messages.create_database_backup_failed_attachs_doesnot_backup_correct')));
        }

    }

    public function backupAttatchs ($backup_attachs_folder_name){
        try{
            File::copyDirectory( storage_path('app/uploads'), storage_path("app/backups_attachs/$backup_attachs_folder_name"));
            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function restoreBackupDB($file_name){
        set_time_limit(1000000);
        $file = storage_path('app/backups') . '/' . $file_name . ".sql";
        //dd($file);
        if (file_exists($file)) {
            $restore_file = $file;
          
            DB::beginTransaction();
            try {
                // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $lines = file($restore_file);
                // Loop through each line
                foreach ($lines as $line) {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '') {
                        continue;
                    }
                    // Add this line to the current segment
                    $templine .= $line;
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';') {
                        // Perform the query
                        DB::statement($templine);
                        // Reset temp variable to empty
                        $templine = '';
                    }
                }

                DB::commit();
                //make system temp stop setting is off with new database
                SystemSetting::where('setting_key','system_stop')->update([
                    'setting_value'=>'off'
                ]);
                $restore_attachs_status = $this->restoreAttachs($file_name . "_attachs");
                if($restore_attachs_status){
                    return true;
                } else {
                    return false;
                }

            }
            catch (\Exception $e) {
                // Rollback Transaction
                DB::rollback();
            }
        } else {
            return false;
        }
    }

    public function restoreAttachs($backup_attachs_folder_name)
    {
        //repace uploads folder to backup attachs
        //delete uploads folder
        $clear_status = File::cleanDirectory(storage_path('app/uploads'));
        if($clear_status){
            try {
                File::copyDirectory(storage_path("app/backups_attachs/$backup_attachs_folder_name"),storage_path('app/uploads'));
                return true;
            }
            catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }

  
}