<?php
defined('BASEPATH') Or exit('No direct script access allowed');

class ajax extends CI_Controller {
    public function fatch()
    {
        $this->load->model('file_model');
        $output = '';
        $query = '';
        if($this->input->get('query')) {
            $query = $this->input->get('query');
        }
        $data = $this->file_model->fetch_data($query);
        if(!$data == null) {
            echo json_encode ($data->result());        
        } else {
            echo "";
        }
    }

    public function fetch()
    {   
        $this->load->model('file_model');
        if (isset($_GET['term'])) {
            $data = $this->security->xss_clean($_GET['term']);
            $result = $this->file_model->search_files($data);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->title;
                echo json_encode($arr_result);
            }
            
        }
    }
}




?>
