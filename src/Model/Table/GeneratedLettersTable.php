<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GeneratedLettersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('generated_letters');
        $this->setDisplayField('reference_number');
        $this->setPrimaryKey('id');

        // Hubungan: Setiap surat yang dijana (GeneratedLetter) kepunyaan satu permohonan (LetterRequest)
        $this->belongsTo('LetterRequests', [
            'foreignKey' => 'request_id',
            'joinType' => 'INNER',
        ]);
    }
}