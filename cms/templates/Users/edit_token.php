<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit Token for User "{0}"', h($user->username)) ?></legend>
                <?php
                    echo $this->Form->control('token', [
                        'value' => $newToken,
                        'readonly' => true,
                    ]);
                ?>
                <div class="message warning">
                    Please store this token in a safe location!!!
                    Because of security reasons, only a hash of it will be stored here!
                    If you lost the token, you have to create a new one!
                </div>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
