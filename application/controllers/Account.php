<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class account extends CI_Controller { 

    public function load_user_data()
    {
        $this->load->model('file_model');
        $this->load->model('user_model');
        $username = $this->session->userdata('username');
        $data['data']= $this->user_model->return_user_data($username);
        $data['avatar_location']= $this->file_model->search_avatar($username);
        $data['profile_pic_error'] = "";
        $data['error'] = "";
        $data['video_preview'] = "";
        $data['video_title'] = "";

        $this->load->view('template/header');
        $this->load->view('account_details',$data);
        $this->load->view('account_avatar', $data);
        $this->load->view('account_change', $data);
        $this->load->view('template/footer');
    }

    public function change_username()
    {
        $this->load->model('file_model');
        $this->load->model('user_model');
        $username = $this->session->userdata('username');
        $data['data']= $this->user_model->return_user_data($username);
        $data['avatar_location']= $this->file_model->search_avatar($username);
        $data['profile_pic_error'] = "";
        $data['error'] = "";

        if($this->input->post('save'))
		{
            $newEmail=$this->input->post('email');
            if(!$this->user_model->change_email($username,$newEmail))
            {
                $data['error'] = "error found please try again";
            }
		}

        $this->load->view('template/header');
        $this->load->view('account_details',$data);
        $this->load->view('account_avatar', $data);
        $this->load->view('account_change', $data);
        $this->load->view('template/footer');
    }

    public function add_video()
    {
        $this->load->model('file_model');
        $this->load->model('user_model');
       
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'mp4|mkv';
		$config['max_size'] = 150000000;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;
        $this->load->library('upload', $config);
        $username = $this->session->userdata('username');
        $data['data']= $this->user_model->return_user_data($username);
        $data['avatar_location']= $this->file_model->search_avatar($username);
        $video = "";
        if($this->upload->do_upload('userfile'))
        {
            $data['profile_pic_error'] = array('error' => 'File upload success. <br/>');
            $this->file_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username'),$this->input->post('video_title'),$this->input->post('desc'));
            $source = sprintf("%s/uploads/%s",base_url(), $this->upload->data('file_name'));
            $video = '<video style="border-radius:20px;max-width:500px;max-height:300px;" controls><source  src="'.$source.'">';
        }  

        $data['profile_pic_error'] = "";
        $data['error'] = $this->upload->display_errors();
        $data['video_preview'] = $video;
        $data['video_title'] = $this->input->post('video_title');

        $this->load->view('template/header');
        $this->load->view('account_details',$data);
        $this->load->view('account_avatar', $data);
        $this->load->view('account_change', $data);
        $this->load->view('template/footer');
    }

    public function add_image()
    {
        $this->load->model('file_model');
        $this->load->model('user_model');
        $config['upload_path']   = './uploads/images/'; 
        $config['allowed_types'] = 'gif|jpg|png'; 
        $config['max_size'] = 150000000;
        $this->load->library('upload', $config);
        $data['video_preview'] = "";
        $data['video_title'] = "";
        if ($this->upload->do_upload('image')) {
          $uploadedImage = $this->upload->data();
          $this->resizeImage($uploadedImage['file_name'],$this->input->post('video_title'));
          unlink("/var/www/htdocs/WISProject/uploads/images/".$uploadedImage['file_name']);
          

          $username = $this->session->userdata('username');
          $data['data']= $this->user_model->return_user_data($username);
          $data['avatar_location']= $this->file_model->search_avatar($username);
          $data['profile_pic_error'] = "";
          $data['error'] = "";
            
          $this->load->view('template/header');
          $this->load->view('account_details',$data);
          $this->load->view('account_avatar', $data);
          $this->load->view('account_change', $data);
          $this->load->view('template/footer');
        } else {
            $username = $this->session->userdata('username');
            $data['data']= $this->user_model->return_user_data($username);
            $data['avatar_location']= $this->file_model->search_avatar($username);
            $data['profile_pic_error'] = "";
            $data['error'] = array('error' => $this->upload->display_errors());

            $this->load->view('template/header');
            $this->load->view('account_details',$data);
            $this->load->view('account_avatar', $data);
            $this->load->view('account_change', $data);
            $this->load->view('template/footer');
        }
    }

    public function resizeImage($filename,$video_title)
    {
        $thumb = explode('.',$filename);
        $thumb_name = $thumb[0].'_thumb';
        $thumb_new = $thumb_name.'.'.$thumb[1];

       $this->file_model->add_thumb($video_title,$thumb_new);

       $source_path = './uploads/images/' . $filename;
       $target_path = './uploads/images/';
       $config_manip = array(
           'image_library' => 'gd2',
           'source_image' => $source_path,
           'new_image' => $target_path,
           'maintain_ratio' => TRUE,
           'create_thumb' => TRUE,
           'thumb_marker' => '_thumb',
           'width' => 150,
           'height' => 150
       );
       $this->load->library('image_lib', $config_manip);
       if (!$this->image_lib->resize()) {
           echo $this->image_lib->display_errors();
       }
       $this->image_lib->clear();
    }
 
    public function upload_profile_pic() 
    {    
        $this->load->model('file_model');
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'mp4|mkv';
		$config['max_size'] = 150000000;
		$config['max_width'] = 1024;
		$config['max_height'] = 768;
        $this->load->library('upload', $config);
        $username = $this->session->userdata('username');
        $data['data']= $this->user_model->return_user_data($username);
        $data['avatar_location']= $this->file_model->search_avatar($username);
        
        if($this->upload->do_upload('file'))
        {
            $data['profile_pic_error'] = array('error' => 'File upload success. <br/>');
            $this->file_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username'));
        } 
        
    }

}
?>