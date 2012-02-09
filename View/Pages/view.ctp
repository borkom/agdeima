<?php $this->set('title_for_layout', ' - '.$page['Page']['title']); ?>	

	<h1><?php echo $this->Html->link($page['Page']['title'], array('controller' => 'pages', 'action' => 'view', 'permalink' => $page['Page']['permalink'], 'id' => $page['Page']['id'])); ?></h1>
				<p class="post-info">Strana poslednji put izmenjena: <?php echo $page['Page']['modified']; ?>
					 </p>
					
					<div class="post">
						<p><?php echo $page['Page']['content']; ?></p></div>	


