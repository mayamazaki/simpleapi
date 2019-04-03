<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LicensePartner $licensePartner
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $licensePartner->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $licensePartner->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List License Partners'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Licenses'), ['controller' => 'Licenses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New License'), ['controller' => 'Licenses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="licensePartners form large-9 medium-8 columns content">
    <?= $this->Form->create($licensePartner) ?>
    <fieldset>
        <legend><?= __('Edit License Partner') ?></legend>
        <?php
            echo $this->Form->control('license_id', ['options' => $licenses]);
            echo $this->Form->control('disp_no');
            echo $this->Form->control('is_valid');
            echo $this->Form->control('license_code');
            echo $this->Form->control('exp_s_dt', ['empty' => true]);
            echo $this->Form->control('exp_f_dt', ['empty' => true]);
            echo $this->Form->control('auth_datetime');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
