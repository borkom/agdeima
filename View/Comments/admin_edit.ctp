<div class="new-comment-box">
<?php echo $this->Form->create('Comment');?>
			<span class="label">Komentar</span><br /><br />
			
			<?php echo $this->Form->input('Comment.content', array('label' => false, 'div' => false, 'class' => 'comment-input'));?>
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'comment-button')); ?>			
			<?php echo $this->Form->end();?>	
				
</div>
