<?php $this->Html->script(array('ckeditor/ckeditor', 'jquery/jquery-1.6.1.min', 'jquery/fileuploader'), array('inline' => false));?>
<div class="posts form">
				
			<?php echo $this->Form->create('Post');?>
			
			<p class="post-label">Naslov</p>
			<?php echo $this->Form->input('title', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
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
			
			<p class="post-label">Nadimak</p>
			<?php echo $this->Form->input('User.username', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			
			<p class="post-label">Email (neće biti objavljen)</p>
			<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'class' => 'post-input-box'));?>
			<p class="post-label">Calculate this: <?php echo $captcha; ?></p>			
			<?php echo $this->Form->input('captcha', array('label' => false, 'div' => false, 'class' => 'post-input-box')); ?><br /><br />
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'post-button-objavi')); ?>
			<?php echo $this->Form->end();?>
			
	</div>		
			
