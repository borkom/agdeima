<div class="new-comment-box">
<?php echo $this->Form->create('Category');?>		
			<?php echo $this->Form->input('name', array('id' => 'name', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Ime kategorije</span><br /><br />
			<?php echo $this->Form->input('permalink', array('id' => 'permalink', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Permalink</span><br /><br />
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'comment-button')); ?>		
			<?php echo $this->Form->end();?>	
				
</div>
