<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reset extends CI_Controller {

    public function index()
    {
        $data['message'] ="";
        $this->load->model('user_model');
        $this->load->view('template/header');
        $this->load->view('enter_email',$data);
        $this->load->view('template/footer');
    }


    public function check_email()
    {
        $email = $this->input->post('email');
        if($this->user_model->check_email($email))
        {
            $this->load->helper('string');
            $verification_key = md5(random_string('alnum',4));
            $this->user_model->update_password_token($email,$verification_key);
            $subject = "Reset password";
            $message = "
            <p>Hi ".$this->session->userdata('username')."</p>
            <p>This is the password reset mail from StudenTube. For complete password reset process, please click
            this <a href='".base_url()."reset/reset_pass/".$verification_key."'>link</a>.</p>
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
            $this->email->to($email);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->send();

            $data['message'] ="";
            $this->load->view('template/header');
            $this->load->view('enter_email',$data);
            $this->load->view('template/footer');
        }
        else
        {
            $data['message'] ="Sorry please try again, the email you entered does not exist";
            $this->load->view('template/header');
            $this->load->view('enter_email',$data);
            $this->load->view('template/footer');
        }
    }

    public function reset_pass()
    {
        if($this->uri->segment(3))
        {
            $this->load->model('user_model');
            $verification_key = $this->uri->segment(3);
            $this->session->set_userdata('ver_code', $verification_key);
            if($this->user_model->check_token($verification_key))
            {
                $data['error'] = "";
                $this->load->view('template/header');
                $this->load->view('reset_password',$data);
                $this->load->view('template/footer');
            }
            else
            {
                $data['message'] ="Sorry please try again, the link has expired";
                $this->load->view('template/header');
                $this->load->view('enter_email',$data);
                $this->load->view('template/footer');
            }
        }
    }

    public function validate_password()
    {
        $this->load->helper('string');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->view('template/header');
        $this->load->helper('security'); 
        $this->load->model('user_model');

        $this->form_validation->set_rules('register_password', 'Password', 'required|callback_strong_password|callback_similar_password|min_length[7]|max_length[15]|xss_clean');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[register_password]|xss_clean'); 

        $data['error'] = "";
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('reset_password',$data);
        } 
        else 
        {
            $data['error'] = "Password change success please login now";
            $this->user_model->reset_password($this->input->post('register_password'),$this->session->userdata('ver_code'));
            $this->load->view('reset_password',$data);
        }
        $this->load->view('template/footer');
    }

    public function similar_password($password)
    {
        $verification_key = $this->session->userdata('ver_code');
        if($this->user_model->similar_pass($password,$verification_key))
        {
            $this->form_validation->set_message('similar_password', 
            '<p> New password cannot be the same as old password<p>');
            return FALSE;
        } else {
            return TRUE;
        }
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
}
