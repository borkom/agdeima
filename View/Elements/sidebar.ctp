<?php if($this->Session->check('Login.email')): ?>
<div id="sidebar-box">
		<?php
echo $this->Html->image('stats.png', array('alt' => 'Stats')); ?><h1>Statistika</h1>

	<ul>
		<li><a href="#">Objavljenih tekstova: 7</a></li>
		<li><a href="#">Pozitivnih komentara: 40</a></li>
		<li><a href="#">Negativnih komentara: 9</a></li>
		<li><a href="#">Član ste: 7 god. 3 meseca</a></li>
	</ul>
	
</div>
<?php endif;?>
<div id="sidebar-box">
	<?php
echo $this->Html->image('hot.png', array('alt' => 'Hot')); ?><h1>Popularni naslovi</h1>

	<ul>
		<?php foreach ($mostViewed as $popular): ?>
		<li><?php echo $this->Html->link($popular['Post']['title'], array('controller' => 'posts', 'action' => 'view', 'year' => $this->Time->format('Y', $popular['Post']['created']), 'month' => $this->Time->format('m', $popular['Post']['created']), 'permalink' => $popular['Post']['permalink'], 'id' => $popular['Post']['id'])); ?></li>
		<?php endforeach; ?>
	</ul>
	
</div>

<div id="sidebar-box">
	<?php
echo $this->Html->image('kat.png', array('alt' => 'Kat')); ?><h1>Kategorije</h1>

	<ul>
		<li><a href="#">Jedan lep naslov (24)</a></li>
		<li><a href="#">Drugi naslov (30)</a></li>
		<li><a href="#">Treci naslov (13)</a></li>
		<li><a href="#">Jedan lep naslov (69)</a></li>
	</ul>
</div>


<div id="sidebar-box">
	<?php
echo $this->Html->image('prijatelji.png', array('alt' => 'Hot')); ?><h1>Prijatelji sajta</h1>

	<ul>
		<li><a href="#">Daroteka</a></li>
		<li><a href="#">Photo After</a></li>
		<li><a href="#">Mustra becka</a></li>
		<li><a href="#">Mackomali</a></li>
	</ul>
</div>


<div id="sidebar-box">
	<?php
echo $this->Html->image('arhiva.png', array('alt' => 'Hot')); ?><h1>Arhiva</h1>

	<ul>
		<li><a href="#">Januar 2008</a></li>
		<li><a href="#">Februar 2008</a></li>
		<li><a href="#">Mart 2008</a></li>
		<li><a href="#">April 2008</a></li>
	</ul>
</div>

<div align="left">
	<?php echo $this->Html->link(
					$this->Html->image('rss.png', array('alt' => __('Prijavi se na RSS kanal A gde ima?'), 'border' => '0')),
					'/feed',
					array('title' => 'RSS kanal za nove tekstove', 'escape' => false)
				);
			?>
</div>
