<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tweets Model
 *
 * @method \App\Model\Entity\Tweet get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tweet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tweet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tweet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tweet saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tweet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tweet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tweet findOrCreate($search, callable $callback = null, $options = [])
 */
class TweetsTable extends Table
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

        $this->setTable('tweets');
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
            ->scalar('username')
            ->maxLength('username', 191)
            ->requirePresence('username', 'create')
            ->allowEmptyString('username', false);

        $validator
            ->scalar('tweet')
            ->maxLength('tweet', 191)
            ->requirePresence('tweet', 'create')
            ->allowEmptyString('tweet', false);
/*
        $validator
            ->scalar('replyTo')
            ->maxLength('replyTo', 191)
            ->requirePresence('replyTo', 'create')
            ->allowEmptyString('replyTo', false);

        $validator
            ->scalar('images')
            ->maxLength('images', 191)
            ->requirePresence('images', 'create')
            ->allowEmptyFile('images', false);

        $validator
            ->scalar('video')
            ->maxLength('video', 191)
            ->requirePresence('video', 'create')
            ->allowEmptyString('video', false);

        $validator
            ->scalar('dir')
            ->maxLength('dir', 191)
            ->requirePresence('dir', 'create')
            ->allowEmptyString('dir', false);

        $validator
            ->integer('replies')
            ->requirePresence('replies', 'create')
            ->allowEmptyString('replies', false);

        $validator
            ->integer('retweets')
            ->requirePresence('retweets', 'create')
            ->allowEmptyString('retweets', false);

        $validator
            ->integer('likes')
            ->requirePresence('likes', 'create')
            ->allowEmptyString('likes', false);

        $validator
            ->scalar('hashtags')
            ->maxLength('hashtags', 191)
            ->requirePresence('hashtags', 'create')
            ->allowEmptyString('hashtags', false);

        $validator
            ->boolean('liked')
            ->requirePresence('liked', 'create')
            ->allowEmptyString('liked', false);

        $validator
            ->boolean('retweeted')
            ->requirePresence('retweeted', 'create')
            ->allowEmptyString('retweeted', false);

        $validator
            ->scalar('retweetedBy')
            ->maxLength('retweetedBy', 191)
            ->requirePresence('retweetedBy', 'create')
            ->allowEmptyString('retweetedBy', false);

        $validator
            ->integer('time')
            ->requirePresence('time', 'create')
            ->allowEmptyString('time', false);

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
