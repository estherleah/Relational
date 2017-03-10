<?php

include_once '../database/database.php';
session_start();
$user = $_SESSION['user'];
$name = $_SESSION['name'];

if (!isset($_POST['name']) or trim($_POST['name']) == '') {
    echo "Please enter some text.";
    header("Location: ../photo.php");
}
else {
    $photoCollectionName = $_POST["name"];
    $date = date("Y-m-d H:i:s");
    $privacyID = 1; //temporary

    $userIdEscaped = mysqli_real_escape_string($conn, $user);
    $photoCollectionNameEscaped = mysqli_real_escape_string($conn, $photoCollectionName);
    $dateEscaped = mysqli_real_escape_string($conn, $date);

    $photoCollectionInsertSql = "INSERT INTO photo_collection (userID, name, privacyID, date)
                    VALUES ('$userIdEscaped', '$photoCollectionNameEscaped', '$privacyID', '$dateEscaped')";

    if (mysqli_query($conn, $photoCollectionInsertSql)) {
        echo "New photo collection created successfully";
    } else {
        echo "Error: " . $photoCollectionInsertSql . "<br>" . mysqli_error($conn);
    }
}

// Adapted from https://docs.microsoft.com/en-us/azure/storage/storage-php-how-to-use-blobs
/*
require_once 'vendor/autoload.php';
use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Common\ServiceException;

$userIDEscaped = mysqli_real_escape_string($conn, $user);

$connectionString = "DefaultEndpointsProtocol=[http|https];AccountName=[yourAccount];AccountKey=[yourKey]";

// Create blob REST proxy.
$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);


// OPTIONAL: Set public access policy and metadata.
// Create container options object.
$createContainerOptions = new CreateContainerOptions();

// Set public access policy. Possible values are
// PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
// CONTAINER_AND_BLOBS:
// Specifies full public read access for container and blob data.
// proxys can enumerate blobs within the container via anonymous
// request, but cannot enumerate containers within the storage account.
//
// BLOBS_ONLY:
// Specifies public read access for blobs. Blob data within this
// container can be read via anonymous request, but container data is not
// available. proxys cannot enumerate blobs within the container via
// anonymous request.
// If this value is not specified in the request, container data is
// private to the account owner.
$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

try    {
    // Create container.
    $containerName = $collectionName + "-" + $userIDEscaped;
    $blobRestProxy->createContainer($containerName, $createContainerOptions);
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
*/


 ?>
