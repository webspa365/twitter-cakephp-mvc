<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
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
            ->scalar('username')
            ->maxLength('username', 191)
            ->requirePresence('username', 'create')
            ->allowEmptyString('username', false)
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->allowEmptyString('email', false)
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 191)
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        $validator
            ->scalar('name')
            ->maxLength('name', 191)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', true);

        $validator
            ->scalar('bio')
            ->maxLength('bio', 191)
            ->requirePresence('bio', 'create')
            ->allowEmptyString('bio', true);
/*
        $validator
            ->scalar('bg')
            ->maxLength('bg', 191)
            ->requirePresence('bg', 'create')
            ->allowEmptyString('bg', false);

        $validator
            ->scalar('avatar')
            ->maxLength('avatar', 191)
            ->requirePresence('avatar', 'create')
            ->allowEmptyString('avatar', false);

        $validator
            ->integer('tweets')
            ->requirePresence('tweets', 'create')
            ->allowEmptyString('tweets', false);

        $validator
            ->integer('following')
            ->requirePresence('following', 'create')
            ->allowEmptyString('following', false);

        $validator
            ->integer('followers')
            ->requirePresence('followers', 'create')
            ->allowEmptyString('followers', false);

        $validator
            ->integer('likes')
            ->requirePresence('likes', 'create')
            ->allowEmptyString('likes', false);

        $validator
            ->boolean('followed')
            ->requirePresence('followed', 'create')
            ->allowEmptyString('followed', false);

        $validator
            ->scalar('remember_token')
            ->maxLength('remember_token', 100)
            ->allowEmptyString('remember_token');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmptyDateTime('updated_at');

        $validator
            ->integer('retweets')
            ->requirePresence('retweets', 'create')
            ->allowEmptyString('retweets', false);
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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
