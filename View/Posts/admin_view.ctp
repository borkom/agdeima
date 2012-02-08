<?php $this->set('title_for_layout', ' - '.$post['Post']['title']); ?>	


	<?php echo $this->Html->link('izmena', array('controller' => 'posts', 'action' => 'edit', $post['Post']['id'])); ?> | 
	<?php echo $this->Html->link('objava', array('controller' => 'posts', 'action' => 'publish', $post['Post']['id'])); ?> | 
	<?php echo $this->Form->postLink('brisanje', array('controller' => 'posts', 'action' => 'delete', $post['Post']['id']), null, __('Da li ste sigurni da zelite da obrisete post ID %s?', $post['Post']['id'])); ?>		
	<h1><?php echo $this->Html->link($post['Post']['title'], array('controller' => 'posts', 'action' => 'view', $post['Post']['id'])); ?></h1>				
				<p class="post-info"><?php echo h($post['Post']['created']); ?> |
					 autor: <?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?> |
					 kategorija: <?php echo $this->Html->link($post['Category']['name'], array('controller' => 'posts', 'action' => 'categorized', $post['Category']['id'])); ?> |
					 objavljen: <?php echo $post['Post']['published'] == true ? 'DA':'NE'?>
				</p>
					
					<div class="post"><?php if(isset($post['Image'][0])): ?>
						<a href="<?php $bodytag = str_replace("/s144/", "/s{$post['Image'][0]['width']}/", $post['Image'][0]['thumbnail']); echo $bodytag; ?>" target="_blank">
							<img src="<?php echo $post['Image'][0]['location']; ?>" /></a><?php endif;?>
						<p><?php echo $post['Post']['content']; ?></p></div>
			
			<div class="prev-next">
				<?php if(isset($neighbors['prev']['Post']['id'])):?>
					<span style="float:left">
						<?php echo $this->Html->link('< Predhodni post', array('controller' => 'posts', 'action' => 'view', $neighbors['prev']['Post']['id'])); ?>
						</span>
						<?php endif; ?>
				<?php if(isset($neighbors['next']['Post']['id'])):?>
					<span style="float:right">
						<?php echo $this->Html->link('Sledeći post >', array('controller' => 'posts', 'action' => 'view', $neighbors['next']['Post']['id'])); ?>
						</span>
						<?php endif; ?>				
			</div>
			
			<div class="komentara"><p>Komentari:</p></div>
<?php foreach ($comments as $comment):?>
						<?php if($comment['Comment']['up'] - $comment['Comment']['down'] >= 5 ): ?>
						<div class="komentar-box-high">
						<div class="komentar-bg-hight"></div>	
						<?php else: ?>			
						<div class='komentar-box'>
						<div class='komentar-bg'><?php echo $this->Html->image('comment.png', array('alt' => 'Comment')); ?></div>
						<?php endif;?>
						<p><?php echo $comment['Comment']['content'];?></p>
						<div class='komentator'><?php echo $comment['User']['username'];?>
								<div class='comment-datum'><?php echo $comment['Comment']['created'];?></div>
								<?php echo $this->Html->link('izmena', array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id'], $post['Post']['id']));?>
								<?php echo $this->Html->link('objava', array('controller' => 'comments', 'action' => 'publish', $comment['Comment']['id'], $post['Post']['id']));?>
								<?php echo $this->Form->postLink('brisanje', array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id'], $post['Post']['id']), null, __('Da li ste sigurni da zelite da obrisete komentar ID %s?', $comment['Comment']['id'])); ?>																								
							  </div>
						</div>
<?php endforeach; ?>
		
<div style="clear:both"></div>

