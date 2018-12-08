<?php
session_start();

require 'vendor/autoload.php';
/*
require 'random_string.php';
require 'myupload.php';



use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=artik292;AccountKey=+9Pmt9DxE4IwWGdrm47AXaP7ddV/ZPrryCylGScm9afqaS7OZzhDuYokWUy7KeuPgE4+NlT2Qnry1FYqYlRdIQ==";

$blobClient = BlobRestProxy::createBlobService($connectionString);

if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
     $db = \atk4\data\Persistence::connect($_ENV['CLEARDB_DATABASE_URL']);
 } else {
     $db = \atk4\data\Persistence::connect('mysql:host=127.0.0.1;dbname=azure;charset=utf8', 'root', '');
 }

class File extends \atk4\data\Model {
	public $table = 'files';
function init() {
	parent::init();
  $this->addField('ContainerName',['caption'=>'Container name']);
  $this->addField('MetaName',['caption'=>'Meta file name']);
  $this->addField('MetaType',['caption'=>'Meta file type']);
  $this->addField('MetaSize',['caption'=>'Meta file size']);
  $this->addField('MetaIsImage',['type'=>'boolean','caption'=>'Meta file is image']);
}
}
*/
