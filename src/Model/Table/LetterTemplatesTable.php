<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LetterTemplates Model
 *
 * @method \App\Model\Entity\LetterTemplate newEmptyEntity()
 * @method \App\Model\Entity\LetterTemplate newEntity(array $data, array $options = [])
 * @method array< \App\Model\Entity\LetterTemplate> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LetterTemplate get($primaryKey, array$options = [])
 * @method \App\Model\Entity\LetterTemplate findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LetterTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array< \App\Model\Entity\LetterTemplate> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LetterTemplate|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LetterTemplate saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable< \App\Model\Entity\LetterTemplate>|\App\Model\Entity\LetterTemplate|false saveMany(iterable $entities, array $options = [])
 * @method iterable< \App\Model\Entity\LetterTemplate>|\App\Model\Entity\LetterTemplate saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable< \App\Model\Entity\LetterTemplate>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable< \App\Model\Entity\LetterTemplate> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LetterTemplatesTable extends Table
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

        $this->setTable('letter_templates');
        $this->setDisplayField('title');
        $this->setPrimaryKey('template_id'); 

        $this->hasMany('LetterRequests', [
            'foreignKey' => 'template_id',
        ]);

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        // Note: Check if your primary key is 'id' or 'template_id' 
        // down here to match your setPrimaryKey() config.
        $validator
            ->integer('template_id')
            ->allowEmptyString('template_id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title', 'Sila masukkan nama atau jenis templat');

        $validator
            ->scalar('subject_line')
            ->maxLength('subject_line', 255)
            ->allowEmptyString('subject_line');

        $validator
            ->scalar('body_content')
            ->allowEmptyString('body_content');

        return $validator;
    }
}