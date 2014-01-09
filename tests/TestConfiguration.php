<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   UnitTests
 */

/**
 * This file defines configuration for running the unit tests for the Zend
 * Framework. Some tests have dependencies to PHP extensions or databases
 * which may not necessary installed on the target system. For these cases,
 * the ability to disable or configure testing is provided below. Tests for
 * components which should run universally are always run by the master
 * suite and cannot be disabled.
 *
 * Do not edit this file. Instead, copy this file to TestConfiguration.php,
 * and edit the new file. Never commit  passwords to the source code repository.
 */

/**
 * Use the notation:
 *
 *  defined(...) || define(...);
 *
 * This ensures that, when a test is marked to run in a separate process,
 * PHP will not complain of a constant already being defined.
 */

/**
 * GENERAL SETTINGS
 *
 * OB_ENABLED should be enabled for some tests to check if all functionality
 * works as expected. Such tests include those for Zend\Soap and Zend\Session,
 * which require that headers not be sent in order to work.
 */
defined('TESTS_ZEND_OB_ENABLED') || define('TESTS_ZEND_OB_ENABLED', false);

/**
 * Zend\Auth\Adapter\DbTable tests
 */
defined('TESTS_ZEND_AUTH_ADAPTER_DBTABLE_PDO_SQLITE_ENABLED') || define('TESTS_ZEND_AUTH_ADAPTER_DBTABLE_PDO_SQLITE_ENABLED', false);
defined('TESTS_ZEND_AUTH_ADAPTER_DBTABLE_PDO_SQLITE_DATABASE') || define('TESTS_ZEND_AUTH_ADAPTER_DBTABLE_PDO_SQLITE_DATABASE', ':memory:');

/**
 * Zend\Auth\Adapter\Ldap online tests
 * (See also TESTS_ZEND_LDAP_* configuration constants below)
 */
defined('TESTS_ZEND_AUTH_ADAPTER_LDAP_ONLINE_ENABLED') || define('TESTS_ZEND_AUTH_ADAPTER_LDAP_ONLINE_ENABLED', false);


/**
 * Zend\Barcode\Renderer\Pdf
 *
 * Enable this if you have installed ZendPdf on the include_path or via
 * Composer.
 */
defined('TESTS_ZEND_BARCODE_PDF_SUPPORT') || define('TESTS_ZEND_BARCODE_PDF_SUPPORT', false);


/**
 * Zend\Cache\Storage\Adapter
 */
defined('TESTS_ZEND_CACHE_APC_ENABLED') || define('TESTS_ZEND_CACHE_APC_ENABLED', false);
defined('TESTS_ZEND_CACHE_SQLITE_ENABLED') || define('TESTS_ZEND_CACHE_SQLITE_ENABLED', false);
defined('TESTS_ZEND_CACHE_XCACHE_ENABLED') || define('TESTS_ZEND_CACHE_XCACHE_ENABLED', false);
defined('TESTS_ZEND_CACHE_XCACHE_ADMIN_AUTH') || define('TESTS_ZEND_CACHE_XCACHE_ADMIN_AUTH', false);
defined('TESTS_ZEND_CACHE_XCACHE_ADMIN_USER') || define('TESTS_ZEND_CACHE_XCACHE_ADMIN_USER', '');
defined('TESTS_ZEND_CACHE_XCACHE_ADMIN_PASS') || define('TESTS_ZEND_CACHE_XCACHE_ADMIN_PASS', '');
defined('TESTS_ZEND_CACHE_PLATFORM_ENABLED') || define('TESTS_ZEND_CACHE_PLATFORM_ENABLED', false);
defined('TESTS_ZEND_CACHE_WINCACHE_ENABLED') || define('TESTS_ZEND_CACHE_WINCACHE_ENABLED', false);
defined('TESTS_ZEND_CACHE_ZEND_SERVER_ENABLED') || define('TESTS_ZEND_CACHE_ZEND_SERVER_ENABLED', false);
defined('TESTS_ZEND_CACHE_MEMCACHED_ENABLED') || define('TESTS_ZEND_CACHE_MEMCACHED_ENABLED', false);
defined('TESTS_ZEND_CACHE_MEMCACHED_HOST') || define('TESTS_ZEND_CACHE_MEMCACHED_HOST', '127.0.0.1');
defined('TESTS_ZEND_CACHE_MEMCACHED_PORT') || define('TESTS_ZEND_CACHE_MEMCACHED_PORT', 11211);
defined('TESTS_ZEND_CACHE_REDIS_ENABLED') || define('TESTS_ZEND_CACHE_REDIS_ENABLED', false);
defined('TESTS_ZEND_CACHE_REDIS_HOST') || define('TESTS_ZEND_CACHE_REDIS_HOST', '127.0.0.1');
defined('TESTS_ZEND_CACHE_REDIS_PORT') || define('TESTS_ZEND_CACHE_REDIS_PORT', 6379);
defined('TESTS_ZEND_CACHE_REDIS_PASSWORD') || define('TESTS_ZEND_CACHE_REDIS_PASSWORD', '');
defined('TESTS_ZEND_CACHE_REDIS_DATABASE') || define('TESTS_ZEND_CACHE_REDIS_DATABASE', 0);


/**
 * Zend\Captcha
 *
 * Enable this if you have installed ZendService\ReCaptcha on the include_path or via
 * Composer.
 */
defined('TESTS_ZEND_CAPTCHA_RECAPTCHA_SUPPORT') || define('TESTS_ZEND_CAPTCHA_RECAPTCHA_SUPPORT', false);

/**
 * Enable this to test GC operations. These often fail in parallel build environments.
 */
defined('TESTS_ZEND_CAPTCHA_GC') || define('TESTS_ZEND_CAPTCHA_GC', false);


/**
 * Zend\Code\Annotation
 *
 * Enable this if you have installed Doctrine\Common on the include_path or via
 * Composer.
 */
defined('TESTS_ZEND_CODE_ANNOTATION_DOCTRINE_SUPPORT') || define('TESTS_ZEND_CODE_ANNOTATION_DOCTRINE_SUPPORT', false);

/**
 * Zend\Config
 */
defined('TESTS_ZEND_CONFIG_YAML_ENABLED') || define('TESTS_ZEND_CONFIG_YAML_ENABLED', false);
defined('TESTS_ZEND_CONFIG_YAML_LIB_INCLUDE') || define('TESTS_ZEND_CONFIG_YAML_LIB_INCLUDE', ''); // path to YAML library or empty for YAML PECL extension
defined('TESTS_ZEND_CONFIG_WRITER_YAML_CALLBACK') || define('TESTS_ZEND_CONFIG_WRITER_YAML_CALLBACK', '');
defined('TESTS_ZEND_CONFIG_READER_YAML_CALLBACK') || define('TESTS_ZEND_CONFIG_READER_YAML_CALLBACK', '');

/**
 * Zend\Crypt related constants
 *
 * TESTS_ZEND_CRYPT_OPENSSL_CONF => location of an openssl.cnf file for use
 *     with RSA encryption
 */
defined('TESTS_ZEND_CRYPT_OPENSSL_CONF') || define('TESTS_ZEND_CRYPT_OPENSSL_CONF', false);

/**
 * Zend\Db\Adapter\Pdo\Mysql and Zend\Db\Adapter\Mysqli
 *
 * There are separate properties to enable tests for the PDO_MYSQL adapter and
 * the native Mysqli adapters, but the other properties are shared between the
 * two MySQL-related Zend\Db adapters.
 */
defined('TESTS_ZEND_DB_ADAPTER_PDO_MYSQL_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_PDO_MYSQL_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_MYSQLI_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_MYSQLI_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_MYSQL_HOSTNAME') || define('TESTS_ZEND_DB_ADAPTER_MYSQL_HOSTNAME', '127.0.0.1');
defined('TESTS_ZEND_DB_ADAPTER_MYSQL_USERNAME') || define('TESTS_ZEND_DB_ADAPTER_MYSQL_USERNAME', null);
defined('TESTS_ZEND_DB_ADAPTER_MYSQL_PASSWORD') || define('TESTS_ZEND_DB_ADAPTER_MYSQL_PASSWORD', null);
defined('TESTS_ZEND_DB_ADAPTER_MYSQL_DATABASE') || define('TESTS_ZEND_DB_ADAPTER_MYSQL_DATABASE', 'test');
defined('TESTS_ZEND_DB_ADAPTER_MYSQL_PORT') || define('TESTS_ZEND_DB_ADAPTER_MYSQL_PORT', 3306);

/**
 * Zend\Db\Adapter\Pdo\Sqlite
 *
 * Username and password are irrelevant for SQLite.
 */
defined('TESTS_ZEND_DB_ADAPTER_PDO_SQLITE_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_PDO_SQLITE_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_PDO_SQLITE_DATABASE') || define('TESTS_ZEND_DB_ADAPTER_PDO_SQLITE_DATABASE', ':memory:');

/**
 * Zend\Db\Adapter\Pdo\Mssql
 *
 * Note that you need to patch your ntwdblib.dll, the one that
 * comes with PHP does not work. See user comments at
 * http://us2.php.net/manual/en/ref.mssql.php
 */
defined('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_HOSTNAME') || define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_HOSTNAME', '127.0.0.1');
defined('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_USERNAME') || define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_USERNAME', null);
defined('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_PASSWORD') || define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_PASSWORD', null);
defined('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_DATABASE') || define('TESTS_ZEND_DB_ADAPTER_PDO_MSSQL_DATABASE', 'test');

/**
 * Zend\Db\Adapter\Pdo\Pgsql
 */
defined('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_HOSTNAME') || define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_HOSTNAME', '127.0.0.1');
defined('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_USERNAME') || define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_USERNAME', null);
defined('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_PASSWORD') || define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_PASSWORD', null);
defined('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_DATABASE') || define('TESTS_ZEND_DB_ADAPTER_PDO_PGSQL_DATABASE', 'postgres');

/**
 * Zend\Db\Adapter\Oracle and Zend\Db\Adapter\Pdo\Oci
 *
 * There are separate properties to enable tests for the PDO_OCI adapter and
 * the native Oracle adapter, but the other properties are shared between the
 * two Oracle-related Zend\Db adapters.
 */
defined('TESTS_ZEND_DB_ADAPTER_PDO_OCI_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_PDO_OCI_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_ORACLE_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_ORACLE_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_ORACLE_HOSTNAME') || define('TESTS_ZEND_DB_ADAPTER_ORACLE_HOSTNAME', '127.0.0.1');
defined('TESTS_ZEND_DB_ADAPTER_ORACLE_USERNAME') || define('TESTS_ZEND_DB_ADAPTER_ORACLE_USERNAME', null);
defined('TESTS_ZEND_DB_ADAPTER_ORACLE_PASSWORD') || define('TESTS_ZEND_DB_ADAPTER_ORACLE_PASSWORD', null);
defined('TESTS_ZEND_DB_ADAPTER_ORACLE_SID') || define('TESTS_ZEND_DB_ADAPTER_ORACLE_SID', 'xe');

/**
 * Zend\Db\Adapter\Db2 and Zend\Db\Adapter\Pdo\Ibm
 * There are separate properties to enable tests for the PDO_IBM adapter and
 * the native DB2 adapter, but the other properties are shared between the
 * two related Zend\Db adapters.
 */
defined('TESTS_ZEND_DB_ADAPTER_PDO_IBM_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_PDO_IBM_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_DB2_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_DB2_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_DB2_HOSTNAME') || define('TESTS_ZEND_DB_ADAPTER_DB2_HOSTNAME', '127.0.0.1');
defined('TESTS_ZEND_DB_ADAPTER_DB2_PORT') || define('TESTS_ZEND_DB_ADAPTER_DB2_PORT', 50000);
defined('TESTS_ZEND_DB_ADAPTER_DB2_USERNAME') || define('TESTS_ZEND_DB_ADAPTER_DB2_USERNAME', null);
defined('TESTS_ZEND_DB_ADAPTER_DB2_PASSWORD') || define('TESTS_ZEND_DB_ADAPTER_DB2_PASSWORD', null);
defined('TESTS_ZEND_DB_ADAPTER_DB2_DATABASE') || define('TESTS_ZEND_DB_ADAPTER_DB2_DATABASE', 'sample');

/**
 * Zend\Db\Adapter\Sqlsrv
 * Note: Make sure that you create the "test" database and set a
 * username and password
 *
 */
defined('TESTS_ZEND_DB_ADAPTER_SQLSRV_ENABLED') || define('TESTS_ZEND_DB_ADAPTER_SQLSRV_ENABLED', false);
defined('TESTS_ZEND_DB_ADAPTER_SQLSRV_HOSTNAME') || define('TESTS_ZEND_DB_ADAPTER_SQLSRV_HOSTNAME', 'localhost\SQLEXPRESS');
defined('TESTS_ZEND_DB_ADAPTER_SQLSRV_USERNAME') || define('TESTS_ZEND_DB_ADAPTER_SQLSRV_USERNAME', null);
defined('TESTS_ZEND_DB_ADAPTER_SQLSRV_PASSWORD') || define('TESTS_ZEND_DB_ADAPTER_SQLSRV_PASSWORD', null);
defined('TESTS_ZEND_DB_ADAPTER_SQLSRV_DATABASE') || define('TESTS_ZEND_DB_ADAPTER_SQLSRV_DATABASE', 'test');

/**
 * Zend\Feed\PubSubHubbub tests
 *
 * If the BASEURI property requires a valid Uri to run online tests.
 */
defined('TESTS_ZEND_FEED_PUBSUBHUBBUB_BASEURI') || define('TESTS_ZEND_FEED_PUBSUBHUBBUB_BASEURI', false);

/**
 * Zend\Feed\Reader tests
 *
 * If the ONLINE_ENABLED property is false, only tests that can be executed
 * without network connectivity are run; when enabled, all tests will run.
 */
defined('TESTS_ZEND_FEED_READER_ONLINE_ENABLED') || define('TESTS_ZEND_FEED_READER_ONLINE_ENABLED', false);

/**
 * Zend\Form\Annotation
 *
 * Enable this if you have installed Doctrine\Common on the include_path or via
 * composer.
 */
defined('TESTS_ZEND_FORM_ANNOTATION_SUPPORT') || define('TESTS_ZEND_FORM_ANNOTATION_SUPPORT', false);

/*
 * Enable this if you have installed ZendService\ReCaptcha on the include_path or via
 * Composer.
 */
defined('TESTS_ZEND_FORM_RECAPTCHA_SUPPORT') || define('TESTS_ZEND_FORM_RECAPTCHA_SUPPORT', false);
defined('TESTS_ZEND_FORM_RECAPTCHA_PUBLIC_KEY') || define('TESTS_ZEND_FORM_RECAPTCHA_PUBLIC_KEY', 'public key');
defined('TESTS_ZEND_FORM_RECAPTCHA_PRIVATE_KEY') || define('TESTS_ZEND_FORM_RECAPTCHA_PRIVATE_KEY', 'private key');


/**
 * Zend\Http\Client tests
 *
 * To enable the dynamic Zend\Http\Client tests, you will need to symbolically
 * link or copy the files in tests/Zend/Http/Client/_files to a directory
 * under your web server(s) document root and set this constant to point to the
 * URL of this directory.
 */
defined('TESTS_ZEND_HTTP_CLIENT_BASEURI') || define('TESTS_ZEND_HTTP_CLIENT_BASEURI', false);

defined('TESTS_ZEND_HTTP_CLIENT_ONLINE') || define('TESTS_ZEND_HTTP_CLIENT_ONLINE', false);

/**
 * Zend\Http\Client\Proxy tests
 *
 * HTTP proxy to be used for testing the Proxy adapter. Set to a string of
 * the form 'host:port'. Set to null to skip HTTP proxy tests.
 */
defined('TESTS_ZEND_HTTP_CLIENT_HTTP_PROXY') || define('TESTS_ZEND_HTTP_CLIENT_HTTP_PROXY', false);
defined('TESTS_ZEND_HTTP_CLIENT_HTTP_PROXY_USER') || define('TESTS_ZEND_HTTP_CLIENT_HTTP_PROXY_USER', '');
defined('TESTS_ZEND_HTTP_CLIENT_HTTP_PROXY_PASS') || define('TESTS_ZEND_HTTP_CLIENT_HTTP_PROXY_PASS', '');

/**
 * Zend\Loader\Autoloader multi-version support tests
 *
 * ENABLED:      whether or not to run the multi-version tests
 * PATH:         path to a directory containing multiple ZF version installs
 * LATEST:       most recent ZF version in the PATH
 *               e.g., "1.9.2"
 * LATEST_MAJOR: most recent ZF major version in the PATH to test against
 *               e.g., "1.9.2"
 * LATEST_MINOR: most recent ZF minor version in the PATH to test against
 *               e.g., "1.8.4PL1"
 * SPECIFIC:     specific ZF version in the PATH to test against
 *               e.g., "1.7.6"
 * As an example, consider the following tree:
 *     ZendFramework/
 *     |-- 1.9.2
 *     |-- ZendFramework-1.9.1-minimal
 *     |-- 1.8.4PL1
 *     |-- 1.8.4
 *     |-- ZendFramework-1.8.3
 *     |-- 1.7.8
 *     |-- 1.7.7
 *     |-- 1.7.6
 * You would then set the value of "LATEST" and "LATEST_MAJOR" to "1.9.2", and
 * could choose between "1.9.2", "1.8.4PL1", and "1.7.8" for "LATEST_MINOR",
 * and any version number for "SPECIFIC". "PATH" would point to the parent
 * "ZendFramework" directory.
 */
defined('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_ENABLED') || define('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_ENABLED', false);
defined('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_PATH') || define('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_PATH', false);
defined('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_LATEST') || define('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_LATEST', false);
defined('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_LATEST_MAJOR') || define('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_LATEST_MAJOR', false);
defined('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_LATEST_MINOR') || define('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_LATEST_MINOR', false);
defined('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_SPECIFIC') || define('TESTS_ZEND_LOADER_AUTOLOADER_MULTIVERSION_SPECIFIC', false);

/**
 * Zend\Ldap online tests
 */
defined('TESTS_ZEND_LDAP_ONLINE_ENABLED') || define('TESTS_ZEND_LDAP_ONLINE_ENABLED', false);

/* These largely map to the options described in the Zend\Ldap and
 * Zend\Auth\Adapter\Ldap documentation.
 *
 * Example Configuration for Active Directory:
 *                      HOST: dc1.w.net
 *             USE_START_TLS: true
 *                   USE_SSL: false
 *                  USERNAME: CN=User 1,CN=Users,DC=w,DC=net
 *            PRINCIPAL_NAME: user1@w.net
 *             LDAP_PASSWORD: pass1
 *                   BASE_DN: CN=Users,DC=w,DC=net
 *               DOMAIN_NAME: w.net
 * ACCOUNT_DOMAIN_NAME_SHORT: W
 *              ALT_USERNAME: user2
 *                    ALT_DN: CN=User 2,CN=Users,DC=w,DC=net
 *              ALT_PASSWORD: pass2
 *
 * Example Configuration for OpenLDAP
 *                      HOST: s0.foo.net
 *                  USERNAME: CN=user1,DC=foo,DC=net
 *            PRINCIPAL_NAME: user1@foo.net
 *             LDAP_PASSWORD: pass1
 *          BIND_REQUIRES_DN: true
 *                   BASE_DN: OU=Sales,DC=w,DC=net
 *               DOMAIN_NAME: foo.net
 * ACCOUNT_DOMAIN_NAME_SHORT: FOO
 *              ALT_USERNAME: abaker
 *                    ALT_DN: CN=Alice Baker,OU=Sales,DC=foo,DC=net
 *              ALT_PASSWORD: apass
 */
defined('TESTS_ZEND_LDAP_HOST') || define('TESTS_ZEND_LDAP_HOST', 'localhost');
//defined('TESTS_ZEND_LDAP_PORT') || define('TESTS_ZEND_LDAP_PORT', 389);
defined('TESTS_ZEND_LDAP_USE_START_TLS') || define('TESTS_ZEND_LDAP_USE_START_TLS', true);
//defined('TESTS_ZEND_LDAP_USE_SSL') || define('TESTS_ZEND_LDAP_USE_SSL', false);
defined('TESTS_ZEND_LDAP_USERNAME') || define('TESTS_ZEND_LDAP_USERNAME', 'CN=someUser,DC=example,DC=com');
defined('TESTS_ZEND_LDAP_PRINCIPAL_NAME') || define('TESTS_ZEND_LDAP_PRINCIPAL_NAME', 'someUser@example.com');
defined('TESTS_ZEND_LDAP_PASSWORD') || define('TESTS_ZEND_LDAP_PASSWORD', null);
defined('TESTS_ZEND_LDAP_BIND_REQUIRES_DN') || define('TESTS_ZEND_LDAP_BIND_REQUIRES_DN', true);
defined('TESTS_ZEND_LDAP_BASE_DN') || define('TESTS_ZEND_LDAP_BASE_DN', 'OU=Sales,DC=example,DC=com');
//defined('TESTS_ZEND_LDAP_ACCOUNT_FILTER_FORMAT') || define('TESTS_ZEND_LDAP_ACCOUNT_FILTER_FORMAT', '(&(objectClass=posixAccount)(uid=%s))');
defined('TESTS_ZEND_LDAP_ACCOUNT_DOMAIN_NAME') || define('TESTS_ZEND_LDAP_ACCOUNT_DOMAIN_NAME', 'example.com');
defined('TESTS_ZEND_LDAP_ACCOUNT_DOMAIN_NAME_SHORT') || define('TESTS_ZEND_LDAP_ACCOUNT_DOMAIN_NAME_SHORT', 'EXAMPLE');
defined('TESTS_ZEND_LDAP_ALT_USERNAME') || define('TESTS_ZEND_LDAP_ALT_USERNAME', 'anotherUser');
defined('TESTS_ZEND_LDAP_ALT_DN') || define('TESTS_ZEND_LDAP_ALT_DN', 'CN=Another User,OU=Sales,DC=example,DC=com');
defined('TESTS_ZEND_LDAP_ALT_PASSWORD') || define('TESTS_ZEND_LDAP_ALT_PASSWORD', null); // Used in Zend\Auth\Adapter\Ldap tests
//(defined('TESTS_ZEND_LDAP_WRITEABLE_SUBTREE') || define('TESTS_ZEND_LDAP_WRITEABLE_SUBTREE', 'OU=Test,OU=Sales,DC=example,DC=com');

/**
 * Zend\Mail\Storage tests
 *
 * TESTS_ZEND_MAIL_SERVER_TESTDIR and TESTS_ZEND_MAIL_SERVER_FORMAT are used for POP3 and IMAP tests.
 * TESTS_ZEND_MAIL_SERVER_FORMAT is the format your test mail server uses: 'mbox' or 'maildir'. The mail
 * storage for the user specified in your POP3 or IMAP tests should be TESTS_ZEND_MAIL_SERVER_TESTDIR. Be
 * careful: it's cleared before copying the files. If you want to copy the files manually set the dir
 * to null (or anything == null).
 *
 * TESTS_ZEND_MAIL_TEMPDIR is used for testing write operations in local storages. If not set (== null)
 * tempnam() is used.
 */
defined('TESTS_ZEND_MAIL_SERVER_TESTDIR') || define('TESTS_ZEND_MAIL_SERVER_TESTDIR', null);
defined('TESTS_ZEND_MAIL_SERVER_FORMAT') || define('TESTS_ZEND_MAIL_SERVER_FORMAT', 'mbox');
defined('TESTS_ZEND_MAIL_TEMPDIR') || define('TESTS_ZEND_MAIL_TEMPDIR', null);

/**
 * Zend\Mail\Storage\Pop3 / Zend\Mail\Transport\Pop3
 *
 * IMPORTANT: you need to copy tests/Zend/Mail/_files/test.mbox to your mail
 * if you haven't set TESTS_ZEND_MAIL_SERVER_TESTDIR
 */
defined('TESTS_ZEND_MAIL_POP3_ENABLED') || define('TESTS_ZEND_MAIL_POP3_ENABLED', false);
defined('TESTS_ZEND_MAIL_POP3_HOST') || define('TESTS_ZEND_MAIL_POP3_HOST', 'localhost');
defined('TESTS_ZEND_MAIL_POP3_USER') || define('TESTS_ZEND_MAIL_POP3_USER', 'test');
defined('TESTS_ZEND_MAIL_POP3_PASSWORD') || define('TESTS_ZEND_MAIL_POP3_PASSWORD', '');
// test SSL connections if enabled in your test server
defined('TESTS_ZEND_MAIL_POP3_SSL') || define('TESTS_ZEND_MAIL_POP3_SSL', true);
defined('TESTS_ZEND_MAIL_POP3_TLS') || define('TESTS_ZEND_MAIL_POP3_TLS', true);
// WRONG_PORT should be an existing server port,
// INVALID_PORT should be a non existing (each on defined host)
defined('TESTS_ZEND_MAIL_POP3_WRONG_PORT') || define('TESTS_ZEND_MAIL_POP3_WRONG_PORT', 80);
defined('TESTS_ZEND_MAIL_POP3_INVALID_PORT') || define('TESTS_ZEND_MAIL_POP3_INVALID_PORT', 3141);

/**
 * Zend\Mail\Storage\Imap / Zend\Mail\Transport\Imap
 *
 * IMPORTANT: you need to copy tests/Zend/Mail/_files/test.mbox to your mail
 * if you haven't set TESTS_ZEND_MAIL_SERVER_TESTDIR
 */
defined('TESTS_ZEND_MAIL_IMAP_ENABLED') || define('TESTS_ZEND_MAIL_IMAP_ENABLED', false);
defined('TESTS_ZEND_MAIL_IMAP_HOST') || define('TESTS_ZEND_MAIL_IMAP_HOST', 'localhost');
defined('TESTS_ZEND_MAIL_IMAP_USER') || define('TESTS_ZEND_MAIL_IMAP_USER', 'test');
defined('TESTS_ZEND_MAIL_IMAP_PASSWORD') || define('TESTS_ZEND_MAIL_IMAP_PASSWORD', '');
// test SSL connections if enabled in your test server
defined('TESTS_ZEND_MAIL_IMAP_SSL') || define('TESTS_ZEND_MAIL_IMAP_SSL', true);
defined('TESTS_ZEND_MAIL_IMAP_TLS') || define('TESTS_ZEND_MAIL_IMAP_TLS', true);
// WRONG_PORT should be an existing server port,
// INVALID_PORT should be a non-existing (each on defined host)
defined('TESTS_ZEND_MAIL_IMAP_WRONG_PORT') || define('TESTS_ZEND_MAIL_IMAP_WRONG_PORT', 80);
defined('TESTS_ZEND_MAIL_IMAP_INVALID_PORT') || define('TESTS_ZEND_MAIL_IMAP_INVALID_PORT', 3141);


/**
 * Zend\Mail\Storage\Maildir test
 *
 * Before enabling this test you have to unpack messages.tar in
 * Zend/Mail/_files/test.maildir/cur/ and remove the tar for this test to work.
 * That's because the messages files have a colon in the filename and that's a
 * forbidden character on Windows.
 */
defined('TESTS_ZEND_MAIL_MAILDIR_ENABLED') || define('TESTS_ZEND_MAIL_MAILDIR_ENABLED', false);

/**
 * Zend\Mail\Transport\Smtp
 *
 * @todo TO be implemented
 */
defined('TESTS_ZEND_MAIL_SMTP_ENABLED') || define('TESTS_ZEND_MAIL_SMTP_ENABLED', false);
defined('TESTS_ZEND_MAIL_SMTP_HOST') || define('TESTS_ZEND_MAIL_SMTP_HOST', 'localhost');
defined('TESTS_ZEND_MAIL_SMTP_PORT') || define('TESTS_ZEND_MAIL_SMTP_PORT', 25);
defined('TESTS_ZEND_MAIL_SMTP_USER') || define('TESTS_ZEND_MAIL_SMTP_USER', 'testuser');
defined('TESTS_ZEND_MAIL_SMTP_PASSWORD') || define('TESTS_ZEND_MAIL_SMTP_PASSWORD', 'testpassword');
defined('TESTS_ZEND_MAIL_SMTP_AUTH') || define('TESTS_ZEND_MAIL_SMTP_AUTH', false);
// AUTH can be set to false or a string of AUTH method (e.g. LOGIN, PLAIN, CRAMMD5 or DIGESTMD5)

/**
 * Zend\Soap\AutoDiscover scenario tests for complex objects and wsdl generation
 *
 * Copy all the files of zf/tests/Zend/Soap/_files/fulltests into a directory
 * that can be reached by webserver and enter the base uri to this directory
 * into the variable. The test "Zend\Soap\AutoDiscover\OnlineTest" makes use
 * of the servers and AutoDiscover feature.
 *
 * NOTE: Make sure the servers are using the correct Zend Framework copy,
 * when having more than one version installed and include paths are changing.
 */
defined('TESTS_ZEND_SOAP_AUTODISCOVER_ONLINE_SERVER_BASEURI') || define('TESTS_ZEND_SOAP_AUTODISCOVER_ONLINE_SERVER_BASEURI', false);

/**
 * Zend\Uri tests
 *
 * Setting CRASH_TEST_ENABLED to true will enable some tests that may
 * potentially crash PHP on some systems, due to very deep-nesting regular
 * expressions.
 *
 * Only do this if you know what you are doing!
 */
defined('TESTS_ZEND_URI_CRASH_TEST_ENABLED') || define('TESTS_ZEND_URI_CRASH_TEST_ENABLED', false);

/**
 * Zend\Validate tests
 *
 * Set ONLINE_ENABLED if you wish to run validators that require network
 * connectivity.
 */
defined('TESTS_ZEND_VALIDATOR_ONLINE_ENABLED') || define('TESTS_ZEND_VALIDATOR_ONLINE_ENABLED', false);

/**
 * Zend\Version tests
 *
 * Set ONLINE_ENABLED if you wish to fetch the latest version.
 */
defined('TESTS_ZEND_VERSION_ONLINE_ENABLED') || define('TESTS_ZEND_VERSION_ONLINE_ENABLED', false);


/**
 * PHPUnit Code Coverage / Test Report
 */
defined('TESTS_GENERATE_REPORT') || define('TESTS_GENERATE_REPORT', false);
defined('TESTS_GENERATE_REPORT_TARGET') || define('TESTS_GENERATE_REPORT_TARGET', '/path/to/target');