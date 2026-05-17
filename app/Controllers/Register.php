<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Register extends Controller {

    public function index() {
        return view('register');
    }

    public function save() {
    $model = new UserModel();
    
    $studentId = strtolower($this->request->getVar('username'));
    $email = strtolower($this->request->getVar('email')); // Capture email

    // CHECK: Search for duplicate ID or Email
    $existingUser = $model->where('id_number', $studentId)
                          ->orWhere('email', $email)
                          ->first();
    
    if ($existingUser) {
        $msg = ($existingUser['email'] == $email) ? 'Email is already taken.' : 'ID Number is already registered.';
        return redirect()->back()->withInput()->with('msg', 'Error: ' . $msg);
    }

    // DATA MAPPING: Include the email column
    $data = [
        'full_name'     => $this->request->getVar('full_name'),
       'email'         => $this->request->getVar('email'),
        'course'        => $this->request->getVar('course'), 
        'id_number'     => $studentId, 
        'password'      => $this->request->getVar('password'), 
        'year_level_id' => $this->request->getVar('year_level_id'),
        'role'          => 'student', 
    ];

    if (!$model->insert($data)) {
        return redirect()->back()->withInput()->with('errors', $model->errors());
    }
    
    return redirect()->to(base_url('login'))->with('msg', 'Registration Successful!');
}
}