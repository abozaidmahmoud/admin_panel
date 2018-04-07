<?php

function lang($word){
	static $lang=array(

		  'admin'=>'الصفحه الرئسيه',
          'cateogery'=>'تصنيفات',
          'edit profile'=>'تعديل الصفحه',
          'setting'=>'الاعدادات',
          'log out'=>'خرزج',
	);

	return $lang[$word];
}


?>