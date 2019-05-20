<?php
session_start();

$place = $_SERVER['PHP_SELF'];
$place = explode('/',$place);

$session_is_not_set = (!(isset($_SESSION['user_id'])));
$page_not_login_php = (!(in_array('login.php' , $place)));
$page_not_auth_php = (!(in_array('auth.php' , $place)));

$answ_1 = ($page_not_login_php && $page_not_auth_php);
$answ_2 = ($session_is_not_set && $answ_1);

if ($answ_2) {
  header('Location: login.php');
}

date_default_timezone_set('UTC');

require '../vendor/autoload.php';


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
	public $table = 'file';
function init() {
	parent::init();
  $this->addField('ContainerName',['caption'=>'Container name']);
  $this->addField('MetaName',['caption'=>'Meta file name']);
  $this->addField('MetaType',['caption'=>'Meta file type']);
  $this->addField('DateCreated',['type'=>'datetime']);
  $this->addField('MetaSize',['caption'=>'Meta file size']);
  $this->addField('MetaIsImage',['type'=>'boolean','caption'=>'Meta file is image']);
  $this->addField('Link');
  $this->addField('Icon');
  $this->hasOne('folder_id', new Folder())->addTitle();
}
}

class Folder extends \atk4\data\Model {
	public $table = 'folder';
function init() {
	parent::init();
  $this->addField('name',['caption'=>'Name']);
  $this->addField('Image');
  $this->addField('DateCreated',['caption'=>'Created']);
  $this->addField('DateModify',['caption'=>'Modified']);
  $this->addField('Amount',['caption'=>'Amout of files']);
  $this->addField('Is_SubFolder',['type'=>'boolean']);
  $this->hasMany('File', new File);
  $this->hasMany('SubFolder', new SubFolder);
  $this->hasOne('account_id',new Account())->addTitle();
}
}

class Account extends \atk4\data\Model {
	public $table = 'account';
function init() {
	parent::init();
  $this->addField('Email',['caption'=>'E-mail']);
  $this->addField('name',['caption'=>'Nick name']);
  $this->addField('Password',['caption'=>'Password']);
  $this->addField('admin_access',['caption'=>'Is Admin','type'=>'boolean','default'=>FALSE]);
  $this->hasMany('Folder', new Folder);
}
}

class SubFolder extends \atk4\data\Model {
	public $table = 'in_folder';
function init() {
	parent::init();
  $this->addField('child_folder_id');
  $this->hasOne('folder_id',new Folder()) ;
}
}
