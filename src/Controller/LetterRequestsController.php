<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LetterRequests Controller
 *
 * @property \App\Model\Table\LetterRequestsTable $LetterRequests
 */
class LetterRequestsController extends AppController
{
    /**
     * Index / My Requests method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
   public function index()
{
    // 1. Ambil data pengguna yang sedang log masuk
    $currentUser = $this->Authentication->getIdentity();
    $roleId = $currentUser->get('role_id'); // Pastikan nama kolum role_id betul (contoh: 1 untuk Admin, 2 untuk Student)
    
    // 2. Mulakan query asas untuk menarik data permohonan surat
    $query = $this->LetterRequests->find()
        ->contain(['Users', 'LetterTemplates']);

    // 3. SEBAHAGIAN KESELAMATAN: Tapis hanya jika pengguna ialah Student
    // Tukar angka '2' di bawah mengikut ID peranan Student dalam database anda
    if ($roleId == 2) { 
        $currentStudentMatrix = $currentUser->get('matrix_id'); 
        $query->where(['LetterRequests.matrix_id' => $currentStudentMatrix]);
    }
    // Jika dia Admin (roleId == 1), sistem akan langgar blok 'if' ini 
    // dan terus memaparkan semua rekod tanpa tapisan!

    // 4. Paginate hasil query
    $letterRequests = $this->paginate($query);
    $this->set(compact('letterRequests'));
}

   /**
     * View method
     *
     * @param string|null $id Letter Request id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewLetter($id = null)
    {
        // Ambil data Entity berserta hubungannya (Users & LetterTemplates)
        $letterRequest = $this->LetterRequests->find()
            ->where(['LetterRequests.id' => $id])
            ->contain(['Users', 'LetterTemplates'])
            ->first();

        if (!$letterRequest) {
            $this->Flash->error(__('Rekod surat tidak ditemui.'));
            return $this->redirect(['action' => 'index']);
        }

        // --- PROSES PENGGANTIAN PLACEHOLDER SECARA DINAMIK ---
        // 1. Dapatkan data student daripada perkaitan User (atau jika ada table Student)
        // Kita assume nama student disimpan di $letterRequest->user->name atau full_name
        $studentName = strtoupper($letterRequest->user->name ?? 'NAMA PELAJAR'); 
        
        // 2. Sediakan senarai penggantian (Suaikan dengan input borang imej ke-2)
        $replacements = [
            '{STUDENT_NAME}'   => $studentName,
            '{PROGRAM_NAME}'   => $letterRequest->program_activity ?? '', // Ambil dari input "Nama Program / Aktiviti"
            '[Nama Syarikat]'  => $letterRequest->organization_name ?? '', // Ambil dari input "Nama Organisasi / Penerima"
            // Tambah lagi placeholder ikut kesesuaian template admin:
            '[Tarikh Mula]'    => $letterRequest->start_date ?? '', 
            '[Tarikh Tamat]'   => $letterRequest->end_date ?? '',
            '[Nyatakan bilangan minggu/bulan, contoh: 24 minggu]' => $letterRequest->duration ?? '24 minggu'
        ];

        // 3. Gantikan perkataan dalam perenggan 1, 2, dan 3
        if (!empty($letterRequest->paragraph_1)) {
            $letterRequest->paragraph_1 = strtr($letterRequest->paragraph_1, $replacements);
        }
        if (!empty($letterRequest->paragraph_2)) {
            $letterRequest->paragraph_2 = strtr($letterRequest->paragraph_2, $replacements);
        }
        if (!empty($letterRequest->paragraph_3)) {
            $letterRequest->paragraph_3 = strtr($letterRequest->paragraph_3, $replacements);
        }

        $this->set(compact('letterRequest'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
public function add()
{
    $letterRequest = $this->LetterRequests->newEmptyEntity();

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // 1. Handle file upload
        /** @var \Laminas\Diactoros\UploadedFile $file */
        $file = $this->request->getData('supporting_document');
        $fileName = null;

        if ($file && $file->getError() === UPLOAD_ERR_OK) {
            $originalName = $file->getClientFilename();
            $fileName = time() . '_' . $originalName;
            $targetPath = WWW_ROOT . 'files' . DS . $fileName;

            try {
                $file->moveTo($targetPath);
            } catch (\Exception $e) {
                $this->Flash->error(__('Gagal menyimpan fail ke pelayan. Sila cuba lagi.'));
                return $this->redirect(['action' => 'add']);
            }
        }

        // 2. Gantikan objek fail dengan nama fail (string)
        if ($fileName) {
            $data['supporting_document'] = $fileName;
        } else {
            unset($data['supporting_document']);
        }

        // 3. Auto-fill organization_address jika perlu
        if (!isset($data['organization_address']) && isset($data['address1'])) {
            $data['organization_address'] = trim(
                ($data['address1'] ?? '') . ' ' .
                ($data['address2'] ?? '') . ' ' .
                ($data['address3'] ?? '')
            );
        }

        // 4. Patch entity
        $letterRequest = $this->LetterRequests->patchEntity($letterRequest, $data);

        // 5. Set status & matrix_id
        $letterRequest->status = 'Pending';
        if ($this->request->getSession()->read('Auth.matrix_id')) {
            $letterRequest->matrix_id = $this->request->getSession()->read('Auth.matrix_id');
        }

        // 6. Save
        if ($this->LetterRequests->save($letterRequest)) {
            $this->Flash->success(__('Permohonan berjaya dihantar. Sila tunggu kelulusan.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $errors = $letterRequest->getErrors();
            $errorMsg = '';
            foreach ($errors as $field => $validation) {
                $errorMsg .= $field . ': ' . implode(', ', $validation) . ' | ';
            }
            $this->Flash->error(__('Simpanan gagal. Ralat: ' . $errorMsg));
        }
    }

    // ✅ Load templates sebagai full entity (untuk dropdown + AJAX preview)
    $templates = $this->LetterRequests->LetterTemplates->find('all')->all();

    // Kekal letterTemplates untuk kegunaan lain jika ada
    $letterTemplates = $this->LetterRequests->LetterTemplates->find('list', [
        'keyField'   => 'template_id',
        'valueField' => 'title',
    ])->toArray();

    $this->set(compact('letterRequest', 'templates', 'letterTemplates'));
}
    /**
     * Edit method
     *
     * @param string|null $id Letter Request id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Muatkan entiti bersama hubungan untuk kegunaan borang dan preview
        $letterRequest = $this->LetterRequests->get($id, contain: ['Users', 'LetterTemplates']);
        
        // Simpan nama fail lama untuk sandaran (backup)
        $oldFile = $letterRequest->supporting_document;

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Pecahkan data penandatangan jika admin memilih pegawai
            if (!empty($data['signatory_data'])) {
                $parts = explode('|', $data['signatory_data']);
                $data['signatory_name'] = $parts[0];
                $data['signatory_position'] = $parts[1];
            }

            // 1. KENDALIKAN PROSES MUAT NAIK FAIL (Sama seperti fungsi add)
            /** @var \Laminas\Diactoros\UploadedFile $file */
            $file = $this->request->getData('supporting_document');
            $fileName = null;

            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                // Jika ada fail baru dimuat naik
                $originalName = $file->getClientFilename();
                $fileName = time() . '_' . $originalName;
                $targetPath = WWW_ROOT . 'files' . DS . $fileName;

                try {
                    $file->moveTo($targetPath);
                    $data['supporting_document'] = $fileName; // Guna fail baru
                } catch (\Exception $e) {
                    $this->Flash->error(__('Gagal menyimpan fail ke pelayan. Sila cuba lagi.'));
                    return $this->redirect(['action' => 'edit', $letterRequest->id]);
                }
            } else {
                // Jika tiada fail baru dimuat naik, kekalkan nama fail lama atau buang jika diminta
                if (!empty($data['delete_supporting_document'])) {
                    $data['supporting_document'] = null;
                } else {
                    $data['supporting_document'] = $oldFile;
                }
            }

            // 2. Patch data ke dalam entiti selepas data fail diuruskan
            $letterRequest = $this->LetterRequests->patchEntity($letterRequest, $data);
            
            if ($this->LetterRequests->save($letterRequest)) {
                $this->Flash->success(__('Permohonan surat rasmi berjaya dikemaskini.'));
                // Selepas simpan, terus bawa ke halaman viewLetter untuk tindakan Cetak/Email
                return $this->redirect(['action' => 'viewLetter', $letterRequest->id]);
            }
            $this->Flash->error(__('Gagal menyimpan perubahan. Sila semak semula borang anda.'));
        }
        
        $letterTemplates = $this->LetterRequests->LetterTemplates->find('list', limit: 200)->all();
        
        // Senarai pegawai penandatangan surat untuk pilihan Admin
        $signatories = [
            'PROF. MADYA DR. ASIAH ALIAS|Dekan' => 'Prof. Madya Dr. Asiah Alias (Dekan)',
            'DR. MOHAMAD HAFIZ BIN JILANI|Timbalan Dekan (Akademik)' => 'Dr. Mohamad Hafiz bin Jilani (Timbalan Dekan)',
            'ENCIK KHAIRUL MIZAN BIN TAIB|Pensyarah Kanan' => 'Encik Khairul Mizan bin Taib (Pensyarah Kanan)',
        ];

        $this->set(compact('letterRequest', 'letterTemplates', 'signatories'));
    }
    /**
     * Delete method
     *
     * @param string|null $id Letter Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $letterRequest = $this->LetterRequests->get($id);
        if ($this->LetterRequests->delete($letterRequest)) {
            $this->Flash->success(__('The letter request has been deleted.'));
        } else {
            $this->Flash->error(__('The letter request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
   public function exportPdf($id = null)
    {
        // 1. Ambil data permohonan surat berserta data profil user/student
        $letterRequest = $this->LetterRequests->get($id, [
            'contain' => ['Users'] // Tukar ke 'Students' jika anda guna table Students terpisah
        ]);

        // 2. Sediakan nama dan butiran dinamik
        $studentName = strtoupper($letterRequest->user->name ?? 'NAMA PELAJAR'); 

        $replacements = [
            '{STUDENT_NAME}'   => $studentName,
            '{PROGRAM_NAME}'   => $letterRequest->program_activity ?? '',
            '[Nama Syarikat]'  => $letterRequest->organization_name ?? '',
            '[Tarikh Mula]'    => $letterRequest->start_date ?? '', 
            '[Tarikh Tamat]'   => $letterRequest->end_date ?? '',
        ];

        // 3. Proses penggantian teks pada semua perenggan
        if (!empty($letterRequest->paragraph_1)) {
            $letterRequest->paragraph_1 = strtr($letterRequest->paragraph_1, $replacements);
        }
        if (!empty($letterRequest->paragraph_2)) {
            $letterRequest->paragraph_2 = strtr($letterRequest->paragraph_2, $replacements);
        }
        if (!empty($letterRequest->paragraph_3)) {
            $letterRequest->paragraph_3 = strtr($letterRequest->paragraph_3, $replacements);
        }

        // 4. Hantar entiti yang sudah dikemas kini ke template PDF
        $this->set(compact('letterRequest'));
        
    }
}