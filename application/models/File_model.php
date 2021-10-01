<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here 
 class File_model extends CI_Model{

    // upload file
    public function upload($filename, $path, $username, $title, $description){

        $data = array(
            'filename' => $filename,
            'path' => $path,
            'username' => $username,
            'description' => $description,
            'title' => $title
        );
        $query = $this->db->insert('files', $data);

    }

    public function check_if_in_watchlist($filename,$username)
    {
        $this->db->where('filename',$filename);
        $this->db->where('username',$username);
        $query = $this->db->get('watch_list');
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function add_watchlist($filename,$username,$title)
    {
        $data = array(
            'filename' => $filename,
            'username' => $username,
            'title' => $title
        );
        $query = $this->db->insert('watch_list', $data);
    }

    public function return_title($filename)
    {
        $this->db->where('filename',$filename);
        $query = $this->db->get('files');
        $ret = $query->row();
        return $ret->title;
    }

    public function load_watchlist($username)
    {
        $this->db->where('username',$username);
        $query = $this->db->get('watch_list');
        $row_array = $query->result_array();
        return $row_array;
    }

    public function remove_comment($filename)
    {
        $this->db->where('filename', $filename);
        $this->db->delete('watch_list');
    }

    public function add_comment($username,$filename,$comment)
    {
        $data = array(
            'username' => $username,
            'filename' => $filename,
            'comment' => $comment
        );
        $query = $this->db->insert('comments', $data);
    }

    public function get_comment($filename)
    {
        $this->db->where('filename',$filename);
        $query = $this->db->get('comments');
        $row_array = $query->result_array();
        return $row_array;
    }


    public function get_rows()
    {
        $this->db->select('*');
        $this->db->from('files');
        $this->db->limit(6);
        $query = $this->db->get();
        return $query;
    }

    public function get_video($filename)
    {
        $this->db->where('filename',$filename);
        $query = $this->db->get('files');
        $row = $query->row_array();
        return $row;
    }


    public function add_thumb($video_title,$thumb_name)
    {
        $this->db->query("UPDATE files SET thumb_name='$thumb_name' WHERE title='$video_title'");
    }


    function fetch_data($query)
    {
        if($query == '')
        {
            return null;
        }else{
            $this->db->select("*");
            $this->db->from("files");
            $this->db->like('filename', $query);
            $this->db->or_like('username', $query);
            $this->db->order_by('filename', 'DESC');
            return $this->db->get();
        }
    }

    function search_files($query){
        $this->db->like('title', $query,'both');
        $this->db->order_by('title', 'ASC');
        return $this->db->get('files')->result();
    }

    function search_avatar($username){
        $this->db->where('username', $username);
        $q = $this->db->get('profile_pic'); 
        $row = $q->row_array();
        return $row;
    }

    function update_insert_avatar($filename, $path, $username) 
    {
        $this->db->where('username',$username);
        $q = $this->db->get('profile_pic');
        if ( $q->num_rows() > 0 ) 
        {
            $value=array('filename'=>$filename,'path'=>$path);
            $this->db->where('username',$username);
            $this->db->update('profile_pic',$value);
        } else {
            $array = array(
                'username' => $username,
                'path' => $path,
                'filename' => $filename
            );
            $this->db->insert('profile_pic',$data);
        }
    }

    

}
?>