<div class="new-comment-box">
<?php echo $this->Form->create('User');?>		
			<?php echo $this->Form->input('username', array('id' => 'username', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Nadimak</span><br /><br />
			<?php echo $this->Form->input('email', array('id' => 'email', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Email</span><br /><br />
			<?php echo $this->Form->input('password', array('id' => 'password', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Lozinka</span><br /><br />
			<?php echo $this->Form->input('admin', array('id' => 'admin', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Administrator</span><br /><br />						
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'comment-button')); ?>		
			<?php echo $this->Form->end();?>	
				
</div>
