<?php
/**
defined('BASEPATH') OR exit('No direct script access allowed'); is used to make sure that the request has gone through index.php in root dir.
 This is for reasons such as making sure that all Codeigniter base classes are being loaded and making sure certain vars have been set
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {
		
		/**
	   Consrtuctor of the class
	   */
	    public function __construct()
		{
			parent::__construct();//call the constuctor of the parent class/super class(CI_Controller)
			
			$this->load->database();// loads the database and make it available for every method in this class
			
		}
		
		/**
			just to check if the input(username) by the user for view function
     		is valid or not.
		*/
		public function checkUname($username)
		{
			$sql = 'SELECT * FROM Users WHERE username = ?';//this will assign a sql query to a var $sql which basically says 'Get all the stuff from the table Users where username = ?(here ? is used as placeholder to prevent sql injection. line 19)'
		
		    $query = $this->db->query($sql, array($username));//this will execute that $sql/query in the database and pass $username in place of the first '?' and assign the returned data to the var $query
			$data = $query->result_array();//this returns an array-of-arrays, where the inner array elements are named after the columns of the database and assign it to the var $data
			if(count($data) == 0){//this is to check if there is a user in db where username = $username. And if not the $data(count)(number of rows that specific query have in the db) is always going to be zero
				return false;//return  false
			}
			else {//otherwise, if there is something regarding that query in db, which means there is a user with that username  
				return true;//return true
			}
			
		}//end of the function checkUname()
		
		
		/**
		Returns TRUE if a user exists in the database  
		with the specified username and password,  
		and FALSE if not. 
		*/
		public function checkLogin($username,$password)
		{
			$sql = 'SELECT * FROM Users WHERE username = ? AND password = ?';//this will assign a sql query to a var $sql which basically says 'Get all the stuff from the table Users where username = ? and password = ?(here ?'s are used as placeholder to prevent sql injection. line 38)'
		
		    $query = $this->db->query($sql, array($username, $password));//this will execute that $sql/query in the database and pass $username and $password in place of the '?'s' respectively and assign the returned data to the var $query
			$data = $query->result_array();//this returns an array-of-arrays, where the inner array elements are named after the columns of the database and assign it to the var $data
			if(count($data) == 0){//this is to check if there is a user in db where username = $username and password = $password. And if not the $data(count)(number of rows that specific query have in the db) is always going to be zero
				return false;//return false
			}
			else {//otherwise, if there is something regarding that query in db, which means there is a user with that username and password
				return true;//return true
			}
		
		}//end of the function checkLogin()
		
		
		/**
		 Returns TRUE if $follower is following   $followed, FALSE otherwise
		*/
		public function isFollowing($follower, $followed)
		{
			$sql = 'SELECT * FROM User_Follows WHERE follower_username = ? AND followed_username = ?';//this will assign a sql query to a var $sql which basically says 'Get all the stuff from the table User_Follows where follower_username = ? and followed_username = ?(here ?'s are used as placeholder to prevent sql injection. line 57)'
			
			$query = $this->db->query($sql, array($follower, $followed));//this will execute that $sql/query in the database and pass $follower and $followed in place of the '?'s' respectively and assign the returned data to the var $query
			$data = $query->result_array();//this returns an array-of-arrays, where the inner array elements are named after the columns of the database and assign it to the var $data
			if(count($data) == 0){//this is to check if the current loggend in person is following the person he/she is viewing right now . And if not the $data(count)(number of rows that specific query have in the db) is always going to be zero
				return false;// return false
			}
			else {//if the current logged-in person is folloeing the person he/she is viewing rightnow
				return true;//return true
			}
			
		}//end of the function isFollowing()
		
		
		/**
		Inserts a row into the Following table 
		indicating that the logged-in user follows $followed 
		*/
		public function follow($followed)
		{ 
		    $this->load->library('session');//load the library 'session'  and make anything stored innit availabe for this function 
			
			$sql =  'INSERT INTO User_Follows VALUES (?, ?)';//this will assign a sql query to a var $sql which basically says 'Insert ?'s into the table User_Follows columns respectively(here ?'s are used as placeholder to prevent sql injection. line 77)'
			$this->db->query($sql, array($_SESSION['Username'], $followed) );//this will execute the $sql/query in the database and pass $_SESSION['Username']/person logged in and $followed/the person they want to follow in place of ?'s respectively.
		}//end of the function follow()
		
}//end of the class
?>