
			<div class="menu">
		<ul>
			<li>Ulogovani ste: <strong><?php echo $this->Session->read('Auth.User.username');?></strong></li>
		</ul>

</div>


<div id="search">

	<strong><?php echo $this->Html->link(__('Odjava'), array('controller' => 'users', 'action' => 'logout')); ?></strong>
	
</div>


<div id="home-image">			<?php echo $this->Html->link(
					$this->Html->image('logo-agdeima.png', array('alt' => __('Home A gde ima?'), 'border' => '0')),
					'/admin',
					array('escape' => false)
				);
			?></div>