<?php
// show errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';

// Ejemplo1
/*
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);
*/

// Creating a DynamoDb client will use the "eu-central-1" region.
// $client = $sdk->createDynamoDb();

// Ejemplo2
$assumeRoleCredentials = new AssumeRoleCredentialProvider([
    'client' => new StsClient([
        'region' => 'us-west-2',
        'version' => '2011-06-15'
    ]),
    'assume_role_params' => [
        'RoleArn' => '<string>', // REQUIRED
        'RoleSessionName' => '<string>', // REQUIRED
    ]
]);

$sdk = new Aws\Sdk([
    'region'   => 'us-west-2',
    'version'  => 'latest',
    'DynamoDb' => [
        'region' => 'eu-central-1'
    ]
]);

// Use an Aws\Sdk class to create the S3Client object.
$s3Client = $sdk->createS3();

// Send a PutObject request and get the result object.
$result = $s3Client->putObject([
    'Bucket' => 'my-bucket',
    'Key'    => 'my-key',
    'Body'   => 'this is the body!'
]);

// Download the contents of the object.
$result = $s3Client->getObject([
    'Bucket' => 'my-bucket',
    'Key'    => 'my-key'
]);

// Print the body of the result by indexing into the result object.
echo $result['Body'];
?>