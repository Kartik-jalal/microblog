<?php
/**
defined('BASEPATH') OR exit('No direct script access allowed'); is used to make sure that the request has gone through index.php in root dir.
 This is for reasons such as making sure that all Codeigniter base classes are being loaded and making sure certain vars have been set
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	/**
	   Consrtuctor of the class
	*/
	public function __construct()
	{
		parent::__construct();//call the constuctor of the parent class/super class(CI_Controller)
		
		
		$this->load->library('session');// loads the library 'session' and make it available for every method inside this class
		$this->load->helper('url'); // loads the helper 'url' and make it available for every method inside this classm and also for "View"
		
	}
	
	
	/**
	Loads Messages_model, runs getMessagesByPoster()
	passing the specified name, and displays output in the
	ViewMessages view And also
	Adds a “follow”   button or link if, after loading Users_model, the
	isFollowing() function indicates the currently logged
	in user (from your login session variable) isn’t 
	following the viewed user. This link  point to  
	user/follow/ 
	*/
	public function view($userName = null)
	{
	    
		if($userName == null) {//if no input is provided 
			$div = "<div id='invalid'> Please input a UserName first </div> <br/>";//create a variable $div and assign it the String which basically create a div tag with id = 'invaid' and "Please input a UserName first" inside the div tag and break-line at the end 
			echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $div
			echo $div; // echo this
			return; //And end the whole methode
		}
		else { // if the above condition is false, then
		    
				$this->load->model('Users_model');//loads the model 'Users_model'.
				$checkUname = $this->Users_model->checkUname($userName);//gets the data, returned by the method 'checkUname()' in the 'Users_model' model and assign it to '$checkUname'.
				
					if(!$checkUname) { //If the returned data is false, i.e, the input ($userName) is invalid
						$span = "<span id='invalid'> Thier is no User of this username</span>";//create a variable $span and assign it the String which basically create a span tag with id = 'invaid' and "Thier is no User of this username" inside the span tag 
						$span .= "  $userName . ";//add $username to $span
						$span .= "<span id='invalid'> . Please type a valid username. </span>";//create a variable $span and add it the String which basically create a span tag with id = 'invaid' and ". Please type a valid username" inside the span tag 
						
						echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $span
						echo $span; // echo this
						return;// And end the whole method.
					}
					else { //If the returned data is true, then
						$this->load->model('Messages_model');// loads the model 'Messages_model'
						$data  = $this->Messages_model->getMessagesByPoster($userName); //gets the data, returned by the method 'getMessagesByPoster()' in the 'Messages_model' model and assign it to '$data'. then,
					}
		}
		
		
		
		$results = array('results' => $data);// assign the '$data' to an associative-array '$results' where '$data' id/key is 'results'
			
		//if someone is already logged-in and the input/username they provided for this function is a different user then it will run this if-statement	
		if(isset($_SESSION['Username']) && $_SESSION['Username'] != $userName) {
					$this->load->model('Users_model');// loads the model 'Users_model'
					$check = $this->Users_model->isFollowing($_SESSION['Username'], $userName);// gets the data, returned by the method 'isFollowing()' in the 'Users_model' model and assign it to '$check'. then,
					
					if(!$check) { // the current logged in person is not following the user they are viewing right now, then it will run this if-statement.
							$this->load->helper('form');//loads the helper 'form'
							//$follow is an associative-array. It will help in creating HTML-form button because the key and the value here are attributes and their values for the button
							$follow = array('name' => 'follow', // name of that button
											'id' => 'follow',//id of that button
											'type' => 'submit',//type of that button
											'content' => 'Follow');// content of that button
				
							echo form_open('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/follow/'. $userName);	// this will create and echo a HTML-form tag and make the 'action'= user/follow($userName) of that form tag		
							echo form_button($follow);// create and echo a HTML-form button having the attributes described inside the $follow associative-array
						
								if(count($data) != 0){// if the username have rows/posts
										$this->load->view('ViewMessages', $results);//loads the view 'ViewMessages' and pass the data inside '$results' to 'ViewMessages'
								}
								else {//if the username have no rows/posts, so that the logged-in person can still follow them
									$div = '<div id="theBox">No rows found </div>';//create a variable $div and assign it the String which basically create a div tag with id = 'theBox' and "No rows found" inside the div tag 
									echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $div and the follow button
			                        echo $div;// this echo the $div
								}
					} 
				    else if(count($data) != 0) { //if the current logged-in person is  following the user they are viewing right now, then it will run this 
					    $this->load->view('ViewMessages', $results); //just loads the view 'ViewMessages' and pass the data inside '$results' to 'ViewMessages', without follow button.
			        }
					else if(count($data) == 0) {
						$div = '<div id="theBox">No rows found </div>';//create a variable $div and assign it the String which basically create a div tag with id = 'theBox' and "No rows found" inside the div tag 
						echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $div
			             echo $div;// this echo the $div
					}
					return;
		}
			// if thier is no one is logged-in rigth now and the input/username have rows/posts, then
		else if(count($data) != 0){
				$this->load->view('ViewMessages', $results);//just loads the view 'ViewMessages' and pass the data inside '$results' to 'ViewMessages' 
		}	
		else if(count($data) == 0) {// if the is input/username have no rows/posts, then
			$div = '<div id="theBox">No rows found </div>';//create a variable $div and assign it the String which basically create a div tag with id = 'theBox' and "No rows found" inside the div tag 
			echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $div
			echo $div;// this echo the $div
		}
			
		
	}// end of the function view()
	
	
	/**
	Displays the Login view 
	*/
	public function login()
	{
		
		if(isset($_SESSION['Username'])) {//check first if thier already a session or not 
			redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/view/' . $_SESSION['Username']);//if someone is already logged-in then it redirect to the view() function in this controller and pass $_SESSION['Username'] as a parameter to it
		}
		else {//if no one is logged in 
			
		$div = "<div id='greet'>";//create a variable and assign a String to it which is basically a div-start tag with id 'greet'
			$time = date("H");//this variable will contain the current time in hour hand(24-type not 12-type)
				if($time < 12) {
					$div .= "Good Morning!";//if it's morning it will add "Good Morning!" to $div
				}
				else if($time >= 12 && $time < 17) {
					$div .=  "Good Afternoon!";//if it's afternoon it will add "Good Afternoon!" to $div
				}
				else {
					$div .=  "Good Evening!";//if it's evening it will add "Good Evening!" to $div
				}
		$div .= "</div><br/>";	//this will add "</div><br/>" which basically close the open div tag at the start and put a break-line
		$data = array();//create a array $data
		$data['div'] = $div;//assign $div to $data at the key div
			$this->load->view('Login', $data);//just loads the view 'Login' and pass the data inside '$data' to 'Login'
		}
	}// end of the function login()
	
	
	/**
	 Loads the Users_model, calls checkLogin() passing
	 POSTed user/pass & either re-displays Login view with 
	 error message, or redirects to the user/view/{username}
	 controller to view their messages. If login is successful, a 
	 session variable containing the username is set.
	*/
	public function doLogin()
	{
		if(isset($_POST['username'])){//check first if it has recieved any data $_POST['username']. do i also need || $_SESSION['Username'] here ? because of the way URI works here
				$this->load->model('Users_model');// loads the model 'Users_model'
				$data = $this->Users_model->checkLogin($_POST['username'], sha1($_POST['password'])); // gets the data, returned by the method 'checkLogin()' in the 'Users_model' model and assign it to '$data'. then,
		
			if($data) {//if the returned $data is true i.e, the cridientials are right
					$_SESSION['Username'] = $_POST['username'];//create a session of that username
					
					redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/view/' . $_SESSION['Username']);//here, it redirect to view() function and pass $_SESSION['Username'] as a parameter
			}
		
			else if(!$data){//if the returned data is false i.e, the cridientials are wrong
				$div = "<div id='invalid'> Invalid Username or Password </div> <br/>"; //create a variable $div and assign it the String which basically create a div tag with id = 'invaid' and "Invalid Username or Password" inside the div tag and break-line at the end 
			     $data = array();//create an array $data
				 $data['div'] = $div;//assign $div to $data at the key div
				 $this->load->view('Login', $data);//just loads the view 'Login' and pass the data inside '$data' to 'Login'
		
				
			}
		}
	    else//if someone straight call this method through the URL and thier is no session 
		{
			
			redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/login');//it redirect to the login() function
		}
	}// end of the function doLogin()
	
	
	/**
	Logs the user out, clearing their session variable, and
    redirects to /user/login 
	*/
	public function logout()
	{
		 unset($_SESSION['Username']);// unset the session i.e, logout the user
		 redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/login');// redirect to login() function
	}// end of the function logout()
	
	
	/**
	Loads the Users_model, and invokes the follow()
	function to add the entry into the database table.
	Should redirect back to the /user/view/{followed} 
	page when done 
	*/
	public function follow($followed)
	{
		$this->load->model('Users_model');// loads the model 'Users_model'
		$this->Users_model->follow($followed);// call the method 'follow()' in the 'Users_model' model and pass the $followed parameter to it.
		redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/user/view/' . $followed);//redirect to view() function and pass $followed parameter to it
	}//end of the method follow()
	
	
	/**
	Loads the Messages_model, invokes the
	getFollowedMessages() function, and puts the
	output into the ViewMessages view. 
	*/
	public function feed($name = null)
	{
		if($name == null && isset($_SESSION['Username'])){// check if no paramter is passed to the function and if their is session/someone logged-in or not
			$this->load->model('Messages_model');//load the model 'Messages_model'
			$data = $this->Messages_model->getFollowedMessages($_SESSION['Username']); //gets the data, returned by the method 'getFollowedMessages()' in the 'Messages_model' model by passing $_SESSION['Username'] as a parameter to it and assign it to '$data'.
		}
		else if($name != null) {// check if a parameter is passed to the function
			$this->load->model('Messages_model');//load the model 'Messages_model'
				$data = $this->Messages_model->getFollowedMessages($name);//gets the data, returned by the method 'getFollowedMessages()' in the 'Messages_model' model by passing $name as a parameter to it and assign it to '$data'.
		}
		else {// if no parameter is passed to this function and their is no session/logged-in
		     $span = '<span id="invalid">Please first input a User Name or login first</span>';//create a variable $span and assign it the String which basically create a span tag with id = 'invaid' and "Please first input a User Name or login first" inside the span tag 
			 echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $span
			   echo $span;//it echo "Please first input a User Name or login first"
			
			return;//end the method here
		}
		   $results = array('results' => $data);//this create an associative-array $results where $data is value and its key is 'results'
			$this->load->view('ViewMessages', $results);//just loads the view 'ViewMessages' and pass the data inside '$results' to 'ViewMessages'
	}//end of the method feed()
		

	
}// end of the class 

?>