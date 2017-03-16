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

class ModelPaymentGulden extends Model {

    public function getMethod($address, $total) {

        // Load dependencies
        $this->load->library('gulden');
        $this->load->language('payment/gulden');

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

            // Block this payment gateway if connection failed
            return false;
        }

        // Get active Geo-Zones
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('gulden_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

        // Check for order total
        if ($this->config->get('gulden_total') > 0 && $this->config->get('gulden_total') > $total) {
            $status = false;

        // Check for Geo-Zone
        } elseif (!$this->config->get('gulden_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        // Add Gulden Payment Option to the Order Form
        $method_data = array();

        if ($status) {
            $method_data = array(
                'code'       => 'gulden',
                'title'      => $this->language->get('text_title'),
                'terms'      => '',
                'sort_order' => $this->config->get('gulden_sort_order')
            );
        }

        return $method_data;
    }
}
