<?php

	// get original input
	$copy = $_POST["original"];
	//trim space from end
	$copy = rtrim($copy);
	//replace carriage returns
	$copy = preg_replace('#\r#', '', $copy);
	//replace newlines
	$copy = preg_replace('#\n#', '', $copy);
	//replace tabs
	$copy = preg_replace('#\t#', '', $copy);

	//$copy = preg_replace('/<!-/', '/\n/<!-', $copy);
	//$copy = preg_replace('#/*#', '#/*\n#', $copy);
	//$copy = preg_replace("/[ ]{3,}/", ' ',$copy);
	//$copy = preg_replace('/> </', '><', $copy);
	

?>
<?php echo $copy;?>