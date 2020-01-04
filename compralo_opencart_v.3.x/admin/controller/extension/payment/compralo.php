<?php

// Admin page controller
class ControllerExtensionPaymentCompralo extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('extension/payment/compralo');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
        $this->load->model('localisation/order_status');
        $this->load->model('localisation/geo_zone');
		
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_compralo', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
        }
		
        $data['action']             = $this->url->link('extension/payment/compralo', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel']             = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);
        $data['order_statuses']     = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }  
		
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
    );
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_extension'),
        'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
    );
        $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('extension/payment/compralo', 'user_token=' . $this->session->data['user_token'], true)
    );

        $fields = array('payment_compralo_order_status_id', 'payment_compralo_api_auth_public','payment_compralo_payment_title','payment_compralo_button_confirm', 'payment_compralo_paid_status_id','payment_compralo_invalid_status_id', 'payment_compralo_status' );

        foreach ($fields as $field) {
            if (isset($this->request->post[$field])) {
                $data[$field] = $this->request->post[$field];
            } else {
                $data[$field] = $this->config->get($field);
            }
        }

        $data['payment_compralo_sort_order'] = isset($this->request->post['payment_compralo_sort_order']) ?  $this->request->post['payment_compralo_sort_order'] :  $this->config->get('payment_compralo_sort_order');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/compralo', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment/compralo')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function install()
    {
        $this->load->model('extension/payment/compralo');

        $this->model_extension_payment_compralo->install();
    }

    public function uninstall()
    {
        $this->load->model('extension/payment/compralo');

        $this->model_extension_payment_compralo->uninstall();
    }
}
