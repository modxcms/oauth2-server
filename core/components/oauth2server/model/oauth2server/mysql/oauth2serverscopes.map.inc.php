<?php
/**
 * @package oauth2server
 */
$xpdo_meta_map['OAuth2ServerScopes']= array (
  'package' => 'oauth2server',
  'version' => '0.1',
  'table' => 'oauth2server_scopes',
  'extends' => 'xPDOObject',
  'fields' => 
  array (
    'scope' => NULL,
    'is_default' => NULL,
  ),
  'fieldMeta' => 
  array (
    'scope' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
    ),
    'is_default' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
    ),
  ),
);
