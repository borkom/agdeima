<div id="sidebar-box">
	<?php
echo $this->Html->image('kat.png', array('alt' => 'Kat')); ?><h1>Admin panel</h1>

	<ul>
		<li><?php echo $this->Html->link(__('Postovi'), array('controller' => 'posts', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Korisnici'), array('controller' => 'users', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Kategorije'), array('controller' => 'categories', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Strane'), array('controller' => 'pages', 'action' => 'index')); ?></li>		
		<li><?php echo $this->Html->link(__('Newsletter'), array('controller' => 'users', 'action' => 'newsletter')); ?></li>						
	</ul>
</div>
