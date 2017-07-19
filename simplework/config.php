<?php

// Application Directory
define('ADIR', 'simplework/');

// Assertive center apps directory
define('CADIR', 'center/');

// Working Directory
define('DIR_', PDIR.APDIR.ADIR);

// DIR_RELATIVE_PATH
define('DIR_APPLICATION', DIR_.'application/');
define('DIR_AUTHORIZATION', PDIR.APDIR.CADIR.'authorization/');
define('DIR_TRANSFER', DIR_.'transfer/');
define('DIR_UIM', DIR_.'uim/');
define('DIR_IMAGE', DIR_.'image/');
define('DIR_FILE', DIR_.'file/');
define('DIR_SYSTEM', DIR_.'system/');
define('DIR_LAYOUT', DIR_.'layout/');
define('DIR_LIBRARY', DIR_.'system/library/');
define('DIR_EXTLIB', DIR_.'system/extlib/');
define('DIR_CACHE', DIR_.'system/storage/cache/');
define('DIR_LOGS', DIR_.'system/storage/logs/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', '');
define('DB_PORT', '3306');
define('DB_PREFIX', '');

// Encryption
define('ENCRYPTION_HASH', '6d2d9f1ec2ec849e9dd3433213ffb509');

// Cache
define('CACHE_PREFIX', 'SW'); // For "Alternative PHP Cache" or Memcache driver
define('CACHE_HOSTNAME', ''); // for Memcache driver
define('CACHE_PORT', ''); // for Memcache driver