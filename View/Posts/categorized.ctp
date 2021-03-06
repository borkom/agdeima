<?php $this->set('title_for_layout', ' - Kategorija: '.$posts[0]['Category']['name']); ?>
	<div class="posts index">
	<h1>Kategorija: <?php echo $posts[0]['Category']['name'];?></h1><br />	
	<?php
	foreach ($posts as $post): ?>
	<h1><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', 'year' => $this->Time->format('Y', $post['Post']['created']), 'month' => $this->Time->format('m', $post['Post']['created']), 'permalink' => $post['Post']['permalink'], 'id' => $post['Post']['id'])); ?></h1>
				<p class="post-info"><?php echo h($post['Post']['created']); ?> |
					 autor: <?php echo $post['User']['username']; ?> |
					 kategorija: <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'posts', 'action' => 'categorized', 'permalink' => $post['Category']['permalink'], 'id' => $post['Category']['id'])); ?>
				</p>
					
					<div class="post"><p><?php echo $post['Post']['content']; ?></p></div>
			
					
					<div class='komentara'><p><?php echo $this->Html->link('komentara: '.count($post['Comment']), array('controller' => 'posts', 'action' => 'view', 'year' => $this->Time->format('Y', $post['Post']['created']), 'month' => $this->Time->format('m', $post['Post']['created']), 'permalink' => $post['Post']['permalink'], 'id' => $post['Post']['id'])); ?></p></div>	
				
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
