<h1>Edit JobAdvertisement</h1>
<?php
    echo $this->Form->create($jobAdvertisement);
    echo $this->Form->control('title');
    echo $this->Form->control('description', ['rows' => '10']);
    echo $this->Form->button(__('Save JobAdvertisement'));
    echo $this->Form->end();
?>
