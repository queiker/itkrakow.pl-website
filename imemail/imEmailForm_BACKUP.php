<?php
if(substr(basename($_SERVER['PHP_SELF']), 0, 11) == "imEmailForm") {
	include '../res/x5engine.php';
	$form = new ImForm();
	$form->setField('Email klienta', @$_POST['imObjectForm_4_2'], '', false);
	$form->setField('Imię i nazwisko', @$_POST['imObjectForm_4_3'], '', false);
	$form->setField('Telefon kontaktowy', @$_POST['imObjectForm_4_4'], '', false);
	$form->setField('Adres do lokalu gdzie ma przyjechać serwisant', @$_POST['imObjectForm_4_5'], '', false);
	$form->setField('Opis awari / problemu do rozwiązania', @$_POST['imObjectForm_4_6'], '', false);

	if(@$_POST['action'] != 'check_answer') {
		if(!isset($_POST['imJsCheck']) || $_POST['imJsCheck'] != 'FFCC8248DD4A976706EF59AEF525FAF5' || (isset($_POST['imSpProt']) && $_POST['imSpProt'] != ""))
			die(imPrintJsError());
		$form->mailToOwner('tradecomp.pl@gmail.com', 'tradecomp.pl@gmail.com', 'Formularz zgłoszenia awarii z strony itkrakow.pl', '', true);
		@header('Location: ../index.html');
		exit();
	} else {
		echo $form->checkAnswer(@$_POST['id'], @$_POST['answer']) ? 1 : 0;
	}
}

// End of file