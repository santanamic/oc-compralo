<?php

class ControllerExtensionPaymentCompralo extends Controller
{
    public function index()
    {
        //$this->load->language('extension/payment/compralo');
        $this->load->model('checkout/order');

        $data['button_confirm'] = $this->config->get('payment_compralo_button_confirm');
        $data['action'] = $this->url->link('extension/payment/compralo/checkout', '', true);

        return $this->load->view('extension/payment/compralo', $data);
    }

    public function checkout()
    {
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/compralo');
        $order_id = $this->session->data['order_id'];
        $order_info = $this->model_checkout_order->getOrder($order_id);
        $api_key = $this->config->get('payment_compralo_api_auth_public');
        
        $amount = number_format($order_info['total'], 2);
        $store_name = $this->config->get('config_name');
        $call_url = 'https://app.compralo.io/api/v1/seller/generateInvoice';
        $postback_url = $this->url->link('extension/payment/compralo/callback').'&oid='.$order_id;
        $back_url = $this->url->link('extension/payment/compralo/success');

        foreach ($this->cart->getProducts() as $product) {
            $description[] = $product['quantity'] . ' x ' . $product['name'];
        }

        $data  = array(
            'api_key' => $api_key,
            'value' => $amount,
            'store_name' => $store_name,
            'postback_url' => $postback_url,
            'description' => join($description, ', '),
            'back_url' => $back_url,
        );
    
        $options = array(
            'http' => array(
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
				'ignore_errors' => true
            )
        );
        
        $context  = stream_context_create($options);
        $_response = file_get_contents($call_url, false, $context);
        $response = json_decode($_response, true);

        if ($response['status'] !== true) {
            $message = "Compralo returned an error. Error: {$_response}";
            $this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('payment_compralo_invalid_status_id'), "Payment could not be started: {$message}");
            $this->response->redirect($this->url->link('checkout/failure'));
        } else {
            $this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get('payment_compralo_order_status_id'), "Customer redirected to Compralo.io. Token: " . $response['token']);
            $this->model_extension_payment_compralo->addInvoice($order_info['order_id'],$response['token'],$response['checkout_url']);
			// Redirect to payment gateway for payment
            $this->response->redirect($response['checkout_url']);
        }
    }

    public function cancel()
    {
        $this->response->redirect($this->url->link('checkout/cart', ''));
    }

    public function success()
    {
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/compralo');

        $this->response->redirect($this->url->link('checkout/success'));
    }

    public function callback()
    {
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/compralo');
        
		$_response = file_get_contents('php://input');
        $response = json_decode($_response, true);

        $compralo_token = $response['token'];
        $compralo_status = $response['status_id'] ?? $response['status'];
		$invoice = $this->model_extension_payment_compralo->getInvoiceByToken($compralo_token);
		
		if(false !== $invoice) 
		{			
			switch ($compralo_status) {
                case 1:
					$this->model_checkout_order->addOrderHistory($invoice['order_id'], $this->config->get('payment_compralo_paid_status_id'), 'Payment is confirmed on the network, and has been credited to the merchant. Purchased goods/services can be securely delivered to the buyer.');
                    break;
			}
		} 
		
		exit;
    }
}
