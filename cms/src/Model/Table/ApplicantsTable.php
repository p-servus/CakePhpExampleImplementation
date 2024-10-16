<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Applicants Model
 *
 * @method \App\Model\Entity\Applicant newEmptyEntity()
 * @method \App\Model\Entity\Applicant newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Applicant> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Applicant get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Applicant findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Applicant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Applicant> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Applicant|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Applicant saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Applicant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Applicant>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Applicant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Applicant> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Applicant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Applicant>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Applicant>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Applicant> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ApplicantsTable extends Table
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

        $this->setTable('applicants');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

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
        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('firstName')
            ->maxLength('firstName', 255)
            ->requirePresence('firstName', 'create')
            ->notEmptyString('firstName');

        $validator
            ->scalar('lastName')
            ->maxLength('lastName', 255)
            ->requirePresence('lastName', 'create')
            ->notEmptyString('lastName');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        return $validator;
    }
}
