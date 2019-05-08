<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Relationship Entity
 *
 * @property int $id
 * @property int $follower
 * @property int $followed
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 * @property bool $boolean
 */
class Relationship extends Entity
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
        'follower' => true,
        'followed' => true,
        'created_at' => true,
        'updated_at' => true,
        'boolean' => true
    ];
}
