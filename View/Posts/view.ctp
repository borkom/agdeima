<pre>
	<?php //print_r($usernotify);?>
	<?php //print_r($post);?>
		<?php //print_r($this->Session->read());?>
</pre>	


	<h1><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></h1>
				<p class="post-info"><?php echo h($post['Post']['created']); ?> |
					 autor: <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?> |
					 kategorija: <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'categories', 'action' => 'view', $post['Category']['id'])); ?>
				</p>
					
					<div class="post"><p><?php echo $post['Post']['content']; ?></p></div>
			
			<div class="prev-next">
				<span style="float:left"><a href="#">&larr; Predhodni post</a></span>
				<span style="float:right"><a href="#">Sledeći post &rarr;</a></span>
			</div>
			
			<div class="komentara"><p>Ostavite svoj komentar:</p></div>
<?php foreach ($comments as $comment):?>		
						<div class='komentar-box'>
						<div class='komentar-bg'><?php echo $this->Html->image('comment.png', array('alt' => 'Comment')); ?></div>
						<p><?php echo $comment['Comment']['content'];?></p>

						<div class='komentator'><?php echo $comment['User']['username'];?>
								<div class='comment-datum'><?php echo $comment['Comment']['created'];?></div>
							  </div>
						</div>
<?php endforeach; ?>
		
<div style="clear:both"></div>
			

<div class="new-comment-box">
<?php echo $this->Form->create('Post');?>
			
			<?php echo $this->Form->input('User.username', array('label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Nadimak</span><br /><br />
			
			<?php echo $this->Form->input('User.email', array('label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Email (neće biti objavljen)</span><br /><br />
			<?php echo $this->Form->input('Comment.content', array('label' => false, 'div' => false, 'class' => 'comment-input'));?><br /><br />			
			<p class="post-label">Izračunaj: <?php echo $captcha; ?></p>			
			<?php echo $this->Form->input('captcha', array('label' => false, 'div' => false, 'class' => 'input-box')); ?>
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'comment-button')); ?><br /><br />
			<?php echo $this->Form->checkbox('PostUser.notify', array('label' => false, 'div' => false, 'class' => 'input-box')); ?>
			<span class="label">Obavesti me mejlom o novim komentarima</span><br /><br />			
			<?php echo $this->Form->end();?>	
				
</div>

