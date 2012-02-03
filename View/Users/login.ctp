<pre>
	<?php print_r($this->Session->read())?>
</pre>

<?php
echo $this->Form->create();
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end('Submit');
?>