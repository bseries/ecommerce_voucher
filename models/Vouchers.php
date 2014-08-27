<?php
/**
 * Boutique Voucher
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace ecommerce_voucher\models;

class Vouchers extends \cms_core\models\Base {

	protected $_meta = [
		'source' => 'ecommerce_vouchers'
	];

	protected static $_actsAs = [
		'cms_core\extensions\data\behavior\Timestamp'
	];

	/*
	public function isExpired($entity) {
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $entity->modified);
		return strtotime(Settings::read('checkout.expire'), $date->getTimestamp()) < time();
	}
	 */

	public static function generateToken() {
		$length = 8;
		$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ2345679';
		$token = '';

		while (strlen($token) < $length) {
			$token .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $token;
	}
}

Vouchers::applyFilter('create', function($self, $params, $chain) {
	if (empty($params['data']['token'])) {
		$params['data']['token'] = Vouchers::generateToken();
	}
	return $chain->next($self, $params, $chain);
});


?>