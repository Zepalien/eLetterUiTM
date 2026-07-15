<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        // Hubungan: Seorang user mempunyai banyak permohonan surat
        $this->hasMany('LetterRequests', [
            'foreignKey' => 'matrix_id',
        ]);
    }
}