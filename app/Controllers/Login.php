<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Login extends Controller {
    public function index() {
        return view('login');
    }

    public function auth() {
        $session = session();
        $model = new UserModel();
        
        $idInput = strtolower($this->request->getVar('username'));
        $password = $this->request->getVar('password');
        
        $user = $model->where('id_number', $idInput)->first();

        if($user) {
            if($password === $user['password']) {
                $ses_data = [
                    'id'          => $user['id'],
                    'name'        => $user['full_name'],
                    'course'      => $user['course'], 
                    'id_number'   => $user['id_number'],
                    'role'        => $user['role'],
                    'profile_pic' => $user['profile_pic'], // <--- ADD THIS LINE
                    'isLoggedIn'  => TRUE
                ];
                $session->set($ses_data);
                
                return ($user['role'] == 'admin') 
                    ? redirect()->to(base_url('admin/dashboard')) 
                    : redirect()->to(base_url('student/dashboard'));
            } else {
                return redirect()->back()->with('msg', 'Wrong Password');
            }
        } else {
            return redirect()->back()->with('msg', 'ID Number not found');
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}