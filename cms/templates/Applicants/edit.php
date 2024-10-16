<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Applicant $applicant
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $applicant->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $applicant->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Applicants'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="applicants form content">
            <?= $this->Form->create($applicant) ?>
            <fieldset>
                <legend><?= __('Edit Applicant') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('firstName');
                    echo $this->Form->control('lastName');
                    echo $this->Form->control('email');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
