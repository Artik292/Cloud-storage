<?php

require 'connection.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');

$app->add(['Button','Back','inverted blue','icon'=>'arrow alternate circle left'])->link(['index']);
$app->add(['ui'=>'hidden divider']);

$file = new File($db);
$file->load($_SESSION['File_id']);

$blob = $blobClient->getBlob($file['ContainerName'], $file['MetaName']);

$files = ($blobClient->listBlobs($file['ContainerName']));
//$image = $files["0"]["_data:protected"]["url"];
$image = "https://artik292.blob.core.windows.net/".$file['ContainerName']."/".$file['MetaName'];

 if ($file['MetaIsImage']) {
   $app->add(['Image',$image]);
   $app->add(['ui'=>'hidden divider']);
 }

$DownloadFile = $app->add(['Button','Download '.$file['MetaName'],'icon'=>'cloud download','inverted green'])
    ->link($image);

$app->add(['ui'=>'hidden divider']);

$DeleteButton = $app->add(['Button','Delete ','red right ribbon','iconRight'=>'trash']);

$_SESSION['blobClient'] = $blobClient;
$_SESSION['containerName'] = $file['ContainerName'];

$DeleteButton->link(['delete']);
