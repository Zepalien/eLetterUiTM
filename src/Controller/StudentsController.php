<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Students Controller
 *
 * Menguruskan rekod pelajar menggunakan model Users (role_id = 2)
 */
class StudentsController extends AppController
{
    /**
     * Set secara spesifik model utama sebagai Users bagi mengelakkan isu nama hilang (Null Entity)
     */
    protected ?string $defaultTable = 'Users';

    /**
     * Index method - Senarai Pelajar (role_id = 2)
     */
   public function index()
{
    // 1. Ambil kata kunci carian
    $search = $this->request->getQuery('search');
    
    // 2. Bina query asas untuk peranan pelajar (role_id = 2)
    $query = $this->Users->find()->where(['Users.role_id' => 2]);

    // 3. Kira JUMLAH KESELURUHAN pelajar (sebelum ditapis oleh fungsi limit 5 paginator)
    $totalStudents = $query->count();

    // 4. Lakukan tapisan sekiranya pengguna menggunakan kotak carian (Search)
    if (!empty($search)) {
        $query->where([
            'OR' => [
                'Users.full_name LIKE' => '%' . $search . '%',
                'Users.matrix_id LIKE' => '%' . $search . '%',
                'Users.faculty LIKE' => '%' . $search . '%',
                'Users.email LIKE' => '%' . $search . '%',
            ]
        ]);
        // Kemas kini jumlah sekiranya carian aktif untuk paparan realistik
        $totalStudents = $query->count();
    }

    // 5. Konfigurasi Pagination dan Sorting Dinamik
    $this->paginate = [
        'limit' => 5,
        'order' => ['Users.id' => 'DESC'],
        'sortableFields' => ['id', 'matrix_id', 'full_name', 'email', 'faculty']
    ];
    
    $students = $this->paginate($query);

    // 6. Hantar totalStudents ke dalam view
    $this->set(compact('students', 'search', 'totalStudents'));
}
    /**
     * View method - Papar Maklumat Profil Penuh Pelajar beserta Sejarah Surat
     */
    public function view($id = null)
    {
        // 1. Ambil maklumat profil pelajar daripada jadual Users
        $student = $this->Users->get($id);

        // 2. Tarik data letter_requests secara manual menggunakan 'matrix_id' pelajar tersebut
        $letterRequestsTable = $this->getTableLocator()->get('LetterRequests');
        
        $letterRequests = $letterRequestsTable->find()
            ->where(['LetterRequests.matrix_id' => $student->matrix_id])
            ->order(['LetterRequests.created_at' => 'DESC'])
            ->toArray();

        // 3. Masukkan semula data surat ke dalam entiti student supaya kod pada fail view.php tidak pecah
        $student->letter_requests = $letterRequests;

        $this->set(compact('student'));
    }

    /**
     * Edit method - Kemaskini Profil Pelajar
     */
    public function edit($id = null)
    {
        $student = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Users->patchEntity($student, $this->request->getData());
            if ($this->Users->save($student)) {
                $this->Flash->success(__('Rekod pelajar berjaya dikemaskini.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Gagal mengemaskini rekod. Sila cuba lagi.'));
        }
        $this->set(compact('student'));
    }

    /**
     * Delete method - Padam Akaun/Rekod Pelajar
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student = $this->Users->get($id);
        if ($this->Users->delete($student)) {
            $this->Flash->success(__('Rekod pelajar berjaya dipadam.'));
        } else {
            $this->Flash->error(__('Gagal memadam rekod pelajar. Sila cuba lagi.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}