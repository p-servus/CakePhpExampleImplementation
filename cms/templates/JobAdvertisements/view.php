<h1><?= h($jobAdvertisement->title) ?></h1>
<p><?= h($jobAdvertisement->description) ?></p>
<p><small>Created: <?= $jobAdvertisement->created->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $jobAdvertisement->id]) ?></p>
