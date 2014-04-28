<?php

$vendorDir = dirname(__DIR__);

return array (
  'yiisoft/yii2-bootstrap' => 
  array (
    'name' => 'yiisoft/yii2-bootstrap',
    'version' => '2.0.0.0-beta',
    'alias' => 
    array (
      '@yii/bootstrap' => $vendorDir . '/yiisoft/yii2-bootstrap',
    ),
  ),
  'yiisoft/yii2-gii' => 
  array (
    'name' => 'yiisoft/yii2-gii',
    'version' => '2.0.0.0-beta',
    'alias' => 
    array (
      '@yii/gii' => $vendorDir . '/yiisoft/yii2-gii',
    ),
  ),
  'yiisoft/yii2-debug' => 
  array (
    'name' => 'yiisoft/yii2-debug',
    'version' => '2.0.0.0-beta',
    'alias' => 
    array (
      '@yii/debug' => $vendorDir . '/yiisoft/yii2-debug',
    ),
  ),
  'yiisoft/yii2-codeception' => 
  array (
    'name' => 'yiisoft/yii2-codeception',
    'version' => '2.0.0.0-beta',
    'alias' => 
    array (
      '@yii/codeception' => $vendorDir . '/yiisoft/yii2-codeception',
    ),
  ),
  'yiisoft/yii2-swiftmailer' => 
  array (
    'name' => 'yiisoft/yii2-swiftmailer',
    'version' => '2.0.0.0-beta',
    'alias' => 
    array (
      '@yii/swiftmailer' => $vendorDir . '/yiisoft/yii2-swiftmailer',
    ),
  ),
  'yiisoft/yii2-authclient' => 
  array (
    'name' => 'yiisoft/yii2-authclient',
    'version' => '2.0.0.0-beta',
    'alias' => 
    array (
      '@yii/authclient' => $vendorDir . '/yiisoft/yii2-authclient',
    ),
  ),
  'kartik-v/yii2-widgets' => 
  array (
    'name' => 'kartik-v/yii2-widgets',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@kartik' => $vendorDir . '/kartik-v/yii2-widgets',
    ),
  ),
  'dektrium/yii2-user' => 
  array (
    'name' => 'dektrium/yii2-user',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@dektrium/user' => $vendorDir . '/dektrium/yii2-user',
    ),
    'bootstrap' => 'dektrium\\user\\Bootstrap',
  ),
);
