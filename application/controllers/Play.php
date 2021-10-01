<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class play extends CI_Controller {

    public function index()
    {
        $this->load->model('file_model');
        $this->load->model('user_model');
        
        if($this->session->userdata('logged_in')){
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->ip_address();
        }
        $filename = $this->session->userdata('file');
        $query = $this->file_model->get_video($filename);
        $data['filename'] = $filename;
        $data['details'] =$query;
        $data['comm'] = '';
                
        $loaded_comments = $this->file_model->get_comment($filename);
        $data['comments'] = $loaded_comments;
        $data['in_watchlist'] = $this->file_model->check_if_in_watchlist($filename,$this->session->userdata('username'));
        $data['likes'] = $this->user_model->count_like($filename);
        $data['dislikes'] = $this->user_model->count_dislike($filename);
        $data['like_status'] = $this->user_model->check_clicked($username,$filename);

        $this->load->view("template/header");
        $this->load->view("play",$data);
        $this->load->view("comments",$data);
        $this->load->view("template/footer");
    }

    public function add_to_watch_list()
    {
        $this->load->model('file_model');
        $this->load->model('user_model');
        $filename = $this->session->userdata('file');
        $username = $this->session->userdata('username');
        $title = $this->file_model->return_title($filename);
        $this->file_model->add_watchlist($filename,$username,$title);

        $query = $this->file_model->get_video($filename);
        $data['filename'] = $filename;
        $data['details'] =$query;
        $data['comm'] = '';
                
        $loaded_comments = $this->file_model->get_comment($filename);
        $data['comments'] = $loaded_comments;
        $data['in_watchlist'] = $this->file_model->check_if_in_watchlist($filename,$this->session->userdata('username'));
        $data['likes'] = $this->user_model->count_like($filename);
        $data['dislikes'] = $this->user_model->count_dislike($filename);
        $data['like_status'] = $this->user_model->check_clicked($username,$filename);

        $this->load->view("template/header");
        $this->load->view("play",$data);
        $this->load->view("comments",$data);
        $this->load->view("template/footer");
    }

	public function load_video($filename) {
        $this->load->model('file_model');
        $this->load->model('user_model');
        if($this->session->userdata('logged_in')){
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->ip_address();
        }
        $this->session->set_userdata('file', $filename);
        $query = $this->file_model->get_video($filename);
        $data['filename'] = $filename;
        $data['details'] =$query;
        $data['comm'] = '';
                
        $loaded_comments = $this->file_model->get_comment($filename);
        $data['comments'] = $loaded_comments;
        $data['in_watchlist'] = $this->file_model->check_if_in_watchlist($filename,$this->session->userdata('username'));
        $data['likes'] = $this->user_model->count_like($filename);
        $data['dislikes'] = $this->user_model->count_dislike($filename);
        $data['like_status'] = $this->user_model->check_clicked($username,$filename);

        $this->load->view("template/header");
        $this->load->view("play",$data);
        $this->load->view("comments",$data);
        $this->load->view("template/footer");
	}


    public function add_comment()
    {
        $filename = $this->session->userdata('file');
        $this->load->model('file_model');
        $this->load->model('user_model');
        if($this->session->userdata('logged_in')){
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->ip_address();
        }
        $query = $this->file_model->get_video($filename);
        $data['filename'] = $filename;
        $data['details'] =$query;
        if(!$this->session->userdata('logged_in')) {
            $this->file_model->add_comment($this->input->ip_address(),$filename,$this->input->post('comments'));
        } else {
            $this->file_model->add_comment($this->session->userdata('username'),$filename,$this->input->post('comments'));
        }
        $this->session->set_userdata('file', $filename);
        redirect('play');
        
        $loaded_comments = $this->file_model->get_comment($filename);
        $data['comments'] = $loaded_comments;
        $data['in_watchlist'] = $this->file_model->check_if_in_watchlist($filename,$this->session->userdata('username'));
        $data['likes'] = $this->user_model->count_like($filename);
        $data['dislikes'] = $this->user_model->count_dislike($filename);
        $data['like_status'] = $this->user_model->check_clicked($username,$filename);

        $this->load->view("template/header");
        $this->load->view("play",$data);
        $this->load->view("comments",$data);
        $this->load->view("template/footer");
    }



    public function like()
    {
        $filename = $this->session->userdata('file');
        $this->load->model('file_model');
        $this->load->model('user_model');
        if($this->session->userdata('logged_in')){
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->ip_address();
        }
        $new_entry = FALSE;
        if(!$this->session->userdata('logged_in')) {
            $username = $this->input->ip_address();
            if(!$this->user_model->check_if_user_already($username,$filename))
            {
                $new_entry = TRUE;
            }
        } else {
            $username = $this->session->userdata('username');
            if(!$this->user_model->check_if_user_already($username,$filename))
            {
                $new_entry = TRUE;
            }
        }

        if($new_entry){
            $this->user_model->add_like($username,$this->session->userdata('file'));
        } else {
            $this->user_model->update_like($username,$this->session->userdata('file'));
        }
        $this->session->set_userdata('file', $filename);
        $query = $this->file_model->get_video($filename);
        $data['filename'] = $filename;
        $data['details'] =$query;
        $data['comm'] = '';
                
        $loaded_comments = $this->file_model->get_comment($filename);
        $data['comments'] = $loaded_comments;
        $data['in_watchlist'] = $this->file_model->check_if_in_watchlist($filename,$this->session->userdata('username'));
        $data['likes'] = $this->user_model->count_like($filename);
        $data['dislikes'] = $this->user_model->count_dislike($filename);
        $data['like_status'] = $this->user_model->check_clicked($username,$filename);

        $this->load->view("template/header");
        $this->load->view("play",$data);
        $this->load->view("comments",$data);
        $this->load->view("template/footer");
    }

    public function dislike()
    {
        $filename = $this->session->userdata('file');
        $this->load->model('file_model');
        $this->load->model('user_model');
        if($this->session->userdata('logged_in')){
            $username = $this->session->userdata('username');
        } else {
            $username = $this->input->ip_address();
        }
        $new_entry = FALSE;
        if(!$this->session->userdata('logged_in')) {
            $username = $this->input->ip_address();
            if(!$this->user_model->check_if_user_already($username,$filename))
            {
                $new_entry = TRUE;
            }
        } else {
            $username = $this->session->userdata('username');
            if(!$this->user_model->check_if_user_already($username,$filename))
            {
                $new_entry = TRUE;
            }
        }

        if($new_entry){
            $this->user_model->add_dislike($username,$this->session->userdata('file'));
        } else {
            $this->user_model->update_dislike($username,$this->session->userdata('file'));
        }
        $this->session->set_userdata('file', $filename);
        $query = $this->file_model->get_video($filename);
        $data['filename'] = $filename;
        $data['details'] =$query;
        $data['comm'] = '';
                
        $loaded_comments = $this->file_model->get_comment($filename);
        $data['comments'] = $loaded_comments;
        $data['in_watchlist'] = $this->file_model->check_if_in_watchlist($filename,$this->session->userdata('username'));
        $data['likes'] = $this->user_model->count_like($filename);
        $data['dislikes'] = $this->user_model->count_dislike($filename);
        $data['like_status'] = $this->user_model->check_clicked($username,$filename);

        $this->load->view("template/header");
        $this->load->view("play",$data);
        $this->load->view("comments",$data);
        $this->load->view("template/footer");

    }
}