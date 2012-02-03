
			<div class="menu">
		<ul>
			<li><strong><?php echo $this->Html->link(__('Objavi gde si nešto našao'), array('action' => 'add')); ?></strong></li> 
			<li><strong><?php echo $this->Html->link(__('Pitaj gde nešto ima'), array('action' => 'add')); ?></strong></li> 
			<li><a href=#>O servisu</a></li>
			<li><a href=#>Marketing</a></li>
			<li><a href=#>Kontakt</a></li>
		</ul>

</div>


<div id="search">

	<p><input type=TEXT name="search-input" class="search-input" value="Pronađi..." onblur="if(this.value=='') this.value='Pronađi...'" onfocus="if(this.value =='Pronađi...' ) this.value=''"></p>
	
</div>


<div id="home-image">			<?php echo $this->Html->link(
					$this->Html->image('logo-agdeima.png', array('alt' => __('Home A gde ima?'), 'border' => '0')),
					'/',
					array('escape' => false)
				);
			?></div>