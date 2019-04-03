<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CramSchoolClass $cramSchoolClass
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cram School Class'), ['action' => 'edit', $cramSchoolClass->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cram School Class'), ['action' => 'delete', $cramSchoolClass->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cramSchoolClass->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cram School Classes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cram School Class'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cram Schools'), ['controller' => 'CramSchools', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cram School'), ['controller' => 'CramSchools', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cramSchoolClasses view large-9 medium-8 columns content">
    <h3><?= h($cramSchoolClass->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cram School') ?></th>
            <td><?= $cramSchoolClass->has('cram_school') ? $this->Html->link($cramSchoolClass->cram_school->name, ['controller' => 'CramSchools', 'action' => 'view', $cramSchoolClass->cram_school->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($cramSchoolClass->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Login Id') ?></th>
            <td><?= h($cramSchoolClass->login_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($cramSchoolClass->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tel') ?></th>
            <td><?= h($cramSchoolClass->tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zip') ?></th>
            <td><?= h($cramSchoolClass->zip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($cramSchoolClass->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Memo') ?></th>
            <td><?= h($cramSchoolClass->memo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Host') ?></th>
            <td><?= h($cramSchoolClass->host) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cramSchoolClass->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Disp No') ?></th>
            <td><?= $this->Number->format($cramSchoolClass->disp_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Valid') ?></th>
            <td><?= $this->Number->format($cramSchoolClass->is_valid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exp S Dt') ?></th>
            <td><?= h($cramSchoolClass->exp_s_dt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exp F Dt') ?></th>
            <td><?= h($cramSchoolClass->exp_f_dt) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cramSchoolClass->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cramSchoolClass->modified) ?></td>
        </tr>
    </table>
</div>
