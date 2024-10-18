<?php

namespace App\Controllers;


use App\Models\UserModel;
use App\Models\AdminModel;


class Auth extends BaseController
{
    protected $users;
    protected $session;
    protected $client;
    public function __construct()
    {
        $this->users = new UserModel();
        $this->session = \Config\Services::session();
        $this->client = \Config\Services::curlrequest();
    }
    public function index()
    {
        return view('pages/login/signin');
    }
    // public function login()
    // {
    //     $data = [];

    //     if ($this->request->getPost()) {
    //         // Validasi input
    //         $rules = [
    //             'username' => 'required',
    //             'password' => 'required',
    //         ];

    //         if ($this->validate($rules)) {
    //             $username = $this->request->getPost('username');
    //             $password = $this->request->getPost('password');

    //             // Buat instance model UserModel dan AdminModel
    //             $userModel = new UserModel();
    //             $adminModel = new AdminModel();

    //             // Cari user dan admin berdasarkan username
    //             $user = $userModel->where('username', $username)->first();
    //             $admin = $adminModel->where('username', $username)->first();

    //             // Periksa apakah login sebagai user atau admin berhasil
    //             if ($user && password_verify($password, $user['password'])) {
    //                 session()->set('user_nama', $user['username']);
    //                 session()->set('user_id', $user['id']);
    //                 session()->set('user_suplier', $user['suplier']);
    //                 return redirect()->to(base_url('/dashboard'));
    //             } elseif ($admin && password_verify($password, $admin['password'])) {
    //                 session()->set('admin_nama', $admin['username']);
    //                 session()->set('admin_id', $admin['id']);
    //                 session()->set('admin_role', $admin['role']);
    //                 return redirect()->to(base_url('/dashboard-admin'));
    //             } else {
    //                 session()->setFlashdata('gagal', 'Username atau password salah.');
    //                 return redirect()->to(base_url('/'));
    //             }
    //         } else {
    //             session()->setFlashdata('gagal', 'Silakan isi semua data yang diperlukan.');
    //             return redirect()->to(base_url('/'));
    //         }
    //     }

    //     return view('pages/login/signin', $data);
    // }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Mode login melalui API
        $response = $this->client->request('POST', 'https://portal3.incoe.astra.co.id/production_control_v2/public/api/login', [
            'form_params' => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        $status = $response->getStatusCode();
        $body = $response->getBody();

        if ($status == 200) {
            $data = json_decode($body, true);

            if (!empty($data)) {
                $npk_admin = [3651, 3650, 570];

                if (in_array($data['npk'], $npk_admin)) {
                    $role = 'admin';
                } else {
                    $role = 'reader';
                }
                $session_data = [
                    'username' => $data['username'],
                    'admin_nama' => $data['nama'],
                    'admin_id' => $data['npk'],
                    'role' => $role,
                    'id_divisi' => $data['id_divisi'],
                    'divisi' => $data['divisi'],
                    'id_departement' => $data['id_departement'],
                    'departement' => $data['departement'],
                    'id_section' => $data['id_section'],
                    'section' => $data['section'],
                    'id_sub_section' => $data['id_sub_section'],
                    'sub_section' => $data['sub_section'],
                    'kode_jabatan' => $data['kode_jabatan'],
                    'is_login' => true
                ];
                $this->session->set($session_data);

                return redirect()->to(base_url('dashboard-admin'));
            } else {
                // Jika respons kosong, lakukan pengecekan login dari model lokal
                $data = $this->users->cek_login($username, $password);

                if (!empty($data)) {
                    $session_data = [
                        'username' => $data['username'],
                        'user_nama' => $data['username'],
                        'user_id' => $data['id'],
                        'user_suplier' => $data['suplier'],
                        'role' => 'user',
                        'is_login' => true
                    ];
                    $this->session->set($session_data);

                    return redirect()->to(base_url('dashboard'));
                } else {
                    // Jika login dari model lokal juga gagal
                    session()->setFlashdata('gagal', 'Username atau password salah.');
                    return redirect()->to(base_url('/'));
                }
            }
        } else {
            // Jika login API gagal
            session()->setFlashdata('gagal', 'Username atau password salah.');
            return redirect()->to(base_url('/'));
        }
    }

    public function register()
    {
        return view('pages/login/signup'); // Ganti 'auth/register' dengan nama view registrasi yang sesuai
    }

    public function register_action()
    {
        if (session()->get('role') != 'admin') {
            session()->setFlashdata('gagal', 'You dont have access');
            return redirect()->to(base_url('register/suplier'));
        } else {
            $userModel = new UserModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $role = 'user';
            $suplier = $this->request->getPost('suplier');
            $address = $this->request->getPost('address');

            // Validasi input
            if (empty($username) || empty($password) || empty($role) || empty($suplier) || empty($address)) {
                session()->setFlashdata('gagal', 'Isi semua data!');
                return redirect()->to(base_url('register/suplier'));
            }

            // Cek apakah username sudah terdaftar
            if ($userModel->where('username', $username)->countAllResults() > 0) {
                session()->setFlashdata('gagal', 'Username sudah terdaftar, gunakan username lain.');
                return redirect()->to(base_url('register/suplier'));
            }

            // Hash password
            $hashedPassword = password_hash((string)$password, PASSWORD_DEFAULT);

            // Menyimpan data pengguna ke database
            $userData = [
                'username' => $username,
                'password' => $hashedPassword,
                'role' => $role,
                'suplier' => $suplier,
                'address' => $address
            ];

            $userModel->insert($userData);

            session()->setFlashdata('sukses', 'Registrasi berhasil!');
            return redirect()->to(base_url('register/suplier')); // Kembali ke halaman register
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
