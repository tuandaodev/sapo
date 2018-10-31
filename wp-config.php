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
define('DB_NAME', 'sapo');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '@}2w/|uT6Df .7Oy{4hX#w}~]9ij8po.Yi*ucf]dv3q7*P_O2tlXR;shWO1KwXIw');
define('SECURE_AUTH_KEY',  '-BGwwF/P&g;0(N]./ap1qnEZIi$P-l8/3*J/;pZ=FrIY>QTZO~ YpoU%(MofG.a.');
define('LOGGED_IN_KEY',    'Rwpmv[m:#.c7)ws|pYYY1?!}z}86N2ny;TS~95[BfDbA#1cgdGq^bj]$ I`y`EjT');
define('NONCE_KEY',        'Y*QQ0qZdmp119;n<inj1h<myk}1Sh?p:jNcIY4&{sqyc)=o2$Nk~c?#@c,P:*[S ');
define('AUTH_SALT',        'ceqW=> ;P6b3E{xMso{a7`(OWGPm3f|DwQB4=moZe]{vZBka)oZNC{Xa#p_Uw}X]');
define('SECURE_AUTH_SALT', 'dFizEUB#$Kd7Ge|mSE$D1fo6AMtl<cC{[;t&~rPDHW?p@`qS}oFc8l0L~X .giiF');
define('LOGGED_IN_SALT',   ';3kT4<z(BJHUc/~8QO(Vj@OPUMiw(8RQI6e4XlSNF//:V;p+~(nhH}Gr$j$pT65,');
define('NONCE_SALT',       '0L:3322#@C~,$+L<M3&`}5X3tt+NAQs.@>&wYEr}<F;<w%_~erPuHd6`K|/u-aUa');

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
