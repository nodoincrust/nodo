<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* PLEASE NOTE: Alex Bilbe (http://www.alexbilbie.com) has merged this fork of his original code back into his own. http://bitbucket.org/alexbilbie/codeigniter-mongo-library/wiki/Home
*/

/*
| -------------------------------------------------------------------
| MONGODB CONFIGURATION
| -------------------------------------------------------------------
| This file will contain the settings needed to access your MongoDB.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['mongo_hostbase'] The hostname of your mongodb server
|	['mongo_port'] The port number of your mongodb server
|	['mongo_database'] The database you want to work on
|	['mongo_username'] The username used to connect to the database
|	['mongo_password'] The password used to connect to the database
|	['mongo_persist'] TRUE/FALSE Persistant connection
|	['mongo_persist_key'] The persistant connection key
|
*/

$config['default']['mongo_hostbase'] = 'localhost';
$config['default']['mongo_port'] = '27017';
$config['default']['mongo_database'] = 'dmstest';
$config['default']['mongo_username'] = '';
$config['default']['mongo_password'] = '';
$config['default']['mongo_persist'] = TRUE;
$config['default']['mongo_persist_key'] = 'ci_mongo_persist';
$config['default']['mongo_query_safety'] = 'safe';
$config['default']['mongo_suppress_connect_error'] = FALSE;
$config['default']['mongo_host_db_flag'] = TRUE;

?>