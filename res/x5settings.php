<?php

/*
|-------------------------------
|	GENERAL SETTINGS
|-------------------------------
*/

$imSettings['general'] = array(
	'url' => 'http://www.itkrakow.pl/',
	'homepage_url' => 'http://www.itkrakow.pl/index.html',
	'icon' => 'http://www.itkrakow.pl/admin/images/logo_owp5x2rm.png',
	'version' => '14.0.4.3',
	'sitename' => 'tel 511-665-378 | informatyk Kraków',
	'public_folder' => '',
	'salt' => 'egbzjwunhcbluehu5o5lbbjz59dalnpu6cvxnedii96fh4bbbhvvdqk3wct9',
	'use_common_email_sender_address' => false,
	'common_email_sender_addres' => ''
);


$imSettings['admin'] = array(
	'icon' => 'admin/images/logo_owp5x2rm.png',
	'theme' => 'orange'
);


/*
|--------------------------------------------------------------------------------------
|	DATABASES SETTINGS
|--------------------------------------------------------------------------------------
*/

$imSettings['databases'] = array(
	'uab7mqzx' => array(
		'description' => 'Baza danych website h: queiker_website',
		'host' => 'localhost',
		'database' => 'queiker_website',
		'user' => 'queiker_website',
		'password' => 'queiker_website'
	)
);
$ecommerce = Configuration::getCart();
$ecommerce->setSettings(array(
	'force_sender' => false,
	'email_opening' => 'Szanowny Kliencie!<br /><br />Dziękujemy za dokonanie zakupu w naszym sklepie.<br /><br />Poniżej podajemy szczegóły zamówienia. Oto podsumowanie zamówienia wraz z listą zamówionych produktów, danymi do faktury, terminem dostawy i wybranym sposobem płatności.',
	'email_closing' => 'Prosimy o kontakt, jeśli potrzebne są dodatkowe informacje.<br /><br />Z poważaniem.<br />      Sprzedawca.',
	'useCSV' => false,
	'header_bg_color' => 'rgba(37, 58, 88, 1)',
	'header_text_color' => 'rgba(255, 255, 255, 1)',
	'cell_bg_color' => 'rgba(255, 255, 255, 1)',
	'cell_text_color' => 'rgba(0, 0, 0, 1)',
	'border_color' => 'rgba(211, 211, 211, 1)',
	'owner_email' => '',
	'vat_type' => 'included'
));


/*
|-------------------------------------------------------------------------------------------
|	GUESTBOOK SETTINGS
|-------------------------------------------------------------------------------------------
*/

$imSettings['guestbooks'] = array();

/*
|-------------------------------
|	EMAIL SETTINGS
|-------------------------------
*/

$ImMailer->emailType = 'phpmailer';
$ImMailer->header = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . "\n" . '<html>' . "\n" . '<head>' . "\n" . '<meta http-equiv="content-type" content="text/html; charset=utf-8">' . "\n" . '<meta name="generator" content="Incomedia WebSite X5 v14 - www.websitex5.com">' . "\n" . '</head>' . "\n" . '<body bgcolor="#FFFFFF" style="background-color: #FFFFFF;">' . "\n\t" . '<table border="0" cellpadding="0" align="center" cellspacing="0" style="padding: 0; margin: 0 auto; width: 700px;">' . "\n\t" . '<tr><td id="imEmailContent" style="min-height: 300px; padding: 10px; font: normal normal normal 9pt \'Tahoma\'; color: #000000; background-color: #FFFFFF; text-align: left; text-decoration: none;  width: 700px;border-style: solid; border-color: #000000; border-top-width: 3px; border-right-width: 3px; border-bottom-width: 3px; border-left-width: 3px;background-color: #FFFFFF" width="700px">' . "\n\t\t";
$ImMailer->footer = "\n\t" . '</td></tr>' . "\n\t" . '</table>' . "\n" . '<table width="100%"><tr><td id="imEmailFooter" style="font: normal normal normal 7pt \'Tahoma\'; color: #FFFFFF; background-color: transparent; text-align: center; text-decoration: none;  padding: 10px; margin-top: 5px;background-color: transparent">' . "\n\t\t" . 'Ta wiadomość e-mail zawiera informacje przeznaczone wyłącznie dla wymienionych powyżej adresatów.<br>Jeśli ta wiadomość e-mail została wysłana omyłkowo, prosimy powiadomić o tym nadawcę i usunąć wiadomość bez zachowywania kopii.' . "\n\t" . '</td></tr></table>' . "\n\t" . '</body>' . "\n" . '</html>';
$ImMailer->bodyBackground = '#FFFFFF';
$ImMailer->bodyBackgroundEven = '#FFFFFF';
$ImMailer->bodyBackgroundOdd = '#F0F0F0';
$ImMailer->bodyBackgroundBorder = '#CDCDCD';
$ImMailer->bodyTextColorOdd = '#000000';
$ImMailer->bodySeparatorBorderColor = '#000000';
$ImMailer->emailBackground = '#FFFFFF';
$ImMailer->emailContentStyle = 'font: normal normal normal 9pt \'Tahoma\'; color: #000000; background-color: #FFFFFF; text-align: left; text-decoration: none; ';
$ImMailer->emailContentFontFamily = 'font-family: Tahoma;';
ImTopic::$captcha_code = "		<div class=\"x5captcha-wrap\">
			<label>Sekwencja znaków:</label><br />
			<input type=\"text\" class=\"imCpt\" name=\"imCpt\" maxlength=\"5\" />
		</div>
";

// End of file x5settings.php