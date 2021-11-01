<?php
    require 'dynamoDBUtil.php';
    $params = [
    'TableName' => 'employee_directory',
    'KeySchema' => [
        [
            'AttributeName' => 'id',
            'KeyType' => 'HASH'
        ],
    ],
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'id',
            'AttributeType' => 'S'
        ],

    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 10,
        'WriteCapacityUnits' => 10
    ]
];

try {
    $result = $dynamodb->createTable($params);
    echo "success";

} catch (DynamoDbException $e) {
    echo "failed";
    // echo $e->getMessage() . "\n";
}

 ?>
