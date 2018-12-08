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

$file = new File($db);
$file->load($_SESSION['File_id']);
$containerName = $file['ContainerName'];
$fileToUpload = $file['MetaName'];

$blob = $blobClient->getBlob($containerName, $fileToUpload);

$files = ($blobClient->listBlobs($containerName));
//$image = $files["0"]["_data:protected"]["url"];
$image = "https://artik292.blob.core.windows.net/".$containerName."/".$fileToUpload;

//$img = (fpassthru($blob->getContentStream()));
//$files = file_get_html($blob->getContentStream());
//fwrite($fileToUpload,$img);
//var_dump($files);
$app->add(['Image',$image]);

//$file_name = 'file'.$file['MetaType'];
//file_put_contents($file_name,$img);


//$app->add(['Image',$file_name]);

//require 'file.html';

//var_dump($blob);

//$app->add(['Image',$img]);
