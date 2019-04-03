<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CramSchool $cramSchool
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cramSchool->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cramSchool->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cram Schools'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Classes'), ['controller' => 'Classes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Class'), ['controller' => 'Classes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cramSchools form large-9 medium-8 columns content">
    <?= $this->Form->create($cramSchool) ?>
    <fieldset>
        <legend><?= __('Edit Cram School') ?></legend>
        <?php
            echo $this->Form->control('disp_no');
            echo $this->Form->control('is_valid');
            echo $this->Form->control('name');
            echo $this->Form->control('login_id');
            echo $this->Form->control('password');
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
