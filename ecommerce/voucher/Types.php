<?php
/**
 * eCommerce Voucher
 *
 * Copyright (c) 2014 David Persson - All rights reserved.
 * Copyright (c) 2016 Atelier Disko - All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace ecommerce_voucher\ecommerce\voucher;

use ecommerce_voucher\ecommerce\voucher\Type;

class Types {

	use \base_core\core\Registerable;
	use \base_core\core\RegisterableEnumeration;

	public static function register($name, array $object) {
		static::$_registry[$name] = new Type($object + compact('name'));
	}
}

?>
