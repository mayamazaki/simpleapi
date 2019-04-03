<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CramSchool $cramSchool
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cram School'), ['action' => 'edit', $cramSchool->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cram School'), ['action' => 'delete', $cramSchool->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cramSchool->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cram Schools'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cram School'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Classes'), ['controller' => 'Classes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Class'), ['controller' => 'Classes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Students'), ['controller' => 'Students', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Student'), ['controller' => 'Students', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cramSchools view large-9 medium-8 columns content">
    <h3><?= h($cramSchool->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($cramSchool->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Login Id') ?></th>
            <td><?= h($cramSchool->login_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($cramSchool->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tel') ?></th>
            <td><?= h($cramSchool->tel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Zip') ?></th>
            <td><?= h($cramSchool->zip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($cramSchool->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Memo') ?></th>
            <td><?= h($cramSchool->memo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Host') ?></th>
            <td><?= h($cramSchool->host) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cramSchool->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Disp No') ?></th>
            <td><?= $this->Number->format($cramSchool->disp_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Valid') ?></th>
            <td><?= $this->Number->format($cramSchool->is_valid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($cramSchool->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($cramSchool->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Classes') ?></h4>
        <?php if (!empty($cramSchool->classes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Cram School Id') ?></th>
                <th scope="col"><?= __('Disp No') ?></th>
                <th scope="col"><?= __('Is Valid') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Login Id') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Exp S Dt') ?></th>
                <th scope="col"><?= __('Exp F Dt') ?></th>
                <th scope="col"><?= __('Tel') ?></th>
                <th scope="col"><?= __('Zip') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Memo') ?></th>
                <th scope="col"><?= __('Host') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($cramSchool->classes as $classes): ?>
            <tr>
                <td><?= h($classes->id) ?></td>
                <td><?= h($classes->cram_school_id) ?></td>
                <td><?= h($classes->disp_no) ?></td>
                <td><?= h($classes->is_valid) ?></td>
                <td><?= h($classes->name) ?></td>
                <td><?= h($classes->login_id) ?></td>
                <td><?= h($classes->password) ?></td>
                <td><?= h($classes->exp_s_dt) ?></td>
                <td><?= h($classes->exp_f_dt) ?></td>
                <td><?= h($classes->tel) ?></td>
                <td><?= h($classes->zip) ?></td>
                <td><?= h($classes->address) ?></td>
                <td><?= h($classes->memo) ?></td>
                <td><?= h($classes->host) ?></td>
                <td><?= h($classes->created) ?></td>
                <td><?= h($classes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Classes', 'action' => 'view', $classes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Classes', 'action' => 'edit', $classes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Classes', 'action' => 'delete', $classes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $classes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Students') ?></h4>
        <?php if (!empty($cramSchool->students)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Cram School Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($cramSchool->students as $students): ?>
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
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($cramSchool->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Disp No') ?></th>
                <th scope="col"><?= __('Is Valid') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Voice Type') ?></th>
                <th scope="col"><?= __('Birthday') ?></th>
                <th scope="col"><?= __('Login Id') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Cram School Id') ?></th>
                <th scope="col"><?= __('Tel') ?></th>
                <th scope="col"><?= __('Zip') ?></th>
                <th scope="col"><?= __('Address') ?></th>
                <th scope="col"><?= __('Memo') ?></th>
                <th scope="col"><?= __('Host') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($cramSchool->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->disp_no) ?></td>
                <td><?= h($users->is_valid) ?></td>
                <td><?= h($users->name) ?></td>
                <td><?= h($users->voice_type) ?></td>
                <td><?= h($users->birthday) ?></td>
                <td><?= h($users->login_id) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->cram_school_id) ?></td>
                <td><?= h($users->tel) ?></td>
                <td><?= h($users->zip) ?></td>
                <td><?= h($users->address) ?></td>
                <td><?= h($users->memo) ?></td>
                <td><?= h($users->host) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
