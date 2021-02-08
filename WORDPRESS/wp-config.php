<?php
/**
 * Podstawowa konfiguracja WordPressa.
 *
 * Skrypt wp-config.php używa tego pliku podczas instalacji.
 * Nie musisz dokonywać konfiguracji przy pomocy przeglądarki internetowej,
 * możesz też skopiować ten plik, nazwać kopię "wp-config.php"
 * i wpisać wartości ręcznie.
 *
 * Ten plik zawiera konfigurację:
 *
 * * ustawień MySQL-a,
 * * tajnych kluczy,
 * * prefiksu nazw tabel w bazie danych,
 * * ABSPATH.
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Ustawienia MySQL-a - możesz uzyskać je od administratora Twojego serwera ** //
/** Nazwa bazy danych, której używać ma WordPress */
define('DB_NAME', 'queiker_wordpress');

/** Nazwa użytkownika bazy danych MySQL */
define('DB_USER', 'queiker_wordpress');

/** Hasło użytkownika bazy danych MySQL */
define('DB_PASSWORD', 'qwea12');

/** Nazwa hosta serwera MySQL */
define('DB_HOST', 'localhost');

/** Kodowanie bazy danych używane do stworzenia tabel w bazie danych. */
define('DB_CHARSET', 'utf8mb4');

/** Typ porównań w bazie danych. Nie zmieniaj tego ustawienia, jeśli masz jakieś wątpliwości. */
define('DB_COLLATE', '');

/**#@+
 * Unikatowe klucze uwierzytelniania i sole.
 *
 * Zmień każdy klucz tak, aby był inną, unikatową frazą!
 * Możesz wygenerować klucze przy pomocy {@link https://api.wordpress.org/secret-key/1.1/salt/ serwisu generującego tajne klucze witryny WordPress.org}
 * Klucze te mogą zostać zmienione w dowolnej chwili, aby uczynić nieważnymi wszelkie istniejące ciasteczka. Uczynienie tego zmusi wszystkich użytkowników do ponownego zalogowania się.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '_O4lihFe(4|n)msS|Go06 Se8Kht[qdLP=N46YZ3({(Ds@mAQvzy`q8daUJ|HTMr');
define('SECURE_AUTH_KEY',  'im=;{l>{sDf/>QzI~h]g4aEqm2Bw|q1[9|Ol,E:Mjh}*+:F$we!!V#Gh/w{Nt,;)');
define('LOGGED_IN_KEY',    '~?v&B+,;a,p2;A82_`+S=:i+P4t:~+Ge~xXJfZeo&ee,v{&v-x;h+%:N8sy{F+if');
define('NONCE_KEY',        'TMpK:|Zt+x8+}*CAPEbLM`=/P|R%d!{+uu}?c+J*t%~^6~H71?g4u|@+T=qU}T!U');
define('AUTH_SALT',        'AC~eeSgD:PXk-53o)7xB(Upmgx`/U ZQJ<f@RlmeJ,eMR+]^CU|#AoLGp</t-=k.');
define('SECURE_AUTH_SALT', '%g>7&}C!-M;.f6$Gq)EukFsF~ S*4.lsLp[ZO[`z{ZZ7&#L@A1J6^^|z$5a&W$g+');
define('LOGGED_IN_SALT',   'W[@f2@I$C(&a<kL|*X_tb-;.?%ZS41/6482vL*)$Z+%?]Ad|.m|c8Pn2L4w(uF(c');
define('NONCE_SALT',       'jMYRUC=dR%(;#G_sNG6KsS-5w-/+HE KB?MF(S(.f1c|r%V$enuG? r+f|]IB/k.');

/**#@-*/

/**
 * Prefiks tabel WordPressa w bazie danych.
 *
 * Możesz posiadać kilka instalacji WordPressa w jednej bazie danych,
 * jeżeli nadasz każdej z nich unikalny prefiks.
 * Tylko cyfry, litery i znaki podkreślenia, proszę!
 */
$table_prefix  = 'wordpress_';

/**
 * Dla programistów: tryb debugowania WordPressa.
 *
 * Zmień wartość tej stałej na true, aby włączyć wyświetlanie
 * ostrzeżeń podczas modyfikowania kodu WordPressa.
 * Wielce zalecane jest, aby twórcy wtyczek oraz motywów używali
 * WP_DEBUG podczas pracy nad nimi.
 *
 * Aby uzyskać informacje o innych stałych, które mogą zostać użyte
 * do debugowania, przejdź na stronę Kodeksu WordPressa.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* To wszystko, zakończ edycję w tym miejscu! Miłego blogowania! */

/** Absolutna ścieżka do katalogu WordPressa. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Ustawia zmienne WordPressa i dołączane pliki. */
require_once(ABSPATH . 'wp-settings.php');
