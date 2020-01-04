<?php

class ModelExtensionPaymentCompralo extends Model
{
    public function getMethod($address, $total)
    {		
        //$this->load->language('extension/payment/compralo');

        $method_data = array(
        'code'		 => 'compralo',
        'title'		 => $this->config->get('payment_compralo_payment_title'),
        'terms'		 => '',
        'sort_order' => $this->config->get('payment_compralo_sort_order')
      );

        return $method_data;
    }
	
	public function getInvoiceByOrderId($order_id) 
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "compralo_order_invoice` WHERE `order_id` = '" . (int)$order_id . "'");

		if ($query->num_rows) {
			return $query->rows[0];
		}
		return false;
	}

	public function getInvoiceByToken($compralo_token) 
	{
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "compralo_order_invoice` WHERE `compralo_order_payment_token` = '" . $compralo_token . "'");

		if ($query->num_rows) {
			return $query->rows[0];
		}
		return false;
	}

	public function addInvoice($order_id, $compralo_token, $compralo_url) 
	{
		$this->db->query("INSERT INTO `" . DB_PREFIX . "compralo_order_invoice` SET `order_id` = '" . (int)$order_id . "', `date_added` = now(), `compralo_order_payment_token` = '" . $compralo_token . "', `compralo_order_payment_url` = '" . $compralo_url . "'");
	}
}
