
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class User_model extends CI_Model{

    // Log in
    public function login($username, $password) {
        // Validate
        $this->db->where('username', $username);
        $q = $this->db->get('users');
        $row = $q->row_array();
        $encrypt_password = $row['password'];
        $decrypt_password = $this->encryption->decrypt($encrypt_password);
        if($password == $decrypt_password){
            return true;
        } else {
            return false;
        }
    }

    public function register($data) {
        if(!empty($data)) {
            $this->db->insert('users',$data);
            return true;
        } else {
            return false;
        }
    }

    public function verify_email($key) 
    {
        $this->db->where('email_token',$key);
        $this->db->where('status',0);
        $query = $this->db->get('users');
        if($query->num_rows() > 0)
        {
            $data = array(
            'status'  => 1
            );
            $this->db->where('email_token',$key);
            $this->db->update('users', $data);
            return true;
        } else {
            return false;
        }
    }

    public function update_password_token($email,$token) 
    {
        $this->db->query("UPDATE users SET reset_token='$token' WHERE email='$email'");
    }

    public function check_token($token)
    {
        $this->db->where('reset_token',$token);
        $query = $this->db->get('users');
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function similar_pass($password,$verification_key)
    {
        $this->db->where('reset_token',$verification_key);
        $query = $this->db->get('users');
        $ret = $query->row_array();
        $db_password =  $ret['password'];
        $decrypt_password = $this->encryption->decrypt($db_password);
        $db_token =  $ret['reset_token'];
        echo "<script>console.log(".json_encode($decrypt_password).")</script>";
        echo "<script>console.log(".json_encode($password).")</script>";
        echo "<script>console.log(".json_encode($db_token).")</script>";
        echo "<script>console.log(".json_encode($verification_key).")</script>";
        if($password == $decrypt_password && $verification_key == $db_token)
        {
            return true;
        } else {
            return false;
        }
    }

    public function reset_password($password,$verification_key) 
    {
        $encrypt_password = $this->encryption->encrypt($password);
        $this->db->query("UPDATE users SET password='$encrypt_password' WHERE reset_token='$verification_key'");
    }

    
    public function check_email($email)
    {
        $this->db->where('email',$email);
        $query = $this->db->get('users');
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }


    public function change_email($username,$newEmail) 
    {
        $this->db->query("UPDATE users SET email='$newEmail' WHERE username='$username'");
        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function add_cookie($username,$cookie)
    {
        $this->db->query("UPDATE users SET login_cookie='$cookie' WHERE username='$username'");
    }

    public function get_cookie($cookie) 
    {
        $this->db->where('login_cookie', $cookie);
        $q = $this->db->get('users'); 
        $row = $q->row_array();
        return $row;
    }

    public function return_user_data($username) {
        $this->db->where('username', $username);
        $q = $this->db->get('users'); 
        $row = $q->row_array();
        return $row;
    }

    public function count_dislike($filename)
    {
        $this->db->where('filename',$filename);
        $this->db->where('disliked',1);
        $query = $this->db->get('like_dislike');
        return $query->num_rows();
    }

    
    public function count_like($filename)
    {
        $this->db->where('filename',$filename);
        $this->db->where('liked',1);
        $query = $this->db->get('like_dislike');
        return $query->num_rows();
    }

    public function check_if_user_already($username,$filename)
    {
        $this->db->where('username', $username);
        $this->db->where('filename',$filename);
        $query = $this->db->get('like_dislike');
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function check_clicked($username,$filename)
    {
        $this->db->where('username', $username);
        $this->db->where('filename',$filename);
        $query = $this->db->get('like_dislike');
        $row = $query->row_array();
        return $row;
    }

    public function add_like($username,$filename)
    {
        $data = array(
            'liked' => 1,
            'disliked' => 0,
            'username' => $username,
            'filename' => $filename
        );
        $query = $this->db->insert('like_dislike', $data);
    }

    public function add_dislike($username,$filename)
    {
        $data = array(
            'liked' => 0,
            'disliked' => 1,
            'username' => $username,
            'filename' => $filename
        );
        $query = $this->db->insert('like_dislike', $data);
    }

    public function update_like($username,$filename)
    {
        $data = array(
            'liked' => 1,
            'disliked' => 0
    );
    
        $this->db->where('username', $username);
        $this->db->where('filename', $filename);
        $this->db->update('like_dislike', $data);
    }

    public function update_dislike($username,$filename)
    {
        $data = array(
            'liked' => 0,
            'disliked' => 1
    );
    
        $this->db->where('username', $username);
        $this->db->where('filename', $filename);
        $this->db->update('like_dislike', $data);
    }

}


