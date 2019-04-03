<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LicensePartner[]|\Cake\Collection\CollectionInterface $licensePartners
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New License Partner'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Licenses'), ['controller' => 'Licenses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New License'), ['controller' => 'Licenses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="licensePartners index large-9 medium-8 columns content">
    <h3><?= __('License Partners') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('license_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('disp_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_valid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('license_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('exp_s_dt') ?></th>
                <th scope="col"><?= $this->Paginator->sort('exp_f_dt') ?></th>
                <th scope="col"><?= $this->Paginator->sort('auth_datetime') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($licensePartners as $licensePartner): ?>
            <tr>
                <td><?= $this->Number->format($licensePartner->id) ?></td>
                <td><?= $licensePartner->has('license') ? $this->Html->link($licensePartner->license->id, ['controller' => 'Licenses', 'action' => 'view', $licensePartner->license->id]) : '' ?></td>
                <td><?= $this->Number->format($licensePartner->disp_no) ?></td>
                <td><?= $this->Number->format($licensePartner->is_valid) ?></td>
                <td><?= h($licensePartner->license_code) ?></td>
                <td><?= h($licensePartner->exp_s_dt) ?></td>
                <td><?= h($licensePartner->exp_f_dt) ?></td>
                <td><?= h($licensePartner->auth_datetime) ?></td>
                <td><?= $licensePartner->has('user') ? $this->Html->link($licensePartner->user->name, ['controller' => 'Users', 'action' => 'view', $licensePartner->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $licensePartner->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $licensePartner->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $licensePartner->id], ['confirm' => __('Are you sure you want to delete # {0}?', $licensePartner->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
