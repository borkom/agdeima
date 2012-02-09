
			<div class="menu">
		<ul>
			<li><strong><?php echo $this->Html->link(__('Objavi gde si nešto našao'), array('action' => 'add')); ?></strong></li> 
			<li><strong><?php echo $this->Html->link(__('Pitaj gde nešto ima'), array('action' => 'add')); ?></strong></li> 
			<?php foreach($links as $link):?>
			<li><?php echo $this->Html->link($link['Page']['title'], array('controller' => 'pages', 'action' => 'view', 'permalink' => $link['Page']['permalink'], 'id' => $link['Page']['id'])); ?></li>
			<?php endforeach;?>
			<li><?php echo $this->Html->link('Kontakt', array('controller' => 'users', 'action' => 'contact')); ?></li>
		</ul>

</div>


<div id="search">
    <form name="search" method="post" action="/agdeima/posts/search">
	<p><input type=TEXT name="keyword" class="search-input" value="Pronađi..." onblur="if(this.value=='') this.value='Pronađi...'" onfocus="if(this.value =='Pronađi...' ) this.value=''"></p>
	</form>
</div>


<div id="home-image">			<?php echo $this->Html->link(
					$this->Html->image('logo-agdeima.png', array('alt' => __('Home A gde ima?'), 'border' => '0')),
					'/',
					array('escape' => false)
				);
			?></div>