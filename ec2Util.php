<?php
      require 'vendor/autoload.php';
      use Aws\Ec2\Ec2Client;
      $ec2Client = new Aws\Ec2\Ec2Client([
          'region' => 'us-west-2',
          'version' => '2016-11-15',
          'profile' => 'default'
      ]);
      $result = $ec2Client->describeAddresses();
      var_dump($result);
 ?>
