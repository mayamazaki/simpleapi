<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LicensePartner $licensePartner
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit License Partner'), ['action' => 'edit', $licensePartner->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete License Partner'), ['action' => 'delete', $licensePartner->id], ['confirm' => __('Are you sure you want to delete # {0}?', $licensePartner->id)]) ?> </li>
        <li><?= $this->Html->link(__('List License Partners'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License Partner'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Licenses'), ['controller' => 'Licenses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License'), ['controller' => 'Licenses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="licensePartners view large-9 medium-8 columns content">
    <h3><?= h($licensePartner->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('License') ?></th>
            <td><?= $licensePartner->has('license') ? $this->Html->link($licensePartner->license->id, ['controller' => 'Licenses', 'action' => 'view', $licensePartner->license->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('License Code') ?></th>
            <td><?= h($licensePartner->license_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $licensePartner->has('user') ? $this->Html->link($licensePartner->user->name, ['controller' => 'Users', 'action' => 'view', $licensePartner->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($licensePartner->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Disp No') ?></th>
            <td><?= $this->Number->format($licensePartner->disp_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Valid') ?></th>
            <td><?= $this->Number->format($licensePartner->is_valid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exp S Dt') ?></th>
            <td><?= h($licensePartner->exp_s_dt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exp F Dt') ?></th>
            <td><?= h($licensePartner->exp_f_dt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth Datetime') ?></th>
            <td><?= h($licensePartner->auth_datetime) ?></td>
        </tr>
    </table>
</div>
