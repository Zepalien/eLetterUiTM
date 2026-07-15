<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * LetterTemplates Controller
 *
 * @property \App\Model\Table\LetterTemplatesTable $LetterTemplates
 */
class LetterTemplatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // 🛠️ DIKEMASKINI: Guna find()->all() secara terus untuk elak ralat Paginator Helper
        $letterTemplates = $this->LetterTemplates->find()->all();
        $letterTemplates = $this->paginate($this->LetterTemplates);

        $this->set(compact('letterTemplates'));
    }

    /**
     * View method
     *
     * @param string|null $id Letter Template id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($template_id = null)
    {
        $letterTemplate = $this->LetterTemplates->get($template_id, contain: []);
        $this->set(compact('letterTemplate'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $letterTemplate = $this->LetterTemplates->newEmptyEntity();
        if ($this->request->is('post')) {
            $letterTemplate = $this->LetterTemplates->patchEntity($letterTemplate, $this->request->getData());
            if ($this->LetterTemplates->save($letterTemplate)) {
                $this->Flash->success(__('The letter template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The letter template could not be saved. Please, try again.'));
        }
        $this->set(compact('letterTemplate'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Letter Template id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($template_id = null)
    {
        $letterTemplate = $this->LetterTemplates->get($template_id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $letterTemplate = $this->LetterTemplates->patchEntity($letterTemplate, $this->request->getData());
            if ($this->LetterTemplates->save($letterTemplate)) {
                $this->Flash->success(__('The letter template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The letter template could not be saved. Please, try again.'));
        }
        $this->set(compact('letterTemplate'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Letter Template id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($template_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $letterTemplate = $this->LetterTemplates->get($template_id);
        if ($this->LetterTemplates->delete($letterTemplate)) {
            $this->Flash->success(__('The letter template has been deleted.'));
        } else {
            $this->Flash->error(__('The letter template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
  public function getTemplate($template_id = null)
{
    // Disable auto-render — kita return JSON terus
    $this->autoRender = false;

    try {
        // Ambil semua fields (tanpa filter) untuk elak isu missing primary key
        $template = $this->LetterTemplates->get($template_id);

        $data = [
            'subject_line'   => $template->subject_line,
            'paragraph_1'    => $template->paragraph_1,
            'paragraph_2'    => $template->paragraph_2,
            'paragraph_3'    => $template->paragraph_3,
            'signatory_name' => $template->signatory_name,
            'signatory_role' => $template->signatory_role,
        ];

        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($data));

    } catch (\Exception $e) {
        $this->response = $this->response
            ->withStatus(404)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => $e->getMessage()]));
    }

    return $this->response;

}
public function exportPdf($id = null)
{
    // 1. Ambil data permohonan surat berserta data profil pelajar
    $letterRequest = $this->LetterRequests->get($id, [
        'contain' => ['Students'] // Pastikan ada perkaitan (association) ke jadual pelajar
    ]);

    // 2. Ambil nama sebenar pelajar daripada database
    $realName = strtoupper($letterRequest->student->full_name); 
    $matrixId = $letterRequest->student->matrix_id;

    // 3. Ambil kandungan teks perenggan asal dari templat
    $paragraph1 = $letterRequest->paragraph_1; 

    // 4. PROSES PENGGANTIAN DATA (Ganti kata kunci dengan nama sebenar)
    $paragraph1 = str_replace('{STUDENT_NAME}', $realName, $paragraph1);
    
    // Anda juga boleh buat placeholder tambahan yang lain jika mahu:
    // $paragraph1 = str_replace('{MATRIX_ID}', $matrixId, $paragraph1);

    // 5. Hantar teks yang sudah diproses ke template PDF
    $this->set(compact('letterRequest', 'paragraph1'));
    
}
}