?php

/**
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   OpenCart
 * @package    Gulden Payment for OpenCart
 *             based upon Bitcoin Payment for OpenCart
 * @copyright  Copyright (c) 2017 Perry Peeters
 *             Copyright (c) 2015 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

// Heading
$_['heading_title']         = 'Gulden';

// Text
$_['text_payment']          = 'Betaling';
$_['text_success']          = 'Succes: U heeft de Gulden details gewijzigd details!';
$_['text_edit']             = 'Wijzig Gulden';
$_['text_google_api']       = 'Google API';
$_['text_gulden']          = '<a href="https://gulden.com" target="_blank"><img src="view/image/payment/gulden.png" alt="Gulden" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_copyright']        = '<p><a href="https://github.com/biscayne/opencart-gulden" target="_blank">Gulden Payment for OpenCart</a></p><p>Version: 0.1.1</p>';


// Entry
$_['entry_total']           = 'Bestelling Totaal';
$_['entry_order_status']    = 'Bestelling Status';
$_['entry_geo_zone']        = 'Geo Zone';
$_['entry_status']          = 'Status';
$_['entry_sort_order']      = 'Sorteer Bestelling';
$_['entry_user']            = 'RPC Gebruiker';
$_['entry_password']        = 'RPC Wachtwoord';
$_['entry_host']            = 'RPC Host';
$_['entry_port']            = 'RPC Poort';
$_['entry_path']            = 'RPC Pad';
$_['entry_qr']              = 'QR Code';
$_['entry_currency']        = 'Gulden Valuta';

// Help
$_['help_total']            = 'Het totale aankoopbedrag dat de bestelling moet hebben alvorens deze betaalmethode actief wordt.';
$_['help_user']             = 'Gulden RPC Gebruikersnaam';
$_['help_password']         = 'Gulden RPC Wachtwoord';
$_['help_host']             = 'Gulden RPC Host, default: localhost';
$_['help_port']             = 'Gulden RPC Poort, default: 8332';
$_['help_path']             = 'Gulden RPC Pad, default: leeg';
$_['help_qr']               = 'Gulden Adres wordt ook als QR Code weergegeven';
$_['help_currency']         = 'Aanmaken, activeren en wijzigen van Gulden Valuta';

// Error
$_['error_permission']      = 'Waarschuwing: U heeft geen rechten om Gulden betaling te wijzigen!';
$_['error_response']        = 'Waarschuwing: Kon geen verbinding maken met Gulden via RPC! Response: %s';
