<?hh
/**
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/routes/init.php';

$request = new Request(Map::fromArray($_GET)->toImmMap(), Map::fromArray($_COOKIE)->toImmMap());
$ctx = Prismic::buildContext($request);
setcookie('ACCESS_TOKEN', "", time() - 1, '/');
header('Location: ' . Routes::index());