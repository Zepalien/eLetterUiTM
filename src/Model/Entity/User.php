<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class User extends Entity
{
    // 1. Pastikan $_accessible menggunakan array
    protected array $_accessible = [
        '*' => true,
        'id' => false,
    ];

    // 2. Pastikan $_hidden juga kekal menggunakan array
    protected array $_hidden = [
        'password',
    ];
}