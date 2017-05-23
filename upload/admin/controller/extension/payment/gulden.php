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
 .             Copyright (c) 2015 Eugene Lifescale (a.k.a. Shaman) by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

class ControllerExtensionPaymentGulden extends Controller {

    private $error = array();

    public function index() {

        // Load dependencies
        $this->load->model('setting/setting');
        $data = $this->load->language('payment/gulden');

        // Validate & save changes
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_setting_setting->editSetting('gulden', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));

        }

        // Display warnings if exists
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
                // Build breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('payment/gulden', 'token=' . $this->session->data['token'], 'SSL')
        );

        // Form processing
        $data['action'] = $this->url->link('payment/gulden', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/currency');
        $data['currencies'] = $this->model_localisation_currency->getCurrencies();

        if (isset($this->request->post['gulden_user'])) {
            $data['gulden_user'] = $this->request->post['gulden_user'];
        } else {
            $data['gulden_user'] = $this->config->get('gulden_user');
        }

        if (isset($this->request->post['gulden_password'])) {
            $data['gulden_password'] = $this->request->post['gulden_password'];
        } else {
            $data['gulden_password'] = $this->config->get('gulden_password');
                    if (isset($this->request->post['gulden_host'])) {
            $data['gulden_host'] = $this->request->post['gulden_host'];
        } else if ($this->config->get('gulden_host')) {
            $data['gulden_host'] = $this->config->get('gulden_host');
        } else {
            $data['gulden_host'] = 'localhost';
        }

        if (isset($this->request->post['gulden_port'])) {
            $data['gulden_port'] = $this->request->post['gulden_port'];
        } else if ($this->config->get('gulden_port')) {
            $data['gulden_port'] = $this->config->get('gulden_port');
        } else {
            $data['gulden_port'] = 8332;
        }

        if (isset($this->request->post['gulden_path'])) {
            $data['gulden_path'] = $this->request->post['gulden_path'];
        } else {
            $data['gulden_path'] = $this->config->get('gulden_path');
        }

        if (isset($this->request->post['gulden_total'])) {
            $data['gulden_total'] = $this->request->post['gulden_total'];
        } else {
            $data['gulden_total'] = $this->config->get('gulden_total');
        }

        if (isset($this->request->post['gulden_qr'])) {
            $data['gulden_qr'] = $this->request->post['gulden_qr'];
        } else {
            $data['gulden_qr'] = $this->config->get('gulden_qr');
        }

        if (isset($this->request->post['gulden_currency'])) {
            $data['gulden_currency'] = $this->request->post['gulden_currency'];
        } else {
            $data['gulden_currency'] = $this->config->get('gulden_currency');
        }
        
        if (isset($this->request->post['gulden_order_status_id'])) {
            $data['gulden_order_status_id'] = $this->request->post['gulden_order_status_id'];
        } else {
            $data['gulden_order_status_id'] = $this->config->get('gulden_order_status_id');
        }

        if (isset($this->request->post['gulden_geo_zone_id'])) {
            $data['gulden_geo_zone_id'] = $this->request->post['gulden_geo_zone_id'];
        } else {
            $data['gulden_geo_zone_id'] = $this->config->get('gulden_geo_zone_id');
        }

        if (isset($this->request->post['gulden_status'])) {
            $data['gulden_status'] = $this->request->post['gulden_status'];
        } else {
            $data['gulden_status'] = $this->config->get('gulden_status');
        }

        if (isset($this->request->post['gulden_sort_order'])) {
            $data['gulden_sort_order'] = $this->request->post['gulden_sort_order'];
        } else {
            $data['gulden_sort_order'] = $this->config->get('gulden_sort_order');
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // Load the template
        $this->response->setOutput($this->load->view('payment/gulden.tpl', $data));
    }

    protected function validate() {

        // Load dependencies
        $this->load->library('gulden');

       // Check permissions
        if (!$this->user->hasPermission('modify', 'payment/gulden')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        // Check connection
        $gulden = new Gulden(
            $this->request->post['gulden_user'],
            $this->request->post['gulden_password'],
            $this->request->post['gulden_host'],
            $this->request->post['gulden_port'],
            $this->request->post['gulden_path']
        );

        if ($gulden->error) {
            $this->error['warning'] = sprintf($this->language->get('error_response'), $gulden->error);
        }

        return !$this->error;
    }
}

