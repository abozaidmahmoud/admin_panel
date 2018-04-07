<?php

function lang($word){

	static $lang=array(
 		  //navbar links	
          'admin'=>'Home',
          'cateogery'=>'Cateogery',
          'item'=>'Items',
          'member'=>'Members',
          'comment'=>'Comments',
          'statistics'=>'Statistics',
		  'logs'=>'Logs',
          'edit profile'=>'Edit Profile',
          'setting'=>'Setting',
          'log out'=>'LogOut',
	);

	return $lang[$word];
}

?>
