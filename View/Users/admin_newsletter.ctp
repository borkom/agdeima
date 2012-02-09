<?php $this->set('title_for_layout', ' - Newsletter'); ?>
<?php $this->Html->script(array('ckeditor/ckeditor', 'jquery/jquery-1.6.1.min'), array('inline' => false));?>
<div class="newsletter form">
				
			<?php echo $this->Form->create('Newsletter');?>
			
			<p class="post-label">Naslov</p>
			<?php echo $this->Form->input('subject', array('id' => 'title', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
			<p class="post-label">Tekst newsletter-a</p>
			
			
			<?php echo $this->Form->input('content', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>

			<script type="text/javascript">
				CKEDITOR.replace( 'data[Newsletter][content]' );
			</script>	
			
						
			<br />
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'post-button-objavi')); ?>
			<?php echo $this->Form->end();?>
			
	</div>		
			
