<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Student'), ['action' => 'edit', $student->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Student'), ['action' => 'delete', $student->id], ['confirm' => __('Are you sure you want to delete # {0}?', $student->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cram Schools'), ['controller' => 'CramSchools', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cram School'), ['controller' => 'CramSchools', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="students view large-9 medium-8 columns content">
    <h3><?= h($student->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cram School') ?></th>
            <td><?= $student->has('cram_school') ? $this->Html->link($student->cram_school->name, ['controller' => 'CramSchools', 'action' => 'view', $student->cram_school->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $student->has('user') ? $this->Html->link($student->user->name, ['controller' => 'Users', 'action' => 'view', $student->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($student->id) ?></td>
        </tr>
    </table>
</div>
