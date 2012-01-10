			<div class="menu">
		<ul>
			<li><?php echo $this->Html->link(__('Objavi gde si nešto našao'), array('action' => 'add')); ?></li> 
			<li><?php echo $this->Html->link(__('Pitaj gde nešto ima'), array('action' => 'add')); ?></li> 
			<li><a href=#>O servisu</a></li>
		</ul>

</div>


<div class="search">

	<p>Pronađi: <input type=TEXT name="search-input" class="search-input"></p>
	
</div>

<div id="home-image">			<?php echo $this->Html->link(
					$this->Html->image('logo-agdeima.png', array('alt' => __('Home A gde ima?'), 'border' => '0')),
					'/',
					array('escape' => false)
				);
			?></div>