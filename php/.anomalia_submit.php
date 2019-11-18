<html>
<body>

<?php
	function cleanTextInput($text) {
		return str_replace(";", " ", $text);
	}

	$zona = "( ( ".$_POST["x1"]." , ".$_POST["y1"]." ) , ( ".$_POST["x2"]." , ".$_POST["y2"]." ) )";
	
	$img = cleanTextInput($_POST['imagem']);
	$lingua = cleanTextInput($_POST['lingua']);
	$desc = cleanTextInput($_POST['descricao']);
	$trad = $_POST['traducao'] == 'on' ? 'TRUE' : 'FALSE';

	echo $lingua;
?>
	
</body>
</html>
