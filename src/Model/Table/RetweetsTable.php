<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Retweets Model
 *
 * @method \App\Model\Entity\Retweet get($primaryKey, $options = [])
 * @method \App\Model\Entity\Retweet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Retweet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Retweet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Retweet saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Retweet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Retweet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Retweet findOrCreate($search, callable $callback = null, $options = [])
 */
class RetweetsTable extends Table
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

        $this->setTable('retweets');
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
            ->integer('userId')
            ->requirePresence('userId', 'create')
            ->allowEmptyString('userId', false);

        $validator
            ->integer('tweetId')
            ->requirePresence('tweetId', 'create')
            ->allowEmptyString('tweetId', false);

/*
        $validator
            ->scalar('username')
            ->maxLength('username', 191)
            ->requirePresence('username', 'create')
            ->allowEmptyString('username', false);

        $validator
            ->boolean('boolean')
            ->requirePresence('boolean', 'create')
            ->allowEmptyString('boolean', false);

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');
*/

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */

    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
