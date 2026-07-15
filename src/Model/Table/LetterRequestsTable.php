<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LetterRequests Model
 *
 * @method \App\Model\Entity\LetterRequest newEmptyEntity()
 * @method \App\Model\Entity\LetterRequest newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LetterRequest> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LetterRequest get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LetterRequest findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LetterRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LetterRequest> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LetterRequest|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LetterRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LetterRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LetterRequest>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LetterRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LetterRequest> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LetterRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LetterRequest>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LetterRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LetterRequest> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LetterRequestsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
        public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('letter_requests');
        $this->setPrimaryKey('id');

        // 🛠️ KEMASKINI DI SINI: Tukar foreignKey kepada matrix_id
       $this->belongsTo('Users', [
    'foreignKey' => 'matrix_id', // Tukar di sini jika sebelum ini 'matrix_id'
    'bindingKey' => 'matrix_id'  // Memandangkan ia join guna nombor matrik, bukan id asal
]);

        // Hubungan ke LetterTemplates (Gunakan template_id mengikut query log anda)
        $this->belongsTo('LetterTemplates', [
            'foreignKey' => 'template_id', // Ditukar kepada template_id berdasarkan struktur SQL anda
        ]);
    }


    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('matrix_id')
            ->requirePresence('matrix_id', 'create')
            ->notEmptyString('matrix_id');

        $validator
            ->integer('template_id')
            ->requirePresence('template_id', 'create')
            ->notEmptyString('template_id');

        $validator
            ->integer('admin_id')
            ->allowEmptyString('admin_id');

        $validator
            ->scalar('purpose')
            ->requirePresence('purpose', 'create')
            ->notEmptyString('purpose');

        $validator
            ->scalar('organization_name')
            ->maxLength('organization_name', 255)
            ->requirePresence('organization_name', 'create')
            ->notEmptyString('organization_name');

        $validator
            ->scalar('organization_address')
            ->requirePresence('organization_address', 'create')
            ->notEmptyString('organization_address');

        $validator
            ->scalar('program_name')
            ->maxLength('program_name', 255)
            ->requirePresence('program_name', 'create')
            ->notEmptyString('program_name');

        $validator
            ->scalar('reason')
            ->allowEmptyString('reason');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->scalar('admin_remarks')
            ->allowEmptyString('admin_remarks');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }
}
