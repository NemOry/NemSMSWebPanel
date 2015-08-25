<?php 

require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Message extends DatabaseObject
{
	protected static $table_name 	= T_MESSAGES;
	protected static $col_id 		= C_MESSAGE_ID;

	public $id;
	public $userid;
	public $message;
	public $phonenumber;

	public function create()
	{
		global $db;

		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_MESSAGE_USERID		.", ";
		$sql .= C_MESSAGE_MESSAGE		.", ";
		$sql .= C_MESSAGE_PHONENUMBER;
		$sql .=") VALUES (";
		$sql .= " '".$db->escape_string($this->userid) ."', ";
		$sql .= " '".$db->escape_string($this->message) ."', ";
		$sql .= " '".$db->escape_string($this->phonenumber) ."' ";
		$sql .=")";

		if($db->query($sql))
		{
			$this->id = $db->get_last_id();
			return true;
		}
		else
		{
			return false;	
		}
	}
	
	public function update()
	{
		global $db;

		$sql = "UPDATE " 				. self::$table_name . " SET ";
		$sql .= C_MESSAGE_USERID 		. "='" . $db->escape_string($this->userid) 		. "', ";
		$sql .= C_MESSAGE_MESSAGE 		. "='" . $db->escape_string($this->message) 	. "', ";
		$sql .= C_MESSAGE_PHONENUMBER	. "='" . $db->escape_string($this->phonenumber)	. "' ";
		$sql .="WHERE " . self::$col_id . "=" . $db->escape_string($this->id) 		. "";

		$db->query($sql);

		return ($db->get_affected_rows() == 1) ? true : false;
	}

	public function delete()
	{
		global $db;
		$sql = "DELETE FROM " . self::$table_name . " WHERE " . self::$col_id . "=" . $this->id . "";
		$db->query($sql);
		return ($db->get_affected_rows() == 1) ? true : false;
	}
	
	protected static function instantiate($record)
	{
		$this_class = new self;

		$this_class->id 			= $record[C_MESSAGE_ID];
		$this_class->userid 		= $record[C_MESSAGE_USERID];
		$this_class->message 		= $record[C_MESSAGE_MESSAGE];
		$this_class->phonenumber 	= $record[C_MESSAGE_PHONENUMBER];

		return $this_class;
	}

	public static function get_all_by_userid($id)
	{
		global $db;
		$id 	= $db->escape_string($id);

		$sql = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE ".C_MESSAGE_USERID." = ".$id;

		$result = self::get_by_sql($sql);
		
		return !empty($result) ? $result : null;
	}
}

?>