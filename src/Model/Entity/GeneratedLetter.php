<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class GeneratedLetter extends Entity
{
    protected $_accessible = [
        'id' => true,
        'request_id' => true,
        'reference_number' => true,
        'generated_at' => true,
        'file_path' => true,
        'letter_request' => true,
    ];
}