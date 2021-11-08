<?php
       require 'vendor/autoload.php';
       require 'cred.php';

       use Aws\S3\S3Client;
       use Aws\Exception\AwsException;
       use Aws\S3\ObjectUploader;

       // $credentials = new Aws\Credentials\Credentials($access_key, $secret_key);

       $s3Client = new S3Client([
         'region' => $region,
         // 'credentials' => $credentials,
         'version' => '2006-03-01'
       ]);

?>
