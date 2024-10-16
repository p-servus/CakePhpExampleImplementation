<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Applicant> $applicants
 */
?>
<div class="applicants index content">
    <?= $this->Html->link(__('New Applicant'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Applicants') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('firstName') ?></th>
                    <th><?= $this->Paginator->sort('lastName') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $applicant): ?>
                <tr>
                    <td><?= $this->Number->format($applicant->id) ?></td>
                    <td><?= h($applicant->title) ?></td>
                    <td><?= h($applicant->firstName) ?></td>
                    <td><?= h($applicant->lastName) ?></td>
                    <td><?= h($applicant->email) ?></td>
                    <td><?= h($applicant->created) ?></td>
                    <td><?= h($applicant->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $applicant->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $applicant->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $applicant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $applicant->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>