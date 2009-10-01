<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * The PEAR DB driver for PHP's pgsql extension
 * for interacting with PostgreSQL databases
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Database
 * @package    DB
 * @author     Rui Hirokawa <hirokawa@php.net>
 * @author     Stig Bakken <ssb@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id: pgsql.php,v 1.126 2005/03/04 23:12:36 danielc Exp $
 * @link       http://pear.php.net/package/DB
 */

/**
 * Obtain the DB_common class so it can be extended from
 */
require_once 'DB/pgsql.php';

/**
 * The methods PEAR DB uses to interact with PHP's pgsql extension
 * for interacting with PostgreSQL databases
 *
 * These methods overload the ones declared in DB_common.
 *
 * @category   Database
 * @package    DB
 * @author     Rui Hirokawa <hirokawa@php.net>
 * @author     Stig Bakken <ssb@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.7.6
 * @link       http://pear.php.net/package/DB
 */
class DB_pgsqlex extends DB_pgsql
{

    // }}}
    // {{{ constructor

    /**
     * This constructor calls <kbd>$this->DB_common()</kbd>
     *
     * @return void
     */
    function DB_pgsqlex()
    {
        $this->DB_pgsql();
    }

    // }}}
    // {{{ connect()

    /**
     * Connect to the database server, log in and open the database
     *
     * Don't call this method directly.  Use DB::connect() instead.
     *
     * PEAR DB's pgsql driver supports the following extra DSN options:
     *   + connect_timeout  How many seconds to wait for a connection to
     *                       be established.  Available since PEAR DB 1.7.0.
     *   + new_link         If set to true, causes subsequent calls to
     *                       connect() to return a new connection link
     *                       instead of the existing one.  WARNING: this is
     *                       not portable to other DBMS's.  Available only
     *                       if PHP is >= 4.3.0 and PEAR DB is >= 1.7.0.
     *   + options          Command line options to be sent to the server.
     *                       Available since PEAR DB 1.6.4.
     *   + service          Specifies a service name in pg_service.conf that
     *                       holds additional connection parameters.
     *                       Available since PEAR DB 1.7.0.
     *   + sslmode          How should SSL be used when connecting?  Values:
     *                       disable, allow, prefer or require.
     *                       Available since PEAR DB 1.7.0.
     *   + tty              This was used to specify where to send server
     *                       debug output.  Available since PEAR DB 1.6.4.
     *
     * Example of connecting to a new link via a socket:
     * <code>
     * require_once 'DB.php';
     * 
     * $dsn = 'pgsql://user:pass@unix(/tmp)/dbname?new_link=true';
     * $options = array(
     *     'portability' => DB_PORTABILITY_ALL,
     * );
     * 
     * $db =& DB::connect($dsn, $options);
     * if (PEAR::isError($db)) {
     *     die($db->getMessage());
     * }
     * </code>
     *
     * @param array $dsn         the data source name
     * @param bool  $persistent  should the connection be persistent?
     *
     * @return int  DB_OK on success. A DB_Error object on failure.
     *
     * @link http://www.postgresql.org/docs/current/static/libpq.html#LIBPQ-CONNECT
     */
    function connect($dsn, $persistent = false)
    {
        $res = parent::connect($dsn, $persistent);
        if (PEAR::isError($res)) { return $res; }
        
        parent::query("SET CLIENT_ENCODING TO 'EUC-JP'");
        return DB_OK;
    }
}
