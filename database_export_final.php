<?php
use Illuminate\Support\Facades\DB;
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$databaseName = config('database.connections.mysql.database');
$tables = DB::select('SHOW TABLES');
$key = 'Tables_in_' . $databaseName;

$sql = "-- Match Backend Database Dump (Updated)\n";
$sql .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

foreach ($tables as $table) {
    $tableName = $table->$key;
    $sql .= "-- Table `$tableName` --\n";
    $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
    $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0]->{'Create Table'};
    $sql .= $createTable . ";\n\n";
    
    $rows = DB::table($tableName)->get();
    foreach ($rows as $row) {
        $rowArray = (array) $row;
        $columns = array_keys($rowArray);
        $escapedValues = array_map(function($value) {
            if ($value === null) return 'NULL';
            return DB::getPdo()->quote($value);
        }, array_values($rowArray));
        $sql .= "INSERT INTO `$tableName` (`" . implode("`, `", $columns) . "`) VALUES (" . implode(", ", $escapedValues) . ");\n";
    }
    $sql .= "\n";
}
$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
file_put_contents('match_database_final.sql', $sql);
echo "Final database dump created: match_database_final.sql\n";
