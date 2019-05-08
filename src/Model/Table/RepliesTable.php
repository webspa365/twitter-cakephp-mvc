<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Replies Model
 *
 * @method \App\Model\Entity\Reply get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reply newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reply[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reply|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reply saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reply patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reply[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reply findOrCreate($search, callable $callback = null, $options = [])
 */
class RepliesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('replies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp', [
          'events' => [
              'Model.beforeSave' => [
                  'created_at' => 'new',
                  'updated_at' => 'always',
               ]
          ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->integer('replyId')
            ->requirePresence('replyId', 'create')
            ->allowEmptyString('replyId', false);

        $validator
            ->integer('replyTo')
            ->requirePresence('replyTo', 'create')
            ->allowEmptyString('replyTo', false);

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        return $validator;
    }
}
