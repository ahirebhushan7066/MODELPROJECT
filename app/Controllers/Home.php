<?php

namespace App\Controllers;

use App\Models\UserModel;
use Dompdf\Dompdf;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/home/userdata');
    }

    public function userdata()
    {
        $model = new UserModel();

        $data['users'] = $model->findAll();

        return view('users', $data);
    }

    public function savedata()
    {
        try {

            $email    = trim($this->request->getPost('email'));
            $phone    = trim($this->request->getPost('phone'));
            $password = trim($this->request->getPost('password'));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Invalid Email Format'
                ]);
            }

            if (!preg_match('/^[0-9]{10}$/', $phone)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Mobile Number Must Be 10 Digits'
                ]);
            }

            if (strlen($password) < 6) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Password Must Be Minimum 6 Characters'
                ]);
            }

            $model = new UserModel();

            if ($model->where('email', $email)->first()) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Email Already Exists'
                ]);
            }

            if ($model->where('phone', $phone)->first()) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Mobile Number Already Exists'
                ]);
            }

            $model->save([
                'email'    => $email,
                'phone'    => $phone,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'User Added Successfully'
            ]);

        } catch (\Throwable $e) {

            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Internal Server Error'
            ]);
        }
    }

    public function update($id)
    {
        try {

            $email    = trim($this->request->getPost('email'));
            $phone    = trim($this->request->getPost('phone'));
            $password = trim($this->request->getPost('password'));

            $model = new UserModel();

            $existingUser = $model
                ->where('email', $email)
                ->where('id !=', $id)
                ->first();

            if ($existingUser) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Email Already Exists'
                ]);
            }

            $existingPhone = $model
                ->where('phone', $phone)
                ->where('id !=', $id)
                ->first();

            if ($existingPhone) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => false,
                    'message' => 'Mobile Number Already Exists'
                ]);
            }

            $data = [
                'email' => $email,
                'phone' => $phone
            ];

            if (!empty($password)) {
                $data['password'] =
                    password_hash($password, PASSWORD_DEFAULT);
            }

            $model->update($id, $data);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'User Updated Successfully'
            ]);

        } catch (\Throwable $e) {

            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        try {

            $model = new UserModel();

            $model->delete($id);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'User Deleted Successfully'
            ]);

        } catch (\Throwable $e) {

            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function exportExcel()
    {
        $model = new UserModel();

        $users = $model->findAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="users.csv"');

        $file = fopen('php://output', 'w');

        fputcsv($file, ['ID', 'Email', 'Password', 'phone']);

        foreach ($users as $row) {
            fputcsv($file, [
                $row['id'],
                $row['email'],
                $row['password'],
                $row['phone'],
            ]);
        }

        fclose($file);
        exit;
    }
    public function exportPdf()
    {
        $model = new UserModel();

        $data['users'] = $model->findAll();

        $html = view('pdf_users', $data);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream(
            'users.pdf',
            ['Attachment' => false]
        );
    }
}
