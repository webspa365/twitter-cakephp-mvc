<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tweet Entity
 *
 * @property int $id
 * @property int $userId
 * @property string $username
 * @property string $tweet
 * @property string $replyTo
 * @property string $images
 * @property string $video
 * @property string $dir
 * @property int $replies
 * @property int $retweets
 * @property int $likes
 * @property string $hashtags
 * @property bool $liked
 * @property bool $retweeted
 * @property string $retweetedBy
 * @property int $time
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $updated_at
 */
class Tweet extends Entity
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
        'username' => true,
        'tweet' => true,
        /*
        'replyTo' => true,
        'images' => true,
        'video' => true,
        'dir' => true,
        'replies' => true,
        'retweets' => true,
        'likes' => true,
        'hashtags' => true,
        'liked' => true,
        'retweeted' => true,
        'retweetedBy' => true,
        'time' => true,
        'created_at' => true,
        'updated_at' => true
        */
    ];
}
