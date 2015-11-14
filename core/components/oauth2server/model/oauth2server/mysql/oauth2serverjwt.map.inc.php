<?php
/**
 * @package oauth2server
 */
$xpdo_meta_map['OAuth2ServerJwt']= array (
  'package' => 'oauth2server',
  'version' => '0.1',
  'table' => 'oauth2server_jwt',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'client_id' => '',
    'subject' => NULL,
    'public_key' => NULL,
  ),
  'fieldMeta' => 
  array (
    'client_id' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '80',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'pk',
    ),
    'subject' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '80',
      'phptype' => 'string',
    ),
    'public_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '2000',
      'phptype' => 'string',
    ),
  ),
);
