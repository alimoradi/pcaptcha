<?php
/**
 * Bootstrap
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

// Pass the config data from config/recaptcha.php to Configure Class

Configure::load('Pcaptcha.pcaptcha', 'default', false);
