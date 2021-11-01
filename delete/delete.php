<?php
    include '../dynamoDBUtil.php';
    $tableName = 'employee_directory';

    $id = $_GET['id'];

    $key = $marshaler->marshalJson('
      {
          "id": "' . $id . '"
      }
    ');


    $params = [
      'TableName' => $tableName,
      'Key' => $key,
    ];

    try {
      $result = $dynamodb->deleteItem($params);
      echo "<script>alert('Employee Deleted.');window.location.href = '../index.php';</script>";

    } catch (DynamoDbException $e) {
      echo "<script>alert('Employee Not Deleted.');window.location.href = '../index.php';</script>";
      // echo $e->getMessage() . "\n";
    }


 ?>
