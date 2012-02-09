<div class="users form">
				
			<?php echo $this->Form->create('Users');?>

			<p class="post-label">Email</p>
			<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>

			<?php echo $this->Form->end('Odjava');?>
			
	</div>	