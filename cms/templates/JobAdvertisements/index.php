<h1>JobAdvertisements</h1>
<?= $this->Html->link('Add JobAdvertisement', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <?php foreach ($jobAdvertisements as $jobAdvertisement): ?>
    <tr>
        <td>
            <?= $this->Html->link($jobAdvertisement->title, ['action' => 'view', $jobAdvertisement->id]) ?>
        </td>
        <td>
            <?= $jobAdvertisement->created->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $jobAdvertisement->id]) ?>
            |
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $jobAdvertisement->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>