<?php
/**
 * @package oauth2server
 */
$xpdo_meta_map['OAuth2ServerAuthorizationCodes']= array (
  'package' => 'oauth2server',
  'version' => '0.1',
  'table' => 'oauth2server_authorization_codes',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'authorization_code' => '',
    'client_id' => '',
    'redirect_uri' => NULL,
    'expires' => 0,
    'scope' => NULL,
    'user_id' => NULL,
  ),
  'fieldMeta' => 
  array (
    'authorization_code' => 
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
    'redirect_uri' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '2000',
      'phptype' => 'string',
    ),
    'expires' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
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
