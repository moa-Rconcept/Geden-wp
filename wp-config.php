<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'prograirevelo' );


/** Database username */
define( 'DB_USER', 'prograirevelo' );


/** Database password */
define( 'DB_PASSWORD', 'Eernest13' );


/** Database hostname */
define( 'DB_HOST', 'prograirevelo.mysql.db' );


/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );


/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '{MeFF?1d,O|2GwG/{Q/$w/ZI$[1nt.d$#6.~K7B<M3G?]FKp#73GgCJH$08lny!z' );

define( 'SECURE_AUTH_KEY',  'qcg<g-K_a=P!q;9:KZaZLLO8M@b;dVw0K!0!*$wAAbFd`3vJpP(c503TI(<1RJEY' );

define( 'LOGGED_IN_KEY',    'v&e+CPW7cip.Rzx((@;OScZt1BL QIR;+%Fnv*9elQvHWym T*1LWv|}pn|SRdsP' );

define( 'NONCE_KEY',        'W1&`AM%.At!IgxkB@Vz vl+B]p}1A{kB>m7ELgWmK)||KWh5X$4,[Ucm!g<SG`$A' );

define( 'AUTH_SALT',        'MU6F`Pm_uD/@F#um7!zy*>Yw3>Tb0^;[Zm|+Rw2w$Qy1WE~BhCMA^l_#6?NsIM+P' );

define( 'SECURE_AUTH_SALT', 'tP7|gZLqws3=I_u+.o/{s@;gsqw?ko84D!m%T]9@fGl`{9%J1B[h)Pl<(DigP-2k' );

define( 'LOGGED_IN_SALT',   'kUf|9LlF:c~rycDWsXT@,3r<E0G1TvY#s]Ek{MWmLZx0z[a~#Qd$CoFMpPd,Tzra' );

define( 'NONCE_SALT',       'u+WQ#&DUczdnhe|0Ngp)qdr^l#lU5v)[/Av.wziKqyr,@?(UGS o/<`OxG`G<+Zz' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_geden_';


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
