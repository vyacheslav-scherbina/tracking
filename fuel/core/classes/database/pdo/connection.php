<?php
/**
 * PDO database connection.
 *
 * @package    Fuel/Database
 * @category   Drivers
 * @author     Kohana Team
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license
 */

namespace Fuel\Core;


class Database_PDO_Connection extends \Database_Connection
{
	/**
	 * @var  \PDO  Raw server connection
	 */
	protected $_connection;

	/**
	 * @var  string  PDO uses no quoting by default for identifiers
	 */
	protected $_identifier = '';

	/**
	 * @var  bool  Allows transactions
	 */
	protected $_in_transaction = false;

	/**
	 * @var  string  Which kind of DB is used
	 */
	public $_db_type = '';

	protected function __construct($name, array $config)
	{
		parent::__construct($name, $config);

		if (isset($this->_config['identifier']))
		{
			// Allow the identifier to be overloaded per-connection
			$this->_identifier = (string) $this->_config['identifier'];
		}
	}

	public function connect()
	{  
		if ($this->_connection)
		{
			return;
		}

		// Extract the connection parameters, adding required variabels
		extract($this->_config['connection'] + array(
			'dsn'        => '',
			'username'   => null,
			'password'   => null,
			'persistent' => false,
		));

		// Clear the connection parameters for security
		$this->_config['connection'] = array();

		// determine db type
		$_dsn_find_collon = strpos($dsn, ':');
		$this->_db_type = $_dsn_find_collon ? substr($dsn, 0, $_dsn_find_collon) : null;

		// Force PDO to use exceptions for all errors
		$attrs = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);

		if ( ! empty($persistent))
		{
			// Make the connection persistent
			$attrs[\PDO::ATTR_PERSISTENT] = TRUE;
		}
        
		try
		{
			// Create a new PDO connection
			$this->_connection = new \PDO($dsn, $username, $password, $attrs);
		}
		catch (\PDOException $e)
		{
			throw new \Database_Exception($e->getMessage(), $e->getCode(), $e);
		}

		if ( ! empty($this->_config['charset']))
		{
			// Set the character set
			$this->set_charset($this->_config['charset']);
		}
	}

	public function disconnect()
	{
		// Destroy the PDO object
		$this->_connection = null;

		return TRUE;
	}

	public function set_charset($charset)
	{
		// Make sure the database is connected
		$this->_connection or $this->connect();

		// Execute a raw SET NAMES query
		$this->_connection->exec('SET NAMES '.$this->quote($charset));
	}

	public function query($type, $sql, $as_object)
	{
		// Make sure the database is connected
		$this->_connection or $this->connect();

		if ( ! empty($this->_config['profiling']))
		{
			// Benchmark this query for the current instance
			$benchmark = Profiler::start("Database ({$this->_instance})", $sql);
		}

		try
		{
            //echo $sql;
            //echo "<br>";
            //echo "<br>";
            //echo "<br>";
            
			$result = $this->_connection->query($sql);
		}
		catch (\Exception $e)
		{
			if (isset($benchmark))
			{
				// This benchmark is worthless
				Profiler::delete($benchmark);
			}

			// Convert the exception in a database exception
			throw new \Database_Exception($e->getMessage().' with query: "'.$sql.'"');
		}

		if (isset($benchmark))
		{
			Profiler::stop($benchmark);
		}

		// Set the last query
		$this->last_query = $sql;

		if ($type === \DB::SELECT)
		{
			// Convert the result into an array, as PDOStatement::rowCount is not reliable
			if ($as_object === FALSE)
			{
				$result->setFetchMode(\PDO::FETCH_ASSOC);
			}
			elseif (is_string($as_object))
			{
				$result->setFetchMode(\PDO::FETCH_CLASS, $as_object);
			}
			else
			{
				$result->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
			}

			$result = $result->fetchAll();

			// Return an iterator of results
			return new \Database_Result_Cached($result, $sql, $as_object);
		}
		elseif ($type === \DB::INSERT)
		{
			// Return a list of insert id and rows created
			return array(
				$this->_connection->lastInsertId(),
				$result->rowCount(),
			);
		}
		else
		{
			// Return the number of rows affected
			return $result->errorCode() === '00000' ? $result->rowCount() : -1;
		}
	}

	public function list_tables($like = null)
	{
		throw new \FuelException('Database method '.__METHOD__.' is not supported by '.__CLASS__);
	}

	public function list_columns($table, $like = null)
	{
		throw new \FuelException('Database method '.__METHOD__.' is not supported by '.__CLASS__);
	}

	public function escape($value)
	{
		// Make sure the database is connected
		$this->_connection or $this->connect();

		return $this->_connection->quote($value);
	}

	public function in_transaction()
	{
		return $this->_in_transaction;
	}

	public function start_transaction()
	{
		$this->_connection or $this->connect();
		$this->_in_transaction = true;
		return $this->_connection->beginTransaction();
	}

	public function commit_transaction()
	{
		$this->_in_transaction = false;
		return $this->_connection->commit();
	}

	public function rollback_transaction()
	{
		$this->_in_transaction = false;
		return $this->_connection->rollBack();
	}

}
