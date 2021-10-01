<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {
    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('register');
        $this->load->view('template/footer');
    }

    public function register_user() 
    {
        $this->load->helper('string');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->view('template/header');
        $this->load->helper('security'); 
        $this->form_validation->set_rules('register_username', 'Username', 'trim|is_unique[users.username]|xss_clean');
        $this->form_validation->set_rules('register_password', 'Password', 'required|callback_strong_password|min_length[7]|max_length[15]|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[register_password]|xss_clean'); 
        $this->form_validation->set_rules('register_email', 'Email', 'trim|required|valid_email|is_unique[users.email]|xss_clean');

        $encrypted_pass = $this->encryption->encrypt($this->input->post('register_password'));
        $verification_key = md5(random_string('alnum',4));
        $userData = array( 
            'username' => strip_tags($this->input->post('register_username')), 
            'password' => $encrypted_pass, 
            'email' => strip_tags($this->input->post('register_email')), 
            'status' => 0,
            'email_token' => $verification_key,
        );

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('register');
        } else {
            $this->load->helper('captcha');
            $this->load->model('user_model');	
            if($this->user_model->register($userData)) {

                $subject = "Verify email for login";
                $message = "
                <p>Hi ".$this->input->post('register_username')."</p>
                <p>This is email verification mail from StudenTube. For complete registration process, please verify you email by clicking
                 this <a href='".base_url()."register/verify_email/".$verification_key."'>link</a>.</p>
                <p>Once you click this link your email will be verified and you can login into system.</p>
                <p>Thanks,</p>
                ";
                $config = Array(
                'protocol'  => 'smtp',
                'smtp_host' => 'mailhub.eait.uq.edu.au',
                'smtp_port' => 25,
                'mailtype'  => 'html',
                'charset'    => 'iso-8859-1',
                'starttls' => true,
                'newline' => "\r\n",
                'wordwrap'   => TRUE
                );
                $this->email->initialize($config);
                $this->email->from(get_current_user().'@student.uq.edu.au',get_current_user());
                $this->email->to(strip_tags($this->input->post('register_email')));
                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();

                $data['error']= "<script>alert('Your account has been created successfully please login and verify your email using the link sent to your email');</script>";
                $config = array(
                    'img_path'      => './assets/captcha_images/',
                    'img_url'       => base_url('assets').'/captcha_images/',
                    'font_path'     => 'system/fonts/texb.ttf',
                    'img_width'     => '160',
                    'img_height'    => 50,
                    'word_length'   => 5,
                    'font_size'     => 18
                );
                
                $captcha = create_captcha($config);
                                        
                // Unset previous captcha and set new captcha word
                $this->session->unset_userdata('captchaCode');
                $this->session->set_userdata('captchaCode', $captcha['word']);
                                        
                // Pass captcha image to view
                $data['captchaImg'] = $captcha['image'];	
                $this->load->view('login',$data);
            }
            else {
                $data['error'] = 'Some problems occured, please try again.'; 
            }
        }
        $this->load->view('template/footer');
    }

    public function strong_password($password)
    {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        
        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            $this->form_validation->set_message('strong_password', 
            '<p> At least 8 characters—the more characters, the better <br>
            A mixture of both uppercase and lowercase letters <br>
            A mixture of letters and numbers <br>
            Inclusion of at least one special character, e.g., ! @ # ? ] <p>');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function verify_email()
    {
        if($this->uri->segment(3))
        {
            $this->load->model('user_model');
            $verification_key = $this->uri->segment(3);
            if($this->user_model->verify_email($verification_key))
            {
                $data['message'] = '<h1 align="center">Your Email has been successfully verified, now you can login from <a href="'.base_url().'login">here</a></h1>';
            }
            else
            {
                $data['message'] = '<h1 align="center">Invalid Link</h1>';
            }
            $this->load->view('template/header');
            $this->load->view('email_verification', $data);
            $this->load->view('template/footer');
        }
    }
}
?>