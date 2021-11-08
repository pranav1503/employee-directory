<?php
      // require 'vendor/autoload.php';
      // // require 'dynamoDBUtil.php';
      // use Aws\Ec2\Ec2Client;
      // require 'cred.php';
      //
      // $credentials = new Aws\Credentials\Credentials($access_key, $secret_key);
      //
      // $ec2Client = new Aws\Ec2\Ec2Client([
      //     'region' => 'us-west-2',
      //     'version' => '2016-11-15',
      //     'credentials' => $credentials
      // ]);

      echo "INSTANCE ID: " . @file_get_contents("http://instance-data/latest/meta-data/instance-id");
      echo "<br>";
      echo "AVAILABILITY ZONE: " . @file_get_contents("http://instance-data/latest/meta-data/placement/availability-zone");
 ?>
