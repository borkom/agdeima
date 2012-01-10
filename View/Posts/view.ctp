<pre>
	<?php //print_r($comments);?>
	<?php //print_r($post);?>
</pre>	
<div class="posts view">

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
	
	<form method=POST action="single.php">
		
		<input type=TEXT name="Nadimak" size=18 class="input-box" value=""><span class="label">Nadimak</span><br /><br />
	
		<input type=TEXT name="Email" size=25 class="input-box" value=""><span class="label">Email (neće biti objavljen)</span><br /><br />
		
		<textarea name="Komentar" rows="10" cols="50" class="comment-input"></textarea><br /><br />
		
		<div class="provera-bot">Koliko mačka ima nogu? (upisati slovima) <input type=TEXT name="Provera-mačke" size=6></div>
		
		<div id="secret"><input type=TEXT name=secret size=10></div>
		
		<input type=submit value="Objavi" name="Submit" class="comment-button"><br /><br /><br />
		
		<input name="email-obavestenje" type="checkbox" value="" />
			<span class="label">Obavesti me mejlom o novim komentarima</span>
		
		
	</form>
	
			
	
</div>
</div>
