<?php


require 'connection.php';


use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


$app = new \atk4\ui\App('My Filestore Demo');
$app->initLayout('Centered');

//$form = $app->add('Form');
//$field = $form->addField('file', ['MyUpload', ['accept' => ['.png', '.jpg']]]);

$app->add(['CRUD'])->setModel(new File($db));

/*
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
        //echo $code.": ".$error_message."<br />";
        new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        //echo $code.": ".$error_message."<br />";
        new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
    }


  return new atk4\ui\jsNotify(['content' => 'File is uploaded!', 'color' => 'green']);
});

$field->onDelete(function ($fileId) use ($blobClient){



  try{
        // Delete container.
        $blobClient->deleteContainer($_SESSION["containerName"]);
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        new atk4\ui\jsNotify(['content' => $code.": ".$error_message, 'color' => 'red']);
    }


    return new atk4\ui\jsNotify(['content' => $_SESSION['name_file'].' has been removed!', 'color' => 'green']);
});


$form->onSubmit(function ($form) use($db) {

    $file = new File($db);
    $file['ContainerName'] = $_SESSION["containerName"];
    $file['MetaName'] = $_SESSION['name_file'];
    $file['MetaType'] = substr($_SESSION['type_file'],(strpos($_SESSION['type_file'],'/'))+1);
    $file['MetaSize'] = $_SESSION['size_file'];
    $file['MetaIsImage'] = TRUE; ///////////FIIIIIIX IIIIIIITTTTT!!!!!!
    $file->save();

    return new \atk4\ui\jsExpression('document.location="index.php"');
});

*/
