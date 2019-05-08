<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bio') ?></th>
            <td><?= h($user->bio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bg') ?></th>
            <td><?= h($user->bg) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Avatar') ?></th>
            <td><?= h($user->avatar) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remember Token') ?></th>
            <td><?= h($user->remember_token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tweets') ?></th>
            <td><?= $this->Number->format($user->tweets) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Following') ?></th>
            <td><?= $this->Number->format($user->following) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Followers') ?></th>
            <td><?= $this->Number->format($user->followers) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Likes') ?></th>
            <td><?= $this->Number->format($user->likes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Retweets') ?></th>
            <td><?= $this->Number->format($user->retweets) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($user->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($user->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Followed') ?></th>
            <td><?= $user->followed ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
