<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/sviesiai/domains/atradimai.lt/public_html/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'sviesiai_wp2');

/** MySQL database username */
define('DB_USER', 'sviesiai_wp2');

/** MySQL database password */
define('DB_PASSWORD', 'M*1)A9e)@QKuhzfdK1(10,,2');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'D8I2%(!Xg,Z{5] wN=V6bz5vL4@+4]YPAX);3@rAUn)P|c+|WMCN4So^jH}Czyjc');
define('SECURE_AUTH_KEY',  ' a*bsUJ*b[}+]sm*(F+~?swYE: ,|4+{Q>{|HH]b?n&<(=9^l|o8bP26JwwiUl.o');
define('LOGGED_IN_KEY',    'gI%9${%/r}!-i##Unlk$i.+5Ea-Yna,,W!!)IU*qk+o^{yNuoyL<Jyk3)UuuWDlf');
define('NONCE_KEY',        'ybHx9usrzx:K`|SYhrsgliYOC`hj|HpL+A>*8UM|)T,O[9>k|+I!n|g+!{`MRF0N');
define('AUTH_SALT',        'omRFWSn{+>kd-C$ta;;%To xm|59U~ILHIMfjnNu5.CmCkAC[$[YSe,XYf&IE>>&');
define('SECURE_AUTH_SALT', '%Pt-;VEGIplnG5DSP:t?#wua5A3uaor^/in(x00,O-,y:Tb2J#,J4[7Mm?Sr,Vl9');
define('LOGGED_IN_SALT',   'uvC-|5d:C/v&cQtqJ&tE->%g43cdK|mFL)~ifu(tGV}YI|FyqJ+ W+g??txdk7A*');
define('NONCE_SALT',       'i:]7<AjC?9|;ejaAnBT,q{-]xgOXgIM(.(@cJ;olPiX.T9ZxmDcmT_cBj3b^{zAR');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
