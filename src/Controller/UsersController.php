<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        
        // Membenarkan akses ke fungsi login tanpa perlu mendaftar/login masuk dahulu
        if ($this->components()->has('Authentication')) {
            $this->Authentication->allowUnauthenticated(['login']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find()
            ->contain(['Roles']);
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * Login method - BYPASS VERSION UNTUK TESTING VIA PHPMYADMIN (FIXED)
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        
        // 1. Jika user tekan butang LOG MASUK (Post data)
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Ambil input dari form login
            $inputMatrix = isset($data['matrix_id']) ? trim($data['matrix_id']) : '';
            $inputPassword = isset($data['password']) ? trim($data['password']) : '';
            
            // Guna terus $this->Users (Tak perlu fetchModel)
            $user = $this->Users->find()
                ->where([
                    'matrix_id' => $inputMatrix,
                    'password' => $inputPassword // Padanan terus teks biasa '123'
                ])
                ->first();

            // 2. Jika user dijumpai dalam database
            if ($user) {
                // Set identity ke dalam Session secara manual supaya Authentication plugin ingat kita dah login
                $this->Authentication->setIdentity($user);
                
                // Flash mesej berjaya
                $this->Flash->success(__('Selamat Datang Kembali, ' . $user->full_name));

                // Semak role user (Admin = 1, Student = 2) untuk redirect
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
            } else {
                // Jika salah
                $this->Flash->error(__('ID Matrik atau Kata Laluan salah! (Semakan Manual)'));
            }
        }
        
        // Set layout kosong khusus untuk login supaya tak bercampur dengan sidebar
        $this->viewBuilder()->setLayout('ajax'); 
    }

    /**
     * Logout method
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
        }
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Roles']);
        $this->set(compact('user'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', limit: 200)->all();
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', limit: 200)->all();
        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Profile method - DENGAN FIX KEMASKINI SESSION KATA LALUAN DAN NAMA UTK DASHBOARD
     */
    public function profile()
    {
        // 1. Ambil ID user yang tengah login dari session
        $userId = $this->Authentication->getIdentityData('id');
        
        // 2. Cari data user berdasarkan ID
        $user = $this->Users->get($userId);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // FIX 1: Kekalkan password lama jika user tidak isi kata laluan baru
            if (empty($data['password'])) {
                unset($data['password']); // Buang field password dari request supaya CakePHP tak overwrite jadi kosong
            }

            // FIX 2: Pastikan data sedia ada dipadankan kembali, sekat matrix_id & ic_number daripada diubah
            $user = $this->Users->patchEntity($user, $data, [
                'accessibleFields' => ['matrix_id' => false, 'ic_number' => false]
            ]);

            if ($this->Users->save($user)) {
                //refresh session dengan data user yang baru update  

                $this->Flash->success(__('Profil anda berjaya dikemaskini.'));
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('Gagal mengemaskini profil. Sila cuba lagi.'));
        }

        // Hantar entiti $user ke fail View
        $this->set(compact('user'));
    }
    
} 