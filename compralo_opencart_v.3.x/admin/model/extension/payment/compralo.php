<?php

class ModelExtensionPaymentCompralo extends Model
{
    public function install()
    {
		$this->load->language('extension/payment/compralo');
		
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "compralo_order_invoice` (
			  `compralo_order_invoice_id` INT(11) NOT NULL AUTO_INCREMENT,
			  `order_id` INT(11) NOT NULL,
			  `compralo_order_payment_token` VARCHAR(50) NOT NULL,
			  `compralo_order_payment_url` VARCHAR(100) NOT NULL,
			  `date_added` DATETIME NOT NULL,
			  PRIMARY KEY (`compralo_order_invoice_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
			
        $this->load->model('setting/setting');

        // Default Setting Values
        $defaults = array();
        $defaults['payment_compralo_payment_title'] = $this->language->get('payment_text_title');
        $defaults['payment_compralo_button_confirm'] = $this->language->get('button_confirm_text');
        $defaults['payment_compralo_order_status_id'] = 1;
        $defaults['payment_compralo_paid_status_id'] = 5;
        $defaults['payment_compralo_invalid_status_id'] = 10;
        $defaults['payment_compralo_sort_order'] = 0;
        $defaults['payment_compralo_user_id'] = 0;
        $this->model_setting_setting->editSetting('payment_compralo', $defaults);
    }

	public function uninstall() 
	{
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "compralo_order_invoice`;");
	}
}
