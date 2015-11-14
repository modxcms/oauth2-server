<?php
/**
 * @package oauth2server
 */
$xpdo_meta_map['OAuth2ServerAccessTokens']= array (
  'package' => 'oauth2server',
  'version' => '0.1',
  'table' => 'oauth2server_access_tokens',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'access_token' => '',
    'client_id' => '',
    'user_id' => NULL,
    'expires' => 'CURRENT_TIMESTAMP',
    'scope' => NULL,
  ),
  'fieldMeta' => 
  array (
    'access_token' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '40',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'pk',
    ),
    'client_id' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '80',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'user_id' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
    ),
    'expires' => 
    array (
      'dbtype' => 'timestamp',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 'CURRENT_TIMESTAMP',
      'attributes' => 'ON UPDATE CURRENT_TIMESTAMP',
    ),
    'scope' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '2000',
      'phptype' => 'string',
    ),
  ),
);
