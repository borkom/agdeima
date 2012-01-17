<pre>
	<?php //print_r($this->Session->read());?>
</pre>
<div class="posts form">
				
			<?php echo $this->Form->create('Post');?>

			<p class="post-label">Email</p>
			<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>

			<?php echo $this->Form->end('Odjava');?>
			
	</div>		
			
