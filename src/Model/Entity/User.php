<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $bio
 * @property string $bg
 * @property string $avatar
 * @property int $tweets
 * @property int $following
 * @property int $followers
 * @property int $likes
 * @property bool $followed
 * @property string|null $remember_token
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property int $retweets
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'email' => true,
        'password' => true,
        'name' => true,
        'bio' => true,
        /*
        'bg' => true,
        'avatar' => true,
        'tweets' => true,
        'following' => true,
        'followers' => true,
        'likes' => true,
        'followed' => true,
        'remember_token' => true,
        'created_at' => true,
        'updated_at' => true,
        'retweets' => true
        */
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }
}
