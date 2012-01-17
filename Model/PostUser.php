<?php
App::uses('AppModel', 'Model');

class PostUser extends AppModel {
    public $belongsTo = array(
        'Post', 'User'
    );
}
?>