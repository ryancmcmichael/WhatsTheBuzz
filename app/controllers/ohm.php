<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ohm extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('ohm/main');
	}
	
	public function opt($option="",$suboption="")
	{
		switch ($option){
			
			case "sites":
			
				if(isset($_SESSION['OHM']))
				{echo "sites list here";}
				else{echo "not authorized";}
			
			break;
			case "login":
				$this->load->view('ohm/login');
			break;
			case "logout":
				$this->load->view('ohm/logout');
			break;
			case "addsite":
				switch($suboption)
				{
					case "profile":
						$this->load->view('ohm/addsite');
					break;
					case "contact":
						echo $suboption;
					break;
					case "url":
						echo $suboption;
					break;
					default:
						header('location:addsite/profile');
					break;
				}
			break;
		default:
		echo $option . " " . $suboption;
		break;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */