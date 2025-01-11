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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'novus6sk_wp933' );

/** Database username */
define( 'DB_USER', 'novus6sk_wp933' );

/** Database password */
define( 'DB_PASSWORD', '8Q7Q-0Sp@4' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'niwhpxerzf7irzjsy6bfwo2bkyrpxbcvbdfw0rhqgek6ifqfwf6sgkfyzvlljnte' );
define( 'SECURE_AUTH_KEY',  'n5vlnxtwy1o8agyzkfbncgf1xii5gykvjecmnzftgtg5c6fdfpb30zth3mvwe4wb' );
define( 'LOGGED_IN_KEY',    '2kevhscqcsncgnzekzy5hejpqdhc7leftt0wfdpmqdmftgnrsrjmodtvvnuf4svi' );
define( 'NONCE_KEY',        'mzzvmz2pvqzwvg7ab5pp6amskzz3tmpavnm0guqrypuxmgb6zoykbjd6ivzykenw' );
define( 'AUTH_SALT',        'ugckhanr7v8rhwkvhicgd2mnw8ccpytfh8vbpa1f4ymahpknzheaesffs617tq4a' );
define( 'SECURE_AUTH_SALT', 'ku7i5mlhpvyixosbsfahjavwnu2fytkpkxpyrwppo60ec7iwmbxz627hbcyphdbb' );
define( 'LOGGED_IN_SALT',   'wcocprtgk77f55xrdcwif3gbpmnma0o6l7qhpb81ccpp8wwsshg3mzxxels10cnc' );
define( 'NONCE_SALT',       't1mqgsbfrgzfuc2uswyljzdjbbtnfr0x79b9h8bnn8b8d6lc3xded9ynvqkxugdf' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpa7_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
