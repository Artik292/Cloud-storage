<?php

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$vir = $app->add('VirtualPage');
$vir->set(function($vir) use ($model,$blobClient,$app,$db,$file_types) {

  $form = $vir->add('Form');
  $field = $form->addField('file', ['MyUpload']);

  //$field = $form->addField('file', ['MyUpload', ['accept' => ['.png', '.jpg']]]);

  /**
    ON DELETE
  **/

  $field->onDelete(function ($fileId) use ($blobClient){
    try{
          // Delete container.
          $blobClient->deleteContainer($_SESSION["containerName"]);
      }
      catch(ServiceException $e){
          $code = $e->getCode();
          $error_message = $e->getMessage();
          new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
      }
      return new atk4\ui\jsNotify(['content' => $_SESSION['name_file'].' has been removed!', 'color' => 'green']);
  });

/**
  ON UPLOAD
**/

  $field->onUpload(function ($id) use ($blobClient) {


      $fileToUpload = $_SESSION['tmp_file'];

      $createContainerOptions = new CreateContainerOptions();

      $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

      $createContainerOptions->addMetaData("key1", "value1");
      $createContainerOptions->addMetaData("key2", "value2");

        $containerName = "blockblobs".generateRandomString();
        $_SESSION['containerName'] = $containerName;

      try {
          // Create container.
          $blobClient->createContainer($containerName, $createContainerOptions);

          // Getting local file so that we can upload it to Azure
          $myfile = fopen($fileToUpload, "r") or die("Unable to open file!");
          fclose($myfile);

          $content = fopen($fileToUpload, "r");

          //Upload blob
          $blobClient->createBlockBlob($containerName, $_SESSION['name_file'], $content);  ///FIIIIIX file name

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

  /**
    ON SUBMIT
  **/

  $form->onSubmit(function ($form) use($db,$file_types) {

      $file = new File($db);
      $file['ContainerName'] = $_SESSION["containerName"];
      $file['MetaName'] = $_SESSION['name_file'];
      //$file['MetaType'] = substr($_SESSION['type_file'],(strpos($_SESSION['type_file'],'/'))+1);
      //$file['MetaType'] = substr($_SESSION['name_file'], strpos($_SESSION['name_file'], ".",-1) + 1);

      $file_name = $_SESSION['name_file'];
      $last_dot_position_number = strrpos($_SESSION['name_file'], ".");  // FOR EASY UNDERSTANDING
      $last_dot_position_number++;
      $file['MetaType'] = substr($file_name, $last_dot_position_number);

      date_default_timezone_set('Europe/Riga');
      $date = new DateTime(date_default_timezone_get());
      $file['DateCreated'] = $date->format('Y-m-d H:i:s');
      $file['MetaSize'] = $_SESSION['size_file'];
      $file['Link'] = "https://artik292.blob.core.windows.net/".$_SESSION["containerName"]."/".$_SESSION['name_file'];
      /*if (in_array($file['MetaType'],$file_types)) {
          $file['MetaIsImage'] = TRUE;
      } else {
          $file['MetaIsImage'] = FALSE;
      }*/
      if (isset($file_types[$file['MetaType']])) {
          if ($file_types[$file['MetaType']] == "img") {
            $file['MetaIsImage'] = TRUE;
            $file['Icon'] = $file['Link'];
          } else {
            $file['MetaIsImage'] = FALSE;
            $file['Icon'] = $file_types[$file['MetaType']];
          }
      } else {
          $file['MetaIsImage'] = FALSE;
          $file['Icon'] = "src/no_image.png";
      }
      $file['folder_id'] = $_SESSION['folder_id'];
      $file->save();
      $user_id = $_SESSION['user_id'];
      $folder_id = $_SESSION['folder_id'];
      session_unset();
      $_SESSION['user_id'] = $user_id;
      $_SESSION['folder_id'] = $folder_id;
      return new \atk4\ui\jsExpression('document.location="file.php"');
  });


});
