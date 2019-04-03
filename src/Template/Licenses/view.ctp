<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\License $license
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit License'), ['action' => 'edit', $license->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete License'), ['action' => 'delete', $license->id], ['confirm' => __('Are you sure you want to delete # {0}?', $license->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Licenses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List License Partners'), ['controller' => 'LicensePartners', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License Partner'), ['controller' => 'LicensePartners', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="licenses view large-9 medium-8 columns content">
    <h3><?= h($license->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('License Code') ?></th>
            <td><?= h($license->license_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth Info1') ?></th>
            <td><?= h($license->auth_info1) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth Info2') ?></th>
            <td><?= h($license->auth_info2) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth Info3') ?></th>
            <td><?= h($license->auth_info3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($license->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Disp No') ?></th>
            <td><?= $this->Number->format($license->disp_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Valid') ?></th>
            <td><?= $this->Number->format($license->is_valid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exp S Dt') ?></th>
            <td><?= h($license->exp_s_dt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exp F Dt') ?></th>
            <td><?= h($license->exp_f_dt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth Datetime') ?></th>
            <td><?= h($license->auth_datetime) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related License Partners') ?></h4>
        <?php if (!empty($license->license_partners)): ?>
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
            <?php foreach ($license->license_partners as $licensePartners): ?>
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
</div>
