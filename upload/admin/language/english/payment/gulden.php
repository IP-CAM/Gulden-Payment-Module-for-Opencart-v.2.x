<?php

/**
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   OpenCart
 * @package    Gulden Payment for OpenCart
 *             Based upon Bitcoin Payment for OpenCart
 * @copyright  Copyright (c) 2017 Perry Peeters
 *             Copyright (c) 2015 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

// Heading
$_['heading_title']         = 'Gulden';

// Text
$_['text_payment']          = 'Payment';
$_['text_success']          = 'Success: You have modified Gulden details!';
$_['text_edit']             = 'Edit Gulden';
$_['text_google_api']       = 'Google API';
$_['text_gulden']          = '<a href="https://gulden.com" target="_blank"><img src="view/image/payment/gulden.png" alt="Gulden" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_copyright']        = '<p><a href="https://github.com/biscayne/opencart-gulden" target="_blank">Gulden Payment for OpenCart</a></p><p>Version: 0.1.1</p>';


// Entry
$_['entry_total']           = 'Order Total';
$_['entry_order_status']    = 'Order Status';
$_['entry_geo_zone']        = 'Geo Zone';
$_['entry_status']          = 'Status';
$_['entry_sort_order']      = 'Sort Order';
$_['entry_user']            = 'RPC User';
$_['entry_password']        = 'RPC Password';
$_['entry_host']            = 'RPC Host';
$_['entry_port']            = 'RPC Port';
$_['entry_path']            = 'RPC Path';
$_['entry_qr']              = 'QR Code';
$_['entry_currency']        = 'Gulden Currency';

// Help
$_['help_total']            = 'The checkout total the order must reach before this payment method becomes active.';
$_['help_user']             = 'Gulden RPC Username';
$_['help_password']         = 'Gulden RPC Password';
$_['help_host']             = 'Gulden RPC Host, localhost by default';
$_['help_port']             = 'Gulden RPC Port, 8332 by default';
$_['help_path']             = 'Gulden RPC Path, empty by default';
$_['help_qr']               = 'Gulden Address will be formatted as additional QR Code';
$_['help_currency']         = 'Create, activate and change your Gulden Currency';

// Error
$_['error_permission']      = 'Warning: You do not have permission to modify payment Gulden!';
$_['error_response']        = 'Warning: Could not connect to Gulden via RPC! Response: %s';
