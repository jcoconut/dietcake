<?php
class Comment extends AppModel
{
	

	public $validation = array(
		
		'body' => array(
			'required' => array(
			'required',
			),
		),
	);


}
