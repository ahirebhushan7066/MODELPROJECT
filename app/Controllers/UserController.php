<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function save()
    {
        $user = new UserModel();

        $user->save([
            'email' => 'test@gmail.com',
            'password' => '123456'
        ]);

        return "UserSave";
    }
    public function index()
    {
        $user = new UserModel();

        $data['users'] = $user->findAll();

        return view('users', $data);
    }
    public function show($id)
    {
        $user = new UserModel();

        print_r($user->find($id));
    }
    public function edit($id)
    {
        $user = new UserModel();

        $user->update($id, [
            'email' => 'update@gmail.com'
        ]);
        return "user Updated";
    }
    public function delete($id)
    {
        $user = new UserModel();

        $user->delete($id);

        return "User Deleted";
    }
}
