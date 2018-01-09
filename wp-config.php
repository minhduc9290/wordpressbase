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
/** Fix can't upload plugin */
define('FS_METHOD', 'direct');

/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'mysqlpass');

/** MySQL hostname */
define('DB_HOST', 'wp-db');

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
define('AUTH_KEY',         'Bt^.xG]h0$#_[iF^e~:M-1g@g/Poopaf0+isz#*[*(NG.80|5_P$uZ0d_l_5`JxW');
define('SECURE_AUTH_KEY',  ']M>!@F-9KVOR~K6S5n@q^mb]ux_4Qno&W:2=%Tjd|gSeylm(cFDXRjoSh[z,eMvf');
define('LOGGED_IN_KEY',    'Z>%Xf*+F/h1!Aao,%wTP=]SIsK#7^?#F(oUQ<,0TQV&-2=tFeinv,MJ=V^&!+O6^');
define('NONCE_KEY',        '2oZH5#6J?Gwa]bAxRt,n^3_XX`zx|x?EB6t4J;@;8}enHcEaI(bMr`:HkauBH^+B');
define('AUTH_SALT',        '/2_Y{)-dqJ6_4;i-OSzsPQ6nSE0/WTTRGum<]8I$7J+MLKlYAVj,DV4i:zDo}uKb');
define('SECURE_AUTH_SALT', '^r&PG|v^!Z{c;Uz0De~K|4Q,)sjGnpciArotth.D?Z{9o*fVRb<LNOk4;opb+62$');
define('LOGGED_IN_SALT',   'lMFIX/=:}N6@ElEa.PqhP{lh}HzBL8TZ=%S-m wPG~R8>QJ8%$Bp<N?G%TB-kzQl');
define('NONCE_SALT',       '0-[m9u[uL=<A2w=q#z@0nf>`+K?S@<*R8%8D]Q*h*a6k:@H@69c<1h:`W-ST?!uC');

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
