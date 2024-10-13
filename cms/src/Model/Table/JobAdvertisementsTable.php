<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JobAdvertisements Model
 *
 * @method \App\Model\Entity\JobAdvertisement newEmptyEntity()
 * @method \App\Model\Entity\JobAdvertisement newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\JobAdvertisement> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JobAdvertisement get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\JobAdvertisement findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\JobAdvertisement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\JobAdvertisement> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\JobAdvertisement|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\JobAdvertisement saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\JobAdvertisement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobAdvertisement>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\JobAdvertisement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobAdvertisement> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\JobAdvertisement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobAdvertisement>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\JobAdvertisement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobAdvertisement> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JobAdvertisementsTable extends Table
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

        $this->setTable('job_advertisements');
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
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 1000)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        return $validator;
    }
}
