<?php
$this->set('documentData', array(
    'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

$this->set('channelData', array(
    'title' => __("A gde ima?"),
    'link' => $this->Html->url('/', true),
    'description' => __("Najnoviji postovi."),
    'language' => 'en-us'));
	
App::uses('Sanitize', 'Utility');

foreach ($posts as $post) {
    $postTime = strtotime($post['Post']['created']);

    $postLink = array(
        'controller' => 'posts',
        'action' => 'view',    
        'year' => date('Y', $postTime),
        'month' => date('m', $postTime),
        'permalink' => $post['Post']['permalink'], 
        'id' => $post['Post']['id']
    );

    // This is the part where we clean the body text for output as the description
    // of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $post['Post']['content']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));

    echo  $this->Rss->item(array(), array(
        'title' => $post['Post']['title'],
        'link' => $postLink,
        'guid' => array('url' => $postLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        //'dc:creator' => $post['Post']['author'],
        'pubDate' => $post['Post']['created']
    ));
}
?>	