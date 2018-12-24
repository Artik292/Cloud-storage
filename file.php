<?php

require 'connection.php';

use WindowsAzure\Common\ServicesBuilder;
 use WindowsAzure\Common\ServiceException;
 use MicrosoftAzure\Storage\Blob\BlobRestProxy;
 use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
 use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
 use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');

$app->add(['Button','Back','inverted blue','icon'=>'arrow alternate circle left'])->link(['index']);
$app->add(['ui'=>'hidden divider']);

$file = new File($db);
$file->load($_SESSION['File_id']);
$containerName = $file['ContainerName'];
$fileToUpload = $file['MetaName'];

//var_dump ($containerName);

$blob = $blobClient->getBlob($containerName, $fileToUpload);

$files = ($blobClient->listBlobs($containerName));
//$image = $files["0"]["_data:protected"]["url"];
$image = "https://artik292.blob.core.windows.net/".$containerName."/".$fileToUpload;

//$img = (fpassthru($blob->getContentStream()));
//$files = file_get_html($blob->getContentStream());
//fwrite($fileToUpload,$img);
//var_dump($files);
 if ($file['MetaIsImage']) {
   $app->add(['Image',$image]);
   $app->add(['ui'=>'hidden divider']);
 }

$DownloadFile = $app->add(['Button','Download '.$file['MetaName'],'icon'=>'cloud download','inverted green']);

$app->add(['ui'=>'hidden divider']);

$DeleteButton = $app->add(['Button','Delete ','red right ribbon','iconRight'=>'trash']);

$_SESSION['blobClient'] = $blobClient;
$_SESSION['containerName'] = $containerName;



$DeleteButton->link(['delete']);
//$file_name = 'file'.$file['MetaType'];
//file_put_contents($file_name,$img);


//$app->add(['Image',$file_name]);

//require 'file.html';

//var_dump($blob);

//$app->add(['Image',$img]);
