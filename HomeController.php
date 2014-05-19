<?hh // strict
/**
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/standard-page/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/hhvm/xhp/src/init.php';

class HomeController extends GetController {
  use StandardPage;

  protected function getTitle(): string {
    return 'Hack Plain Starter - All documents';
  }

  protected function renderMain(): :xhp {
    return <div>
        MAIN
    </div>;
  }
}
