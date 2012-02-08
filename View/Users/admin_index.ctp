<div class="actions">
<?php echo $this->Html->link(__('Dodaj novog korisnika'), array('action' => 'add')); ?>
</div><br />
<div class="users index">
	<h2><?php echo __('Korisnici');?></h2><br />
	<table cellpadding="0" cellspacing="0">

	<?php
	foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Izmeni'), array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(__('Obrisi'), array('action' => 'delete', $user['User']['id']), null, __('Da li ste sigurni da zelite da obrisete korisnika: %s?', $user['User']['username'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table><br />
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Strana {:page} od {:pages}, prikazuje {:current} unosa od ukupno {:count}, počev od unosa {:start} do unosa {:end}.')
	));
	?>	</p>

	<div id="paginacija"><ul>
	<?php
		echo '<li>'.$this->Paginator->prev('< ' . __('prethodna'), array(), null, array('class' => 'prev disabled')).'</li>';
		echo '<li>'.$this->Paginator->numbers(array('separator' => '</li><li>')).'</li>';
		echo '<li>'.$this->Paginator->next(__('sledeća') . ' >', array(), null, array('class' => 'next disabled')).'</li>';
	?>
	</ul></div>
</div>
