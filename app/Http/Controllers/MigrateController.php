<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateController extends Controller
{
    private $conn = "";  
    private $tables = array();    
    private $table_name = "";   
    private $tableInfo = array(); 
    private $tableIndex;

    public function index(){
      $this->conn = $this->getMSAccessConnection();
      $this->createTable();
      $this->insertData();
    }
    
    public function getMSAccessConnection(){

      $db = realpath("C:/AppServ/www/elclient/ext/kt_2.mdb").";";
      $conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$db", "", "");      
      return $conn ;
    }
    
    public function createTable() {
      echo "///////////////////<br>";
      echo "//create table//<br>";
      echo "//////////////////<br>";
      $result = odbc_tables($this->conn);

      
      while (odbc_fetch_row($result)){
        if (odbc_result($result, 4) == "TABLE"){
          array_push($this->tables, odbc_result($result, "TABLE_NAME") );
        }
      }

      //var_dump($this->tables); exit;
      //odbc_result_all($result); exit;

      $this->tableIndex=0;
      foreach($this->tables as $tb){

        $this->table_name = $this->tis620_to_utf8($tb);
        
        

        if(Schema::hasTable($this->table_name)){
          //Alter table
          echo $this->table_name." is exist.<br>";

        }else{
            Schema::create($this->table_name ,function ($table) {
              //Query get field name
              $table_name = $this->utf8_to_tis620($this->table_name);
              echo "Create table ".$this->table_name ."<br>";
              $query = "SELECT top 1 * FROM ".$table_name;
              $result = odbc_exec($this->conn, $query);               
              $table->increments('key');
              
              //Generate field name
              $fieldIndex=0;
              for($i=1; $i<=odbc_num_fields($result); $i++){ 
                $field_name = $this->tis620_to_utf8(odbc_field_name($result, $i));
                $field_type = odbc_field_type($result, $i);
                

                switch ($field_type) {
                case "COUNTER":
                    $table->integer($field_name);
                    break;
                case "INTEGER":
                    $table->integer($field_name);
                    break;
                case "VARCHAR":
                    $table->string($field_name);
                    break;
                case "LONGCHAR":
                    $table->text($field_name);
                    break;
                case "DATETIME":
                    $table->dateTime($field_name);
                    break;
                case "BIT":
                    $table->boolean($field_name);
                    break;
                default:
                    $table->text($field_name);
                }
                
                $this->tableInfo[$this->tableIndex]["field_name"][$fieldIndex++] = $field_name;
                //$this->tableInfo[$this->tableIndex]["field_type"][$fieldIndex++] = $field_type;
              }

              $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
              $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            });

        }

        //var_dump($this->tableInfo);

        $this->tableIndex++;
      }//end loop table
    }
    
    
    public function insertData() {
      
      echo "<br>///////////////////<br>";
      echo "//insert data//<br>";
      echo "//////////////////<br>";  

      $tables = DB::select('SHOW TABLES');
      //print_r(count($tables)); exit;
      foreach ($tables as $value) {
        $table =$value->Tables_in_election_client;

        //Query data from MSAccess
        //Count
        $query = "SELECT count(*) FROM ".$table;
        $result = odbc_exec($this->conn, $query); 
        $rows =odbc_result($result, 1);
        echo $table." : ".$rows."<br>";

        //Select table
        $query = "SELECT * FROM ".$table;
        $data = odbc_exec($this->conn, $query); 

        $rowData = array();
        while($row = odbc_fetch_array($data)) { 
          $rowData = $this->tis620_to_utf8_array($row);
          //Insert data from MSAccess to MySQL
          DB::table($table)->insert($rowData);
        } 
      }
    }
    
    public function drop() {

      $tables = DB::select('SHOW TABLES');
     
      foreach($tables as $table){
        Schema::dropIfExists($table->Tables_in_election_client);
        echo "Drop table : ".$table->Tables_in_election_client."<br>";
      }
      echo "<br>";
      echo "########Drop tables was finished. ##########<br>";
    }
    
    public function utf8_to_tis620($str){

      return iconv("UTF-8", "tis-620", $str);
    }
    
    public function tis620_to_utf8($str){
      
      return iconv("tis-620", "UTF-8", $str);
    }
    
    
    public function tis620_to_utf8_array($param) {

      foreach ($param as $key => $value) {
        if(is_string($value)){
          
          if(preg_match('/\\\\/',$value)){
            $param[$key] = addslashes($value);   
          }else{
            $param[$key] = $this->tis620_to_utf8($value);       
          }
        }
      }
      
      return $param;
    }

}
