<?php

require 'admin_connection.php';

$app = new \atk4\ui\App('My Filestore Demo alfa(0.0.3)');
$app->initLayout('Admin');

require 'layout.php';

$basic_info = new Basic_info($db);
$basic_info->load(1);

$amount_of_users = $app->add(['View', 'template' => new \atk4\ui\Template('<div id="{$_id}" class="ui statistic">
    <div class="label">
      Amount of users:
    </div>
    <div class="value">
      <i class="users icon"></i> {$num}
    </div>
  </div>')]);
$amount_of_users->template->set('num', $basic_info['amount_of_users']);


$total_memory_in_use = $app->add(['View', 'template' => new \atk4\ui\Template('<div id="{$_id}" class="ui statistic">
    <div class="label">
      Total memory in use:
    </div>
    <div class="value">
       {$memory} {$letter}
    </div>
  </div>')]);

  $memory = $basic_info['total_memory_in_use'];
  $memory_letter = 'B';
if (($memory/1024) > 1){
    $memory = $memory/1024;
    $memory_letter = 'KB';
}

if (($memory/1024) > 1){
    $memory = $memory/1024;
    $memory_letter = 'MB';
}

if (($memory/1024) > 1){
    $memory = $memory/1024;
    $memory_letter = 'GB';
}

if (($memory/1024) > 1){
    $memory = $memory/1024;
    $memory_letter = 'TB';
}

$memory = round($memory);

$total_memory_in_use->template->set('memory', $memory);
$total_memory_in_use->template->set('letter', $memory_letter);


$amount_of_visitors = $app->add(['View', 'template' => new \atk4\ui\Template('<div id="{$_id}" class="ui statistic">
    <div class="label">
      Amount of visitors:
    </div>
    <div class="value">
       <i class="eye icon"></i> {$num}
    </div>
  </div>')]);
$amount_of_visitors->template->set('num', $basic_info['amount_of_visitors']);
