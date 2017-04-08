<?php
/**
 * eCommerce Voucher
 *
 * Copyright (c) 2014 Atelier Disko - All rights reserved.
 *
 * Licensed under the AD General Software License v1.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *
 * You should have received a copy of the AD General Software
 * License. If not, see https://atelierdisko.de/licenses.
 */

namespace ecommerce_voucher\ecommerce\voucher;

use li3_access\security\Access;
use BadMethodCallException;
use AD\Finance\Price\NullPrice;

class Type {

	protected $_config = [];

	public function __construct(array $config) {
		if (isset($config['access'])) {
			$config['access'] = (array) $config['access'];
		}
		return $this->_config = $config + [
			// The (display) title, can also be an anonymous function.
			'title' => null,

			// A price for what this worth of this voucher type is by default.
			'worth' => new NullPrice(),

			// Set of conditions of which any must be fulfilled, so
			// that the type is made available to a user.
			'access' => ['user.role:admin'],

			'redeem' => function($user) {
				// Do sth. with cart or invoice.
				// FIXME Pass in cart - if needed.
			},

			// Dependent on $format return either HTML or plaintext. Can be an anonymous function.
			'info' => null
		];
	}

	public function __call($name, array $arguments) {
		if (!array_key_exists($name, $this->_config)) {
			throw new BadMethodCallException("Method or configuration `{$name}` does not exist.");
		}
		return $this->_config[$name];
	}

	public function hasAccess($user) {
		return Access::check(
			'entity',
			$user,
			$this,
			$this->_config['access']
		);
	}

	public function title() {
		return is_callable($value = $this->_config[__FUNCTION__]) ? $value() : $value;
	}

	public function info($context, $format, $renderer, $order) {
		return is_callable($value = $this->_config[__FUNCTION__]) ? $value($context, $format, $renderer, $order) : $value;
	}

	public function redeem($user) {
		return $this->_config['redeem']($user);
	}
}

?>