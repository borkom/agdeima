<pre>
	<?php //print_r($posts);?>
</pre>	
<div class="posts index">
	<?php
	foreach ($posts as $post): ?>
	<h1><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></h1>
				<p class="post-info"><?php echo h($post['Post']['created']); ?> |
					 autor: <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?> |
					 kategorija: <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'categories', 'action' => 'view', $post['Category']['id'])); ?>
				</p>
					
					<div class="post"><p><?php echo $post['Post']['content']; ?></p></div>
			
					
					<div class='komentara'><p><?php echo $this->Html->link('komentara: '.count($post['Comment']), array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></p></div>	
				
<?php endforeach; ?>

	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
