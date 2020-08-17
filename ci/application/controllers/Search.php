<?php
/**
defined('BASEPATH') OR exit('No direct script access allowed'); is used to make sure that the request has gone through index.php in root dir.
 This is for reasons such as making sure that all Codeigniter base classes are being loaded and making sure certain vars have been set
*/
defined('BASEPATH') OR exit('No direct script access allowed');



class Search extends CI_Controller {
        
		/**
	      Consrtuctor of the class
	    */
		public function __Construct()
		{
			 parent::__Construct(); //call the constuctor of the parent class/super class(CI_Controller)
		
			 
			 $this->load->helper('url'); // loads the helper 'url' and make it available for every method inside this classm and also for "View"
		}
		
		
		/**
		 Displays the Search view 
		*/
		public function index()
		{
			
				$this->load->view('Search');//just loads the view 'Search' 
			
		}//end of the function index()
		
		
		/**
		 Loads Messages_model, retrieves search string from GET 
		 parameters, runs searchMessages() and displays the
		 output in the ViewMessages view
		*/
		public function doSearch()
		{
			if(isset($_GET['string'])){//check first if it has recieved any data $_GET['string']. 
				$this->load->model('Messages_model');// loads the model 'Messages_model'
				$data = $this->Messages_model->searchMessages($_GET['string']);//gets the data, returned by the method 'searchMessages()' in the 'Messages_model' model by passing $_GET['string'] as a parameter to it and assign it to '$data'.
			
				if(count($data) == 0){// if thier is no rows conatining that searchMessages. then
					$div = '<div id="theBox">No rows found </div>';//create a variable $div and assign it the String which basically create a div tag with id = 'theBox' and "No rows found" inside the div tag 
					echo '<link rel="stylesheet" type="text/css"  href="http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/css/styling.css">';// just to add some css for $div and the follow button
			         echo $div;// this echo the $div
					return;//and end the method here
				}
			
				$results  = array("results" => $data);//this create an associative-array $results where $data is value and its key is 'results'
				$this->load->view('ViewMessages', $results);//just loads the view 'ViewMessages' and pass the data inside '$results' to 'ViewMessages'
			}
			else{// if some try to access this method stright from the URI
				redirect('http://raptor.kent.ac.uk/proj/co539c/microblog/kj257/index.php/Search/index');// this wil redirect it to index() function
			}
		}//end of the function doSearch()
		

}// end of the class
?>