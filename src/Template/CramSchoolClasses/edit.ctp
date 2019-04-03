<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CramSchoolClass $cramSchoolClass
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cramSchoolClass->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cramSchoolClass->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cram School Classes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cram Schools'), ['controller' => 'CramSchools', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cram School'), ['controller' => 'CramSchools', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cramSchoolClasses form large-9 medium-8 columns content">
    <?= $this->Form->create($cramSchoolClass) ?>
    <fieldset>
        <legend><?= __('Edit Cram School Class') ?></legend>
        <?php
            echo $this->Form->control('cram_school_id', ['options' => $cramSchools]);
            echo $this->Form->control('disp_no');
            echo $this->Form->control('is_valid');
            echo $this->Form->control('name');
            echo $this->Form->control('login_id');
            echo $this->Form->control('password');
            echo $this->Form->control('exp_s_dt', ['empty' => true]);
            echo $this->Form->control('exp_f_dt', ['empty' => true]);
            echo $this->Form->control('tel');
            echo $this->Form->control('zip');
            echo $this->Form->control('address');
            echo $this->Form->control('memo');
            echo $this->Form->control('host');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
