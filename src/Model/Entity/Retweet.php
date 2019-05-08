<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Retweet Entity
 *
 * @property int $id
 * @property int $userId
 * @property int $tweetId
 * @property string $username
 * @property bool $boolean
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 */
class Retweet extends Entity
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
        'userId' => true,
        'tweetId' => true,
        'username' => true,
        'boolean' => true,
        'created_at' => true,
        'updated_at' => true
    ];
}