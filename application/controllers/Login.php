<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

	function __construct() {
        parent::__construct();
        
        // Load session library
        $this->load->library('session');
        
        // Load the captcha helper
		$this->load->helper('captcha');
		$this->load->helper('form');
		$this->load->helper('url');
    }


	public function index()
	{

		$data['error']= "";
		// Captcha configuration
		// $config = array(
		// 	'img_path'      => './assets/captcha_images/',
		// 	'img_url'       => base_url('assets').'/captcha_images/',
		// 	'font_path'     => 'system/fonts/texb.ttf',
		// 	'img_width'     => '160',
		// 	'img_height'    => 50,
		// 	'word_length'   => 5,
		// 	'font_size'     => 18
		// );
		
		// $captcha = create_captcha($config);
								
		// Unset previous captcha and set new captcha word
		// $this->session->unset_userdata('captchaCode');
		// $this->session->set_userdata('captchaCode', $captcha['word']);
								
		// // Pass captcha image to view
		// $data['captchaImg'] = $captcha['image'];	
		
 		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$login_token = get_cookie('login_token');
				$details = $this->user_model->get_cookie($login_token);
				$username = $details['username'];
				/* if ( $this->user_model->login($username, $password) )//check username and password correct
				{ */
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$this->load->view('template/header');
					$this->load->view('template/home'); //if user already logined show main page
				/* } */
			}else{
				$this->load->view('template/header');
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			} 
		}else{
			$this->load->view('template/header');
			$this->load->view('template/home'); //if user already logined show main page
		}
		$this->load->view('template/footer'); 
	}
	
	public function check_login()
	{
		$this->load->helper('string');
		$this->load->library('form_validation');
		$this->load->helper('security'); 
		$this->load->model('user_model');		//load user model
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password!! </div> ";
		$this->load->view('template/header');
		$username = $this->input->post('username'); //getting username from login form
		$password = $this->input->post('password'); //getting password from login form
		$remember = $this->input->post('remember'); //getting remember checkbox from login form
		//$inputCaptcha = $this->input->post('captcha');
		//$sessCaptcha = $this->session->userdata('captchaCode');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		
		if(!$this->session->userdata('logged_in')){	//Check if user already login
			if($this->form_validation->run() == TRUE) {
				if ( $this->user_model->login($username, $password) )//check username and password
				{
					$user_data = array(
						'username' => $username,
						'logged_in' => true 	//create session variable
					);
					if($remember) { // if remember me is activated create cookie
/* 						set_cookie("username", $username, '100'); //set cookie username
						set_cookie("password", $password, '100'); //set cookie password
 */
						$login_token = random_string('alnum',4);
						$login_token = $this->encryption->encrypt($login_token);
						$this->user_model->add_cookie($username,$login_token);
						set_cookie("remember", $remember, '500'); //set cookie remember
						set_cookie("login_token",$login_token,'500');
					}	
					$this->session->set_userdata($user_data); //set user status to login in session
					redirect('home'); // direct user home page
				}
				else {
					$data['error']= "";
					
					// Captcha configuration
					// $config = array(
					// 	'img_path'      => './assets/captcha_images/',
					// 	'img_url'       => base_url('assets').'/captcha_images/',
					// 	'font_path'     => 'system/fonts/texb.ttf',
					// 	'img_width'     => '160',
					// 	'img_height'    => 50,
					// 	'word_length'   => 5,
					// 	'font_size'     => 18
					// );
					
					// $captcha = create_captcha($config);
											
					// Unset previous captcha and set new captcha word
					// $this->session->unset_userdata('captchaCode');
					// $this->session->set_userdata('captchaCode', $captcha['word']);
											
					// Pass captcha image to view
					$data['captchaImg'] = $captcha['image'];
					$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
				}
			} else {
				if ($inputCaptcha != $sessCaptcha) {
					$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Error wrong captcha </div> ";
				} else {
					$data['error']= "";
				}
				
						// Captcha configuration
				// $config = array(
				// 	'img_path'      => './assets/captcha_images/',
				// 	'img_url'       => base_url('assets').'/captcha_images/',
				// 	'font_path'     => 'system/fonts/texb.ttf',
				// 	'img_width'     => '160',
				// 	'img_height'    => 50,
				// 	'word_length'   => 5,
				// 	'font_size'     => 18
				// );
				
				// $captcha = create_captcha($config);
										
				// // Unset previous captcha and set new captcha word
				// $this->session->unset_userdata('captchaCode');
				// $this->session->set_userdata('captchaCode', $captcha['word']);
										
				// Pass captcha image to view
				//$data['captchaImg'] = $captcha['image'];
				$this->load->view('login', $data);
			}

		}else{
			{
				redirect('login'); //if user already logined direct user to home page
			}
				$this->load->view('template/footer');
		}
	}


	public function logout()
	{
		$this->session->unset_userdata('logged_in'); //delete login status
		delete_cookie('remember');
		delete_cookie('login_token');
		redirect('login'); // redirect user back to login
	}
}
?>
