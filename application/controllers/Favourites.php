<?php
class favourites extends CI_Controller {

        public function index()
        {
            $this->load->model('file_model');
            $watch_list = $this->file_model->load_watchlist($this->session->userdata('username'));
            $data['watch_list'] = $watch_list;

            $this->load->view("template/header");
            $this->load->view("favourites",$data);
            $this->load->view("template/footer");
        }

        public function remove_video()
        {
            $this->load->model('file_model');
            $this->file_model->remove_comment($this->input->post('filename'));

            
            $watch_list = $this->file_model->load_watchlist($this->session->userdata('username'));
            $data['watch_list'] = $watch_list;

            $this->load->view("template/header");
            $this->load->view("favourites",$data);
            $this->load->view("template/footer");
        }
}