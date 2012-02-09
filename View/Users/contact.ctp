<?php $this->set('title_for_layout', ' - Kontakt'); ?>
<div class="contact form">
				
			<?php echo $this->Form->create('Contact');?>
			<p class="post-label">Vaše ime</p>
			<?php echo $this->Form->input('name', array('id' => 'name', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
			<p class="post-label">Vaš email</p>
			<?php echo $this->Form->input('email', array('id' => 'email', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
						
			<p class="post-label">Naslov poruke</p>
			<?php echo $this->Form->input('subject', array('id' => 'title', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
			<p class="post-label">Vaš tekst</p>
			
			
			<?php echo $this->Form->input('content', array('id' => 'content', 'type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
			<p class="post-label">Izračunaj: <?php echo $captcha; ?></p>			
			<?php echo $this->Form->input('captcha', array('label' => false, 'div' => false, 'class' => 'post-input-box')); ?><br /><br />
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'post-button-objavi')); ?>
			<?php echo $this->Form->end();?>
			
	</div>		
			
