<?php

require 'connection.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$app = new \atk4\ui\App('Main Page');
$app->initLayout('Centered');

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(8);
$col_2 = $columns->addColumn(8);

$folder = new Folder($db);
$folder->load($_SESSION['folder_id']);

$ContainerName = $folder['ContainerName'];

$files = $folder->ref('File');

$col_1->add(['Button','Back','inverted blue','icon'=>'arrow alternate circle left'])->link(['index']);
$col_1->add(['ui'=>'hidden divider']);


/**

 ADD BUTTON

**/


$add_file_button = $col_2->add(['Button','Add file','inverted green','icon'=>'plus'])->link(['index']);

$model = new File($db);


$vir = $app->add('VirtualPage');
$vir->set(function($vir) use ($model,$blobClient,$app,$ContainerName) {

  $form = $vir->add('Form');
  $field = $form->addField('file', ['MyUpload', ['accept' => ['.png', '.jpg']]]);

  $model->addHook('beforeDelete', function($model) use ($blobClient,$ContainerName) {
      $id = $model->id;
      $model->load($id);
      try{
            $blobClient->deleteContainer($model["ContainerName"]);
        }
        catch(ServiceException $e){
            $code = $e->getCode();
            $error_message = $e->getMessage();
            new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
        }
        return new atk4\ui\jsNotify(['content' => $model['MetaName'].' has been removed!', 'color' => 'green']);

      });

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      $field->onUpload(function ($id) use ($blobClient,$ContainerName) {

          $fileToUpload = $_SESSION['tmp_file'];

        /*  $createContainerOptions = new CreateContainerOptions();

          $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

          $createContainerOptions->addMetaData("key1", "value1");
          $createContainerOptions->addMetaData("key2", "value2");

            $containerName = "blockblobs".generateRandomString();
            $_SESSION['containerName'] = $containerName;*/

          try {
              // Create container.
              //$blobClient->createContainer($containerName, $createContainerOptions);

              // Getting local file so that we can upload it to Azure
              $myfile = fopen($fileToUpload, "r") or die("Unable to open file!");
              fclose($myfile);

              $content = fopen($fileToUpload, "r");

              //Upload blob
              $blobClient->putBlock($ContainerName, $_SESSION['name_file'], $content);  ///FIIIIIX file name

              // List blobs.
              $listBlobsOptions = new ListBlobsOptions();
              $listBlobsOptions->setPrefix("HelloWorld");

              do{
                  $result = $blobClient->listBlobs($containerName, $listBlobsOptions);

                  $listBlobsOptions->setContinuationToken($result->getContinuationToken());
              } while($result->getContinuationToken());
          }
          catch(ServiceException $e){
              // Handle exception based on error codes and messages.
              // Error codes and messages are here:
              // http://msdn.microsoft.com/library/azure/dd179439.aspx
              $code = $e->getCode();
              $error_message = $e->getMessage();
              new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
          }
          catch(InvalidArgumentTypeException $e){
              // Handle exception based on error codes and messages.
              // Error codes and messages are here:
              // http://msdn.microsoft.com/library/azure/dd179439.aspx
              $code = $e->getCode();
              $error_message = $e->getMessage();
              new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
          }

        return new atk4\ui\jsNotify(['content' => 'File is uploaded!', 'color' => 'green']);
      });

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      $field->onDelete(function ($fileId) use ($blobClient,$ContainerName){



        try{
              // Delete blob.
              $blobClient->deleteBlob($_SESSION["MetaName"]);
          }
          catch(ServiceException $e){
              $code = $e->getCode();
              $error_message = $e->getMessage();
              new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
          }
          return new atk4\ui\jsNotify(['content' => $_SESSION['name_file'].' has been removed!', 'color' => 'green']);
      });


});

$add_file_button->on('click', new \atk4\ui\jsModal('New File',$vir));

$col_2->add(['ui'=>'hidden divider']);

/**

  DECOR

**/

$columns = $app->add('Columns');

$col_1 = $columns->addColumn(4);
$col_2 = $columns->addColumn(4);
$col_3 = $columns->addColumn(4);
$col_4 = $columns->addColumn(4);

$i = 1;

foreach ($files as $file) {
    $file_image = "https://artik292.blob.core.windows.net/".$folder['ContainerName']."/".$file['MetaName'] ?? 'no_image.png';

    $link = '"re.php?mn='.$id.'"';
    $link = 'document.location='.$link;

    switch ($i) {
        case 1:
              $col_1->add(['Image',$file_image,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $i++;
              break;
        case 2:
              $col_2->add(['Image',$file_image,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $i++;
              break;
        case 3:
              $col_3->add(['Image',$file_image,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $i++;
              break;
        case 4:
              $col_4->add(['Image',$file_image,'big'])->on('click', new \atk4\ui\jsExpression($link));
              $i=1;
              $col_1->add(['ui'=>'hidden divider']);
              $col_2->add(['ui'=>'hidden divider']);
              $col_3->add(['ui'=>'hidden divider']);
              $col_4->add(['ui'=>'hidden divider']);
              break;
}
}



/*$blob = $blobClient->getBlob($file['ContainerName'], $file['MetaName']);

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

$DeleteButton->link(['delete']);*/
