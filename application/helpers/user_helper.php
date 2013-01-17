<?php
class UserHelper{
        
        static public function loggedIn(){
                $ci       = &get_instance();
                $userData = $ci->session->userdata('user');
                if ($userData['login'] == true){
                                return true;
                }
                return false;
        }
        
        static public function logedUserInfo(){
                $ci       = &get_instance();
                $userData = $ci->session->userdata('user');
                return (object)$userData;
        }
        
        static public function whoAmI(){
                $ci       = &get_instance();
                $userData = $ci->session->userdata('user');
                $userData = (object)$userData;
                if(!empty($userData->id)) {
                        $userData->role = $ci->db->select('role')->from('users')->where('id', $userData->id)->get()->row()->role;
                        
                        switch($userData->role) {
                                case 0:
                                        return 'sadmin';
                                case 1:
                                        return 'admin';
                                case 2:
                                        return 'vmanager';
                                case 3:
                                        return 'user';
                                default:
                                        return 'user';
                        }
                } else {
                        return 'anonim';
                }
        }
}