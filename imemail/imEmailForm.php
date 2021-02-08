<?php


// MODYFIKACJE BY GRZEGORZ PŁONKA

$db_host = "localhost";
$db_user = "queiker_extras";
$db_password = "queiker_extras";
$db_to_connect = "queiker_extras";

$db_link = @mysql_connect($db_host, $db_user, $db_password) or die("Nie można połączyć z serwerem mysql " . mysql_errno() . "Opis błędu " . mysql_error());

mysql_select_db($db_to_connect, $db_link) or die("Nie można połączyć do  bazy danych mysql " . mysql_errno() . "Opis błędu " . mysql_error());

$czas_teraz = date('H:i:s - d-m-Y');

$zapytanie = "INSERT INTO klienci (email, imie_i_nazwisko, telefon, adres_lokalu, opis_problemu, czas) VALUES ('" . $_POST['imObjectForm_4_2'] . "', '" . $_POST['imObjectForm_4_3'] . "', '" . $_POST['imObjectForm_4_4'] . "', '" . $_POST['imObjectForm_4_5'] . "', '" . $_POST['imObjectForm_4_6'] . "', '" . $czas_teraz . "')";

mysql_query($zapytanie, $db_link) or die("Nieudane zapytanie " . $zapytanie. " \n kod błędu " . mysql_errno() . "Opis błędu " . mysql_error());

mysql_close();

//KONIEC MODYFIKACJI





if(substr(basename($_SERVER['PHP_SELF']), 0, 11) == "imEmailForm") 


{
	include '../res/x5engine.php';
	$form = new ImForm();
	$form->setField('Email klienta', @$_POST['imObjectForm_4_2'], '', false);
	$form->setField('Imię i nazwisko', @$_POST['imObjectForm_4_3'], '', false);
	$form->setField('Telefon kontaktowy', @$_POST['imObjectForm_4_4'], '', false);
	$form->setField('Adres do lokalu gdzie ma przyjechać serwisant', @$_POST['imObjectForm_4_5'], '', false);
	$form->setField('Opis awari / problemu do rozwiązania', @$_POST['imObjectForm_4_6'], '', false);

	if(@$_POST['action'] != 'check_answer') 
{
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