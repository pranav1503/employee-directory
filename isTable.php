<?php
  require 'dynamoDBUtil.php';
  require 's3Util.php';
  $s3_config = include 's3_config.php';
  $tables = $dynamodb->listTables();
  $table_present = false;
  foreach ($tables['TableNames'] as $table) {
    //employee_directory
    if($table == "employee_directory"){
      $table_present = true;
    }
  }

  $isBucket = $s3Client->doesBucketExist($s3_config['bucket']);

 ?>
