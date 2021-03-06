<?php $this->set('title_for_layout', ' - Administracija - Indeks strana'); ?>
	<div class="posts index">
	<?php
	foreach ($posts as $post): ?>
	<h1><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></h1>
				<p class="post-info"><?php echo h($post['Post']['created']); ?> |
					 autor: <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?> |
					 kategorija: <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'posts', 'action' => 'categorized', $post['Category']['id'])); ?> |
					 objavljen: <?php echo $post['Post']['published'] == true ? 'DA':'NE'?>
				</p>
					
					<div class="post"><p><?php echo $post['Post']['content']; ?></p></div>
			
					
					<div class='komentara'><p><?php echo $this->Html->link('komentara: '.count($post['Comment']), array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></p></div>
				
<?php endforeach; ?>

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
