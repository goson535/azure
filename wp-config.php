<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'admin_faazur' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'admin_faazur' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', 'Hk8ecT0IyH' );

/** Имя сервера MySQL */
define( 'DB_HOST', '92.119.113.153:3306' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'CyJDE?%qk$xmu{)B=tX%gcRcsR_hQEja20:RASgYaL eO,|o%A0m>_s-KXKt0m>#' );
define( 'SECURE_AUTH_KEY',  'F>}`98OlA[;E^M.N:&cyTjq;b7^XSG%T+rqxbYF%LJ4)%f!.9QY.Xt%BZqgHWzeA' );
define( 'LOGGED_IN_KEY',    'B9}6*8T,%Fy4}SG)d8/=Fcy[?1j,WI^S)0P_$pX1?}1q5]I! e<]W7KQGxg%Q]_g' );
define( 'NONCE_KEY',        '_(eeI7+;YsDsb[DCvm^[odmMhY#IG cvB1JR*|zMlbE7/DvfaxP4[cy{G!F(Atz=' );
define( 'AUTH_SALT',        '=!]Tj#`0x3X/[Oswp~N@~X#p`G&,9>H>CVldG6or4[}LtB+B1o;Gkv%e><Q|4XcW' );
define( 'SECURE_AUTH_SALT', 'Jl#Qo&bjKnOCJq;B[>_W40n)WV432v^E57/sM7YGQll?f8wxT 0)vcT4+R+Y@MsJ' );
define( 'LOGGED_IN_SALT',   'F_qa{_t@&<FHh;{BHLJr|7*GqQK)LU9^mzIYGT!5PICa7K.x}@ n@Ga}%`x,m~+T' );
define( 'NONCE_SALT',       'by2JAw)zTFf?%1`]U85{haJ-J:l;YUjE1+pCZ_[C&iEy2oF,m?5p@,Li6VZ^&?bb' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
