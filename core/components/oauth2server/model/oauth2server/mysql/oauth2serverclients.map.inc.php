<?php
/**
 * @package oauth2server
 */
$xpdo_meta_map['OAuth2ServerClients']= array (
  'package' => 'oauth2server',
  'version' => '0.1',
  'table' => 'oauth2server_clients',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'client_id' => '',
    'client_secret' => NULL,
    'redirect_uri' => '',
    'grant_types' => NULL,
    'scope' => NULL,
    'user_id' => NULL,
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
    'client_secret' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '80',
      'phptype' => 'string',
    ),
    'redirect_uri' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '2000',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'grant_types' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '80',
      'phptype' => 'string',
    ),
    'scope' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
    ),
    'user_id' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '80',
      'phptype' => 'string',
    ),
  ),
);
