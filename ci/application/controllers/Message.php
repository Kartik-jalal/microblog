<?php
/**
defined('BASEPATH') OR exit('No direct script access allowed'); is used to make sure that the request has gone through index.php in root dir.
 This is for reasons such as making sure that all Codeigniter base classes are being loaded and making sure certain vars have been set
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
		
		/**
	      Consrtuctor of the class
	    */
		public function __construct()
		{
		parent::__construct();  //call the constuctor of the parent class/super class(CI_Controller)
		
		$this->load->library('session');// loads the library 'session' and make it available for every method inside this class
		$this->load->helper('url'); // loads the helper 'url' and make it available for every method inside this classm and also for "View"
		}
		
		
		/**
		Redirects to /user/login if not logged in.
		Displays the Post view 
		*/
		public function index()
		{
			if(isset($_SESSION['Username'])){//check first if their is a session/someone is logged-in 
				$this->load->view('Post');//just loads the view 'Post'
			}
			else {//if their is no session/no one logged-in,
				
				redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/login');//redirect to function login, which is in Controller User
			}
			
		}// end of the function index()
		
		
		/**
		Redirects to /user/login if not logged in. 
		Loads the Messages_model, runs the insertMessage 
		function passing the currently logged in user from your 
		session variable, along with the posted message.
		Redirects to /user/view/{username} when done, which 
		show the user’s new post 
		*/
		public function doPost()
		{
			if(!isset($_SESSION['Username'])){//check is their is no session 
				
				redirect( 'http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/login');//redirect to function login, which is in Controller User
			}
			else if( !isset($_POST['string'])){//if the user try to call te method straight from the URI
                redirect( 'http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/Message/index');// redirect to the function index()
			}
			else {// if thier is a session 
				$this->load->model('Messages_model');//loads the model 'Messages_model'
				$this->Messages_model->insertMessage($_SESSION['Username'], $_POST['string']);// call the method 'insertMessage()' in the 'Messages_model' model and pass the $_SESSION['Username'], $_POST['string'] as a parameter to it.
				$name = $_SESSION['Username'];//assign session to $name 
				
				redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/view/' . $name);//redirect to function view, which is in Controller User and pass $name as a parameter
				
			}
		}// end of the function doPost()
		
}//end of the class
?>