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
 *             based upon Bitcoin Payment for OpenCart
 * @copyright  Copyright (c) 2017 Perry Peeters
 *             Copyright (c) 2015 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */
class ControllerExtensionPaymentGulden extends Controller {
    private $_gulden;
    public function __construct($registry) {
        parent::__construct($registry);
        // Load dependencies
        $this->load->language('extension/payment/gulden');
        $this->load->library('gulden');
        $this->load->model('checkout/order');
        // Connect to the server
        $this->_gulden = new Gulden(
            $this->config->get('gulden_user'),
            $this->config->get('gulden_password'),
            $this->config->get('gulden_host'),
            $this->config->get('gulden_port'),
            $this->config->get('gulden_path')
        );
        // Check for errors
        if ($this->_gulden->error) {
            // Save errors to the log
            $log = new Log('gulden.log');
            $log->write($this->_gulden->error);
            // Force exit
            exit;
        }
    }
    public function index() {
        // Create invoice
        $data['text_instruction'] = $this->language->get('text_instruction');
        $data['text_loading']     = $this->language->get('text_loading');
        $data['text_description'] = sprintf($this->language->get('text_description'),
                                            $this->currency->format($this->cart->getTotal(),
                                            $this->config->get('gulden_currency')));
        $data['button_confirm']   = $this->language->get('button_confirm');
        $data['continue']         = $this->url->link('checkout/success');
        $data['address']          = $this->_gulden->getaccountaddress((string)$this->session->data['order_id']);
        // Load QR code if enabled
        if ($data['address']) {
            switch ($this->config->get('gulden_qr')) {
                // Google API
                case 'google':
                    $data['qr'] = 'https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=' . $data['address'];
                    break;
                // QR is disabled
                default:
                    $data['qr'] = false;
            }
        }
        // Load the template
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/gulden.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/gulden.tpl', $data);
        } else {
            return $this->load->view('payment/gulden.tpl', $data);
        }
    }
    public function confirm() {
        // Confirm an order if payment gateway is Gulden
        if ($this->session->data['payment_method']['code'] == 'gulden') {
            $this->model_checkout_order->addOrderHistory(
                $this->session->data['order_id'],
                $this->config->get('gulden_order_status_id'),
                // Save Gulden Address to the Order History
                sprintf($this->language->get('text_gulden_address'),
                        $this->_gulden->getaccountaddress((string)$this->session->data['order_id'])),
                true
            );
        }
    }
}
