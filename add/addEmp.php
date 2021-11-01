<?php
    require '../dynamoDBUtil.php';
    require '../s3Util.php';
    require '../util/util.php';
    $s3_config = include('../s3_config.php');
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $emailID = $_POST['emailID'];
    $id = createID($emailID);
    $photo = "";
    $is_photo = array_key_exists('photo', $_FILES);

    if($is_photo){
      $file = $_FILES['photo'];
      // File Name
      $p_name = $file['name'];
      $tmp_name = $file['tmp_name'];

      // Get Extension
      $extension = explode('.', $p_name);
      $extension = strtolower(end($extension));

      // Temp Details
      $temp_file_name = "{$id}.{$extension}";
      $temp_file_path = "../tmp/{$temp_file_name}";

      // Move the file
      move_uploaded_file($tmp_name, $temp_file_path);

      $bucket = $s3_config['bucket'];
      $key = "photos/{$temp_file_name}";
      try {
        $result = $s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'SourceFile' => $temp_file_path,
        ]);
      } catch (S3Exception $e) {
        echo $e->getMessage() . "\n";
      }
      // remove files
      unlink($temp_file_path);
      $photo = $temp_file_name;
    }


    $tableName = 'employee_directory';

    $item = $marshaler->marshalJson('
        {
            "id": "'. $id .'",
            "name": "' . $name . '",
            "designation": "' . $designation . '",
            "email": "'. $emailID .'",
            "photo": "'.$photo.'"
        }
    ');

    $params = [
        'TableName' => $tableName,
        'Item' => $item
    ];


    try {
        $result = $dynamodb->putItem($params);
        $status  = array('status' => 'success', 'id' => $id);
        echo json_encode($status);

    } catch (DynamoDbException $e) {
        $status  = array('status' => 'error', 'message' => $e->getMessage());
        echo json_encode($status);
    }

 ?>
