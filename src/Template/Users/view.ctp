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
        <li><?= $this->Html->link(__('List Cram Schools'), ['controller' => 'CramSchools', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cram School'), ['controller' => 'CramSchools', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List License Partners'), ['controller' => 'LicensePartners', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License Partner'), ['controller' => 'LicensePartners', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Login Id') ?></th>
            <td><?= h($user->login_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cram School') ?></th>
            <td><?= $user->has('cram_school') ? $this->Html->link($user->cram_school->name, ['controller' => 'CramSchools', 'action' => 'view', $user->cram_school->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tel') ?></th>
            <td><?= h($user->tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zip') ?></th>
            <td><?= h($user->zip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($user->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Memo') ?></th>
            <td><?= h($user->memo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Host') ?></th>
            <td><?= h($user->host) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Disp No') ?></th>
            <td><?= $this->Number->format($user->disp_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Valid') ?></th>
            <td><?= $this->Number->format($user->is_valid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voice Type') ?></th>
            <td><?= $this->Number->format($user->voice_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Birthday') ?></th>
            <td><?= h($user->birthday) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related License Partners') ?></h4>
        <?php if (!empty($user->license_partners)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('License Id') ?></th>
                <th scope="col"><?= __('Disp No') ?></th>
                <th scope="col"><?= __('Is Valid') ?></th>
                <th scope="col"><?= __('License Code') ?></th>
                <th scope="col"><?= __('Exp S Dt') ?></th>
                <th scope="col"><?= __('Exp F Dt') ?></th>
                <th scope="col"><?= __('Auth Datetime') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->license_partners as $licensePartners): ?>
            <tr>
                <td><?= h($licensePartners->id) ?></td>
                <td><?= h($licensePartners->license_id) ?></td>
                <td><?= h($licensePartners->disp_no) ?></td>
                <td><?= h($licensePartners->is_valid) ?></td>
                <td><?= h($licensePartners->license_code) ?></td>
                <td><?= h($licensePartners->exp_s_dt) ?></td>
                <td><?= h($licensePartners->exp_f_dt) ?></td>
                <td><?= h($licensePartners->auth_datetime) ?></td>
                <td><?= h($licensePartners->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'LicensePartners', 'action' => 'view', $licensePartners->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'LicensePartners', 'action' => 'edit', $licensePartners->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'LicensePartners', 'action' => 'delete', $licensePartners->id], ['confirm' => __('Are you sure you want to delete # {0}?', $licensePartners->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Students') ?></h4>
        <?php if (!empty($user->students)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Cram School Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->students as $students): ?>
            <tr>
                <td><?= h($students->id) ?></td>
                <td><?= h($students->cram_school_id) ?></td>
                <td><?= h($students->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Students', 'action' => 'view', $students->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Students', 'action' => 'edit', $students->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Students', 'action' => 'delete', $students->id], ['confirm' => __('Are you sure you want to delete # {0}?', $students->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
