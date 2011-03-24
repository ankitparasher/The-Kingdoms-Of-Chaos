<?php
/*******************************************************************************
    The Kingdoms of Chaos - An online browser text game - <http://www.tkoc.net>
    Copyright (C) 2011 - Administrators of The Kingdoms of Chaos

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    Contact Information:
	Petros Karipidis  - petros@rufunka.com - <http://www.rufunka.com/>
	Anastasios Nistas - tasosos@gmail.com  - <http://tasos.pavta.com/>
	
	Other Information
	=================
	The exact Author of each source file should be specified after this license
	notice. If not specified then the "Current Administrators" found at
	<http://www.tkoc.net/about.php> are considered the Authors of the source
	file.

	As stated at the License Section 5.d: "If the work has interactive user
	interfaces, each must display Appropriate Legal Notices; however, if the
	Program has interactive interfaces that do not display Appropriate Legal
	Notices, your work need not make them do so.", we require you give
	credits at the appropriate section of your interface.
********************************************************************************/
?>
<?php
/** File PDOStatement_sqlite.class.php	*
 *(C) Andrea Giammarchi [2005/10/13]	*/

/**
 * Class PDOStatement_sqlite
 * 	This class is used from class PDO_sqlite to manage a MySQL database.
 *      Look at PDO.clas.php file comments to know more about MySQL connection.
 * ---------------------------------------------
 * @Compatibility	>= PHP 4
 * @Dependencies	PDO.class.php
 * 			PDO_sqlite.class.php
 * @Author		Andrea Giammarchi
 * @Site		http://www.devpro.it/
 * @Mail		andrea [ at ] 3site [ dot ] it
 * @Date		2005/10/13
 * @LastModified	2006/01/29 09:30 [fixed execute bug]
 * @Version		0.1b - tested
 */ 
class PDOStatement_sqlite {
	
	/**
	 * 'Private' variables:
	 *	__connection:Resource		Database connection
         *	__dbinfo:Array			Array with 4 elements used to manage connection
         *      __persistent:Boolean		Connection mode, is true on persistent, false on normal (deafult) connection
         *      __query:String			Last query used
         *      __result:Resource		Last result from last query
         *      __fetchmode:Integer		constant PDO_FETCH_* result mode
         *      __errorCode:String		Last error string code
         *      __errorInfo:Array		Last error informations, code, number, details
         *      __boundParams:Array		Stored bindParam
	 */
	var $__connection;
	var $__dbinfo;
	var $__persistent = false;
	var $__query = '';
	var $__result = null;
	var $__fetchmode = PDO_FETCH_BOTH;
	var $__errorCode = '';
	var $__errorInfo = Array('');
	var $__boundParams = Array();
	
	/**
	 * Public constructor:
	 *	Called from PDO to create a PDOStatement for this database
         *       	new PDOStatement_sqlite( &$__query:String, &$__connection:Resource, $__dbinfo:String )
	 * @Param	String		query to prepare
         * @Param	Resource	database connection
         * @Param	String		database file name
	 */
	function PDOStatement_sqlite(&$__query, &$__connection, &$__dbinfo) {
		$this->__query = &$__query;
		$this->__connection = &$__connection;
		$this->__dbinfo = &$__dbinfo;
	}
	
	/**
	 * Public method:
	 *	Replace ? or :named values to execute prepared query
         *       	this->bindParam( $mixed:Mixed, &$variable:Mixed, $type:Integer, $lenght:Integer ):Void
         * @Param	Mixed		Integer or String to replace prepared value
         * @Param	Mixed		variable to replace
         * @Param	Integer		this variable is not used but respects PDO original accepted parameters
         * @Param	Integer		this variable is not used but respects PDO original accepted parameters
	 */
	function bindParam($mixed, &$variable, $type = null, $lenght = null) {
		if(is_string($mixed))
			$this->__boundParams[$mixed] = $variable;
		else
			array_push($this->__boundParams, $variable);
	}
	
	/**
	 * Public method:
	 *	Checks if query was valid and returns how may fields returns
         *       	this->columnCount( void ):Void
	 */
	function columnCount() {
		$result = 0;
		if(!is_null($this->__result))
			$result = sqlite_num_fields($this->__result);
		return $result; 
	}
	
	/**
	 * Public method:
	 *	Returns a code rappresentation of an error
         *       	this->errorCode( void ):String
         * @Return	String		String rappresentation of the error
	 */
	function errorCode() {
		return $this->__errorCode;
	}
	
	/**
	 * Public method:
	 *	Returns an array with error informations
         *       	this->errorInfo( void ):Array
         * @Return	Array		Array with 3 keys:
         * 				0 => error code
         *                              1 => error number
         *                              2 => error string
	 */
	function errorInfo() {
		return $this->__errorInfo;
	}
	
	/**
	 * Public method:
	 *	Excecutes a query and returns true on success or false.
         *       	this->exec( $array:Array ):Boolean
         * @Param	Array		If present, it should contain all replacements for prepared query
         * @Return	Boolean		true if query has been done without errors, false otherwise
	 */
	function execute($array = Array()) {
		if(count($this->__boundParams) > 0)
			$array = &$this->__boundParams;
		$__query = $this->__query;
		if(count($array) > 0) {
			foreach($array as $k => $v) {
				if(!is_int($k) || substr($k, 0, 1) === ':') {
					if(!isset($tempf))
						$tempf = $tempr = array();
					array_push($tempf, $k);
					array_push($tempr, "'".sqlite_escape_string($v)."'");
				}
				else {
					$parse = create_function('$v', 'return "\'".sqlite_escape_string($v)."\'";');
					$__query = preg_replace("/(\?)/e", '$parse($array[$k++]);', $__query);
					break;
				}
			}
			if(isset($tempf))
				$__query = str_replace($tempf, $tempr, $__query);
		}
		if(is_null($this->__result = &$this->__uquery($__query)))
			$keyvars = false;
		else
			$keyvars = true;
		$this->__boundParams = array();
		return $keyvars;
	}
	
	/**
	 * Public method:
	 *	Returns, if present, next row of executed query or false.
         *       	this->fetch( $mode:Integer, $cursor:Integer, $offset:Integer ):Mixed
         * @Param	Integer		PDO_FETCH_* constant to know how to read next row, default PDO_FETCH_BOTH
         * 				NOTE: if $mode is omitted is used default setted mode, PDO_FETCH_BOTH
         * @Param	Integer		this variable is not used but respects PDO original accepted parameters
         * @Param	Integer		this variable is not used but respects PDO original accepted parameters
         * @Return	Mixed		Next row of executed query or false if there is nomore.
	 */
	function fetch($mode = PDO_FETCH_BOTH, $cursor = null, $offset = null) {
		if(func_num_args() == 0)
			$mode = &$this->__fetchmode;
		$result = false;
		if(!is_null($this->__result)) {
			switch($mode) {
				case PDO_FETCH_NUM:
					$result = sqlite_fetch_array($this->__result, SQLITE_NUM);
					break;
				case PDO_FETCH_ASSOC:
					$result = sqlite_fetch_array($this->__result, SQLITE_ASSOC);
					break;
				case PDO_FETCH_OBJ:
					$result = sqlite_fetch_object($this->__result);
					break;
				case PDO_FETCH_BOTH:
				default:
					$result = sqlite_fetch_array($this->__result, SQLITE_BOTH);
					break;
			}
		}
		if(!$result)
			$this->__result = null;
		return $result;
	}
	
	/**
	 * Public method:
	 *	Returns an array with all rows of executed query.
         *       	this->fetchAll( $mode:Integer ):Array
         * @Param	Integer		PDO_FETCH_* constant to know how to read all rows, default PDO_FETCH_BOTH
         * 				NOTE: this doesn't work as fetch method, then it will use always PDO_FETCH_BOTH
         *                                    if this param is omitted
         * @Return	Array		An array with all fetched rows
	 */
	function fetchAll($mode = PDO_FETCH_BOTH) {
		$result = array();
		if(!is_null($this->__result)) {
			switch($mode) {
				case PDO_FETCH_NUM:
					while($r = sqlite_fetch_array($this->__result, SQLITE_NUM))
						array_push($result, $r);
					break;
				case PDO_FETCH_ASSOC:
					while($r = sqlite_fetch_array($this->__result, SQLITE_ASSOC))
						array_push($result, $r);
					break;
				case PDO_FETCH_OBJ:
					while($r = sqlite_fetch_object($this->__result))
						array_push($result, $r);
					break;
				case PDO_FETCH_BOTH:
				default:
					while($r = sqlite_fetch_array($this->__result, SQLITE_BOTH))
						array_push($result, $r);
					break;
			}
		}
		$this->__result = null;
		return $result;
	}
	
	/**
	 * Public method:
	 *	Returns, if present, first column of next row of executed query
         *       	this->fetchSingle( void ):Mixed
         * @Return	Mixed		Null or next row's first column
	 */
	function fetchSingle() {
		$result = null;
		if(!is_null($this->__result)) {
			$result = @sqlite_fetch_array($this->__result, SQLITE_NUM);
			if($result)
				$result = $result[0];
			else
				$this->__result = null;
		}
		return $result;
	}
	
	/**
	 * Public method:
	 *	Returns number of last affected database rows
         *       	this->rowCount( void ):Integer
         * @Return	Integer		number of last affected rows
         * 				NOTE: works with INSERT, UPDATE and DELETE query type
	 */
	function rowCount() {
		return sqlite_changes($this->__connection);
	}
	
	
	// NOT TOTALLY SUPPORTED PUBLIC METHODS	
	/**
	 * Public method:
	 *	Quotes correctly a string for this database
         *       	this->getAttribute( $attribute:Integer ):Mixed
         * @Param	Integer		a constant [	PDO_ATTR_SERVER_INFO,
         * 						PDO_ATTR_SERVER_VERSION,
         *                                              PDO_ATTR_CLIENT_VERSION,
         *                                              PDO_ATTR_PERSISTENT	]
         * @Return	Mixed		correct information or null
	 */
	function getAttribute($attribute) {
		$result = null;
		switch($attribute) {
			case PDO_ATTR_SERVER_INFO:
				$result = sqlite_libencoding();
				break;
			case PDO_ATTR_SERVER_VERSION:
			case PDO_ATTR_CLIENT_VERSION:
				$result = sqlite_libversion();
				break;
			case PDO_ATTR_PERSISTENT:
				$result = $this->__persistent;
				break;
		}
		return $result;
	}
	
	/**
	 * Public method:
	 *	Sets database attributes, in this version only connection mode.
         *       	this->setAttribute( $attribute:Integer, $mixed:Mixed ):Boolean
         * @Param	Integer		PDO_* constant, in this case only PDO_ATTR_PERSISTENT
         * @Param	Mixed		value for PDO_* constant, in this case a Boolean value
         * 				true for permanent connection, false for default not permament connection
         * @Return	Boolean		true on change, false otherwise
	 */
	function setAttribute($attribute, $mixed) {
		$result = false;
		if($attribute === PDO_ATTR_PERSISTENT && $mixed != $this->__persistent) {
			$result = true;
			$this->__persistent = (boolean) $mixed;
			sqlite_close($this->__connection);
			if($this->__persistent === true)
				$this->__connection = &sqlite_popen($this->__dbinfo);
			else
				$this->__connection = &sqlite_open($this->__dbinfo);
		}
		return $result;
	}
	
	/**
	 * Public method:
	 *	Sets default fetch mode to use with this->fetch() method.
         *       	this->setFetchMode( $mode:Integer ):Boolean
         * @Param	Integer		PDO_FETCH_* constant to use while reading an execute query with fetch() method.
         * 				NOTE: PDO_FETCH_LAZY and PDO_FETCH_BOUND are not supported
         * @Return	Boolean		true on change, false otherwise
	 */
	function setFetchMode($mode) {
		$result = false;
		switch($mode) {
			case PDO_FETCH_NUM:
			case PDO_FETCH_ASSOC:
			case PDO_FETCH_OBJ:
			case PDO_FETCH_BOTH:
				$result = true;
				$this->__fetchmode = &$mode;
				break;
		}
		return $result;
	}
	
	
	// UNSUPPORTED PUBLIC METHODS
        function bindColumn($mixewd, &$param, $type = null, $max_length = null, $driver_option = null) {
		return false;
	}
	
	function __setErrors($er, $connection = false) {
		if(!is_resource($this->__connection)) {
			$errno = 1;
			$errst = 'Unable to open database.';
		}
		else {
			$errno = sqlite_last_error($this->__connection);
			$errst = sqlite_error_string($errno);
		}
		$this->__errorCode = &$er;
		$this->__errorInfo = Array($this->__errorCode, $errno, $errst);
		$this->__result = null;
	}
	
	function __uquery(&$query) {
		if(!@$query = sqlite_query($query, $this->__connection)) {
			$this->__setErrors('SQLER');
			$query = null;
		}
		return $query;
	}
	
}
?>