<?php $this->set('title_for_layout', ' - Izmena posta'); ?>
<?php $this->Html->script(array('ckeditor/ckeditor', 'jquery/jquery-1.6.1.min'), array('inline' => false));?>
<div class="posts form">
				
			<?php echo $this->Form->create('Post', array('type' => 'file'));?>
			
			<p class="post-label">Naslov</p>
			<?php echo $this->Form->input('title', array('id' => 'title', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			<p class="post-label">Permalink</p>
			<?php echo $this->Form->input('permalink', array('id' => 'permalink', 'label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
						
			<p class="post-label">Vaš tekst</p>
			
			
			<?php echo $this->Form->input('content', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>

			<script type="text/javascript">
				CKEDITOR.replace( 'data[Post][content]' );
			</script>	
			
						

			<p class="instructions">
				
				* potrudite se da što vernije opišete svoj predmet ili uslugu, bilo to adresa, telefon ili
				web sajt. Što više detaljnih informacija ne može da škodi. Neka naslov bude jasan tj. da čitalac
				odmah zna o čemu se radi u daljem opisu.
			
			</p>
			
			<br/>
	  
								
			<span class="post-label">Odaberi kategoriju: </span><?php echo $this->Form->input('category_id', array('label' => false, 'div' => false));?>
	
		
			<span class="post-label"><br /><br />


			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'post-button-objavi')); ?>
			<?php echo $this->Form->end();?>
			
	</div>		
			
