<?php $this->set('title_for_layout', ' - Izmena strane'); ?>
<?php $this->Html->script(array('ckeditor/ckeditor', 'jquery/jquery-1.6.1.min'), array('inline' => false));?>
<div class="posts form">
				
			<?php echo $this->Form->create('Page');?>
			
			<p class="post-label">Naslov</p>
			<?php echo $this->Form->input('title', array('id' => 'title', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			<p class="post-label">Permalink</p>
			<?php echo $this->Form->input('permalink', array('id' => 'permalink', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
						
			<p class="post-label">Vaš tekst</p>
			
			
			<?php echo $this->Form->input('content', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>

			<script type="text/javascript">
				CKEDITOR.replace( 'data[Page][content]' );
			</script>	
			
			
			<br/>
	  


			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'post-button-objavi')); ?>
			<?php echo $this->Form->end();?>
			
	</div>	