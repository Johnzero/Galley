<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A real_data table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By real_data there is only one group (the 'real_data' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'real_data';
$active_record = TRUE;

$db['real_data']['hostname'] = 'localhost';
$db['real_data']['username'] = 'root';
$db['real_data']['password'] = 'root';
$db['real_data']['database'] = 'galley';
$db['real_data']['dbdriver'] = 'mysql';
$db['real_data']['dbprefix'] = '';
$db['real_data']['pconnect'] = TRUE;
$db['real_data']['db_debug'] = TRUE;
$db['real_data']['cache_on'] = FALSE;
$db['real_data']['cachedir'] = '';
$db['real_data']['char_set'] = 'utf8';
$db['real_data']['dbcollat'] = 'utf8_general_ci';
$db['real_data']['swap_pre'] = '';
$db['real_data']['autoinit'] = TRUE;
$db['real_data']['stricton'] = FALSE;
$db['real_data']['table_pre'] = 'galley_';


/*
 * 自定义数据库信息 ，注意 $db['real_data']['autoinit']定义为false
 * */
/*----------------------------此项目所用到的------------------------*/

/*----------------------------此项目所用到的------------------------*/

/* End of file database.php */
/* Location: ./application/config/database.php */