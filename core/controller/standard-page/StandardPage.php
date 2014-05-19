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

trait StandardPage {
  require extends Controller;

  abstract protected function renderMain(): :xhp;

  protected function getExtraCSS(): Set<string> {
    return Set {};
  }

  protected function getExtraJS(): Set<string> {
    return Set {};
  }

  final protected function getCSS(): Set<string> {
    return (Set {
      '/css/base.css',
    })->addAll($this->getExtraCSS());
  }

  final protected function getJS(): Set<string> {
    return (Set {
    })->addAll($this->getExtraJS());
  }

  final private function renderToolbar(): :xhp {
    return
      <div id="toolbar">
          TOOLBAR
      </div>;
  }

  final protected function render(): :xhp {
    return
     <div>
       <header>
         {$this->renderToolbar()}
       </header>
       <div class="main">
         {$this->renderMain()}
       </div>
     </div>;
  }
}
