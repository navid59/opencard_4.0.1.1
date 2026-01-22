<?php
namespace Opencart\Catalog\Model\Extension\Mobilpay\Payment;

/**
 * Class Mobilpay
 *
 * @package Opencart\Catalog\Model\Extension\Mobilpay\Payment
 */
class Mobilpay extends \Opencart\System\Engine\Model
{

    /**
     * @param array $address
     *
     * @return array
     */
    public function getMethod(array $address): array
    {
        $this->load->language('extension/mobilpay/payment/mobilpay');

        if ($this->cart->hasSubscription()) {
            $status = false;
        } elseif (!$this->config->get('payment_mobilpay_geo_zone_id')) {
            $status = true;
        } else {
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone_to_geo_zone` WHERE `geo_zone_id` = '" . (int)$this->config->get('payment_mobilpay_geo_zone_id') . "' AND `country_id` = '" . (int)($address['country_id'] ?? 0) . "' AND (`zone_id` = '" . (int)($address['zone_id'] ?? 0) . "' OR `zone_id` = '0')");

            if ($query->num_rows) {
                $status = true;
            } else {
                $status = false;
            }
        }

        $method_data = [];

        if ($status) {
            $method_data = [
                'code'       => 'mobilpay',
                'title'      => $this->language->get('heading_title'),
                'sort_order' => $this->config->get('payment_mobilpay_sort_order') ?: 0
            ];
        }

        return $method_data;
    }
}