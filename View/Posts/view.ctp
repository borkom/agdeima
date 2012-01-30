<?php $this->Html->script('http://static.ak.fbcdn.net/connect.php/js/FB.Share', array('inline' => false));?>
<?php $this->Html->scriptBlock('!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");', array('inline' => false));?>
<?php $this->Html->script(array('jquery/jquery-1.6.1.min', 'validation', 'voting'), array('inline' => false));?>
<?php $this->set('title_for_layout', ' - '.$post['Post']['title']); ?>	

	<h1><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', 'year' => $this->Time->format('Y', $post['Post']['created']), 'month' => $this->Time->format('m', $post['Post']['created']), 'permalink' => $post['Post']['permalink'], 'id' => $post['Post']['id'])); ?></h1>
				<p class="post-info"><?php echo h($post['Post']['created']); ?> |
					 autor: <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?> |
					 kategorija: <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'categories', 'action' => 'view', $post['Category']['id'])); ?>
				</p>
					
					<div class="post"><?php if(isset($post['Image'][0])): ?>
						<a href="<?php $bodytag = str_replace("/s144/", "/s{$post['Image'][0]['width']}/", $post['Image'][0]['thumbnail']); echo $bodytag; ?>" target="_blank">
							<img src="<?php echo $post['Image'][0]['location']; ?>" /></a><?php endif;?>
						<p><?php echo $post['Post']['content']; ?></p></div>
			
			<div class="prev-next">
				<?php if(isset($neighbors['prev']['Post']['id'])):?>
					<span style="float:left">
						<?php echo $this->Html->link('< Predhodni post', array('controller' => 'posts', 'action' => 'view', 'year' => $this->Time->format('Y', $neighbors['prev']['Post']['created']), 'month' => $this->Time->format('m', $neighbors['prev']['Post']['created']), 'permalink' => $neighbors['prev']['Post']['permalink'], 'id' => $neighbors['prev']['Post']['id'])); ?>
						</span>
						<?php endif; ?>
				<?php if(isset($neighbors['next']['Post']['id'])):?>
					<span style="float:right">
						<?php echo $this->Html->link('Sledeći post >', array('controller' => 'posts', 'action' => 'view', 'year' => $this->Time->format('Y', $neighbors['next']['Post']['created']), 'month' => $this->Time->format('m', $neighbors['next']['Post']['created']), 'permalink' => $neighbors['next']['Post']['permalink'], 'id' => $neighbors['next']['Post']['id'])); ?>
						</span>
						<?php endif; ?>				
			</div>
			<div>
				
				<!-- Social icons-->
				
				<iframe src="http://www.facebook.com/plugins/like.php?href=YOUR_URL" scrolling="no" frameborder="0"
				style="border:none; width:350px; height:30px;">
				</iframe>
				
				<span style="margin:1px; position:absolute;"><a name="fb_share"></a></span>
				
				<span style="position:absolute; margin-left:80px;">
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="en">Tweet</a>
				</span>
			
			</div>			
			<div class="komentara"><p>Ostavite svoj komentar:</p></div>
<?php foreach ($comments as $comment):?>
						<?php if($comment['Comment']['up'] - $comment['Comment']['down'] >= 5 ): ?>
						<div class="komentar-box-high">
						<div class="komentar-bg-hight"></div>	
						<?php else: ?>			
						<div class='komentar-box'>
						<div class='komentar-bg'><?php echo $this->Html->image('comment.png', array('alt' => 'Comment')); ?></div>
						<?php endif;?>
						<p><?php echo $comment['Comment']['content'];?></p>
						<div class="voting">
						<div class="voting-up"><a href="#" class="voting-up-number" id="<?php echo $comment['Comment']['id'];?>-up"><?php echo $comment['Comment']['up'];?></a></div>
						<div class="voting-down"><a href="#" class="voting-down-number" id="<?php echo $comment['Comment']['id'];?>-down"><?php echo $comment['Comment']['down'];?></a></div>
						</div>
						<div class='komentator'><?php echo $comment['User']['username'];?>
								<div class='comment-datum'><?php echo $comment['Comment']['created'];?></div>
							  </div>
						</div>
<?php endforeach; ?>
		
<div style="clear:both"></div>
			

<div class="new-comment-box">
<?php echo $this->Form->create('Post');?>
			<?php if(!$this->Session->check('Login.email')):?>			
			<?php echo $this->Form->input('User.username', array('id' => 'username', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Nadimak</span><br /><br />
			
			<?php echo $this->Form->input('User.email', array('id' => 'email', 'label' => false, 'div' => false, 'class' => 'input-box'));?>
			<span class="label">Email (neće biti objavljen)</span><br /><br />
			<?php endif;?>			
			<?php echo $this->Form->input('Comment.content', array('label' => false, 'div' => false, 'class' => 'comment-input'));?><br /><br />			
			<p class="post-label">Izračunaj: <?php echo $captcha; ?></p>			
			<?php echo $this->Form->input('captcha', array('label' => false, 'div' => false, 'class' => 'input-box')); ?>
			<?php echo $this->Form->button('Submit', array('type' => 'submit', 'div' => false, 'class' => 'comment-button')); ?><br /><br />
			<?php echo $this->Form->checkbox('PostUser.notify', array('label' => false, 'div' => false, 'class' => 'input-box')); ?>
			<span class="label">Obavesti me mejlom o novim komentarima</span><br /><br />			
			<?php echo $this->Form->end();?>	
				
</div>

