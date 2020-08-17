<?php
/**
defined('BASEPATH') OR exit('No direct script access allowed'); is used to make sure that the request has gone through index.php in root dir.
 This is for reasons such as making sure that all Codeigniter base classes are being loaded and making sure certain vars have been set
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_model extends CI_Model
{
	/**
	   Consrtuctor of the class
	 */
	public function __construct()
	{
		parent:: __construct();//call the constuctor of the parent class/super class(CI_Controller)
		
		$this->load->database();// loads the database and make it available for every method in this class
		
	}
	
	/**
	 Returns all messages posted by the user with  
	 the specified username, most recent first 
	*/
	public function getMessagesByPoster($name)
	{
		$sql = 'SELECT user_username, text , posted_at  FROM Messages WHERE user_username = ? ORDER BY posted_at DESC';//this will assign a sql query to a var $sql which basically says 'Get user_username, text , posted_at from the table Messages where username = ? and order them in descending order according to posted_at (here ? is used as placeholder to prevent sql injection. line 29)'
		
		$query = $this->db->query($sql, array($name));//this will execute that $sql/query in the database and pass $name in place of the '?' and assign the returned data to the var $query
		
		return $query->result_array();// returns an array-of-arrays, where the inner array elements are named after the columns of the database 
		
	}
	
	/**
	Returns all messages containing the specified 
	search string, most recent first 
	*/
	public function searchMessages($string)
	{
		$sql = 'SELECT user_username, text , posted_at  FROM Messages WHERE text like ? ORDER BY posted_at DESC';//this will assign a sql query to a var $sql which basically says 'Get user_username, text , posted_at from the table Messages where text contains ? and order them in descending order according to posted_at (here ? is used as placeholder to prevent sql injection. line 44)'
		
		
		$query = $this->db->query($sql, array("%".$string."%"));//this will execute that $sql/query in the database and pass '%$string%' in place of the '?' and assign the returned data to the var $query
		
		return $query->result_array();//returns an array-of-arrays, where the inner array elements are named after the columns of the database
		
		
	}
	
	/**
	 Adds the supplied message to the messages
	 table in the database 
	*/
	public function insertMessage($poster, $string)
	{
		$sql = 'INSERT INTO Messages(user_username, text, posted_at) VALUES (?, ?, ?)';//this will assign a sql query to a var $sql which basically says 'Insert ?'s into the columns user_username, text, posted_at in the table User_Follows(here ?'s are used as placeholder to prevent sql injection. line 60)'
		 $string = htmlspecialchars($string);//just to make sure that the $string doesn't have any script 
	
		 $this->db->query($sql, array($poster, $string, date("Y-m-d H:i:s") ) );//this will execute that $sql/query in the database and pass $poster, $string, date("Y-m-d H:i:s") in place of the '?'s' respectively 
	}
	
	/**
	Returns all of the messages from all of those
	followed by the specified user, most recent   first
	*/
	public function getFollowedMessages($name)
	{
		$sql = 'SELECT * FROM Messages JOIN User_Follows ON  followed_username = user_username WHERE follower_username = ?  ORDER BY posted_at DESC';//this will assign a sql query to a var $sql which basically says 'Get everything from the table Messages and join a another table with it User_Follows on followed_username = user_username where follower_username = ?  and order them in descending order according to posted_at (here ? is used as placeholder to prevent sql injection. line 29)'
		$query = $this->db->query($sql, array($name));//this will execute that $sql/query in the database and pass $name in place of the '?' and assign the returned data to the var $query
		return $query->result_array();// returns an array-of-arrays, where the inner array elements are named after the columns of the database 
		
	}//end of the function getFollowedMessages()
	
	
	
}//end of the class



?>