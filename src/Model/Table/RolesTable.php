<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class RolesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('roles');
        $this->setDisplayField('role_name');
        $this->setPrimaryKey('id');

        // Hubungan: Satu peranan (Role) boleh dimiliki oleh ramai pengguna (Users)
        $this->hasMany('Users', [
            'foreignKey' => 'role_id',
        ]);
    }
}