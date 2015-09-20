<?php
// debug($jobs);
foreach ($jobs as $job) {
	echo '<div class="item">';
	if (isset($job['jobAttributes']['dateStarted'])) {
		echo '<p>'.date('d.m.Y H:i', strtotime($job['jobAttributes']['dateStarted'])).' Uhr: ';
	}
	echo '<strong>'.$job['jobAttributes']['name'].'</strong></p>';
	echo '<p>';
	if(!isset($job['jobAttributes']['suspended'])) {
		echo $job['jobAttributes']['jobStatus'];
	} else {
		echo 'Paused';
	}
	if ($job['jobAttributes']['jobStatus'] != 'Finished') {
		echo ' &ndash; '.round($job['jobAttributes']['percentDone']).'%';
	}
	if ($job['jobAttributes']['jobStatus'] == 'Running') {
		if (isset($job['jobAttributes']['suspended'])) {
			echo ' &ndash; '.$this->Html->link('Resume', '/xgridstatus/resumejob/'.$job['jobid']);
		} else {
			echo ' &ndash; '.$this->Html->link('Pause', '/xgridstatus/pausejob/'.$job['jobid']);
		}
	}
	if ($job['jobAttributes']['jobStatus'] == 'Failed') {
			echo ' &ndash; '.$this->Html->link('Restart', '/xgridstatus/restartjob/'.$job['jobid']);
	}
	if ($job['jobAttributes']['jobStatus'] == 'Finished' 
		|| $job['jobAttributes']['jobStatus'] == 'Failed'
		|| isset($job['jobAttributes']['suspended'])) {
		echo ' &ndash; '.$this->Html->link('Delete', '/xgridstatus/removejob/'.$job['jobid']);
	}
	echo '</p>';
	if ($job['jobAttributes']['jobStatus'] == 'Failed') {
		echo '<p>Error: <strong>'.$job['jobAttributes']['error'].'</strong></p>';
	}
	echo '</div>';
}
?>
<p>
	<?php echo $this->Html->link('Delete all failed jobs', '/xgridstatus/removefailedjobs') ?>
</p>