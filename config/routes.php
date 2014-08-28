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

use lithium\net\http\Router;

$persist = ['persist' => ['admin', 'controller']];

Router::connect('/admin/ecommerce/vouchers/{:id:[0-9]+}', [
	'controller' => 'VoucherCodes', 'library' => 'ecommerce_voucher', 'action' => 'view', 'admin' => true
], $persist);
Router::connect('/admin/ecommerce/vouchers/{:action}', [
	'controller' => 'VoucherCodes', 'library' => 'ecommerce_voucher', 'admin' => true
], $persist);
Router::connect('/admin/ecommerce/vouchers/{:action}/{:id:[0-9]+}', [
	'controller' => 'VoucherCodes', 'library' => 'ecommerce_voucher', 'admin' => true
], $persist);
Router::connect('/admin/ecommerce/vouchers/{:id:[0-9]+}/status/{:status}', [
	'controller' => 'VoucherCodes', 'action' => 'update_status', 'library' => 'ecommerce_voucher', 'admin' => true
], $persist);

?>