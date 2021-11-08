<?php
       require 'vendor/autoload.php';
       require 'cred.php';

       use Aws\DynamoDb\Exception\DynamoDbException;
       use Aws\DynamoDb\Marshaler;

       // $credentials = new Aws\Credentials\Credentials($access_key, $secret_key);

       $sdk = new Aws\Sdk([
        'version'     => 'latest',
        'region'      => $region,
        // 'credentials' => $credentials,
        ]);

        $dynamodb = $sdk->createDynamoDb();
        $marshaler = new Marshaler();
?>
