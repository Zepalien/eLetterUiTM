<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;

class DashboardController extends AppController
{
    public function index()
    {
        $currentUser = $this->request->getAttribute('identity');
        $letterRequestsTable = $this->fetchTable('LetterRequests');
        
        // Ambil filter bulan dari request (Default: 1 bulan)
        $monthsFilter = (int)$this->request->getQuery('months', 1);
        $cutoffDate = new FrozenTime("-{$monthsFilter} months");

        if ($currentUser->role_id == 1) {
            // === 🏢 LOGIK STATISTIK UNTUK ADMIN ===
            
            // 1. Counters Atas (Kekal Real-Time Keseluruhan)
            $stats = [
                'total'     => $letterRequestsTable->find()->count(),
                'pending'   => $letterRequestsTable->find()->where(['status' => 'Pending'])->count(),
                'approved'  => $letterRequestsTable->find()->where(['status' => 'Approved'])->count(),
                'rejected'  => $letterRequestsTable->find()->where(['status' => 'Rejected'])->count(),
                'generated' => $letterRequestsTable->find()->where(['status' => 'Approved'])->count(),
            ];

            // 2. Data Trend Permohonan Mingguan (Untuk Multi-Line Chart)
            $trendData = $letterRequestsTable->find()
                ->select([
                    'date' => 'DATE(LetterRequests.created_at)',
                    'total' => 'COUNT(LetterRequests.id)',
                    'approved' => "SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END)",
                    'pending' => "SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END)"
                ])
                ->where(['LetterRequests.created_at >=' => $cutoffDate])
                ->group(['DATE(LetterRequests.created_at)'])
                ->order(['DATE(LetterRequests.created_at)' => 'ASC'])
                ->toArray();

            // 3. Pecahan Mengikut Jenis Surat (Untuk Doughnut Chart Tengah)
            $letterTypes = $letterRequestsTable->find()
                ->select([
                    'type' => 'program_name',
                    'count' => 'COUNT(LetterRequests.id)'
                ])
                ->where(['LetterRequests.created_at >=' => $cutoffDate])
                ->group(['program_name'])
                ->toArray();

            // 4. Suapan Aktiviti Terkini (Recent Activity Timeline)
            $recentActivities = $letterRequestsTable->find()
                ->order(['LetterRequests.created_at' => 'DESC'])
                ->limit(5)
                ->toArray();

            // 5. Senarai Permohonan Utama (Recent Requests Table)
            $recentRequests = $letterRequestsTable->find()
                ->contain(['Users'])
                ->order(['LetterRequests.created_at' => 'DESC'])
                ->limit(10)
                ->all();

        } else {
            // === 🎓 LOGIK STATISTIK UNTUK STUDENT ===
            $studentMatrix = $currentUser->get('matrix_id');

            // Counters Utama Pelajar
            $stats = [
                'total'     => $letterRequestsTable->find()->where(['LetterRequests.matrix_id' => $studentMatrix])->count(),
                'pending'   => $letterRequestsTable->find()->where(['LetterRequests.matrix_id' => $studentMatrix, 'status' => 'Pending'])->count(),
                'approved'  => $letterRequestsTable->find()->where(['LetterRequests.matrix_id' => $studentMatrix, 'status' => 'Approved'])->count(),
                'rejected'  => $letterRequestsTable->find()->where(['LetterRequests.matrix_id' => $studentMatrix, 'status' => 'Rejected'])->count(),
                'generated' => $letterRequestsTable->find()->where(['LetterRequests.matrix_id' => $studentMatrix, 'status' => 'Approved'])->count(),
            ];
            
            // Mengambil suapan data trend khusus untuk carta peranti pelajar
            $trendData = $letterRequestsTable->find()
                ->select([
                    'date' => 'DATE(LetterRequests.created_at)',
                    'total' => 'COUNT(LetterRequests.id)',
                    'approved' => "SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END)",
                    'pending' => "SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END)"
                ])
                ->where(['LetterRequests.matrix_id' => $studentMatrix])
                ->group(['DATE(LetterRequests.created_at)'])
                ->order(['DATE(LetterRequests.created_at)' => 'ASC'])
                ->toArray();

            // Pecahan jenis surat milik pelajar
            $letterTypes = $letterRequestsTable->find()
                ->select([
                    'type' => 'program_name',
                    'count' => 'COUNT(LetterRequests.id)'
                ])
                ->where(['LetterRequests.matrix_id' => $studentMatrix])
                ->group(['program_name'])
                ->toArray();

            // Aktiviti terbaharu permohonan pelajar tersebut (Ditambah prefix LetterRequests.)
            $recentActivities = $letterRequestsTable->find()
                ->where(['LetterRequests.matrix_id' => $studentMatrix])
                ->order(['LetterRequests.created_at' => 'DESC'])
                ->limit(5)
                ->toArray();

            // Senarai 5 permohonan terkini di dalam jadual bawah (Selesai sepenuhnya)
            $recentRequests = $letterRequestsTable->find()
                ->contain(['Users'])
                ->where(['LetterRequests.matrix_id' => $studentMatrix])
                ->order(['LetterRequests.created_at' => 'DESC'])
                ->limit(5)
                ->all();
        }

        $this->set(compact('stats', 'currentUser', 'recentRequests', 'trendData', 'letterTypes', 'recentActivities', 'monthsFilter'));
    }
}