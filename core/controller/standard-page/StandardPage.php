<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/routes/init.php';

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

  final private function renderSearch(?string $ref): :xhp {
      $action = Routes::search($ref);
      return
          <form action={$action} method="get">
            <input type="text" name="q" />
            <input type="submit" value="Search" />
          </form>;
  }

  final private function renderToolbar(Context $ctx, Request $request): :xhp {

      if($ctx->hasPrivilegedAccess()) {
          $refNotFound = $ctx->getApi()->refs()->filter($ref ==> $ref->getRef() == $ctx->getRef())->isEmpty();

          $master = <option>?</option>;
          if(!$refNotFound) {
              $master = <option value="">As currently seen by guest visitors</option>;
              if($ctx->getRef() == $ctx->getApi()->master()->getRef()) {
                  $master->setAttribute('selected', 'selected');
              }
          }

          $exceptMaster = $ctx->getApi()->refs()->filter($ref ==> !$ref->isMasterRef());
          $exceptMaster = $exceptMaster->map($ref ==> {
              $option = <option value={$ref->getRef()}>As {$ref->getLabel()} {$ref->getScheduledAt()} </option>;
              if($ctx->getRef() == $ref->getRef()) {
                  $option->setAttribute('selected', 'selected');
              }
              return $option;
          })->toArray();


          $extraParams = <span></span>;

          $id = $request->getParams()->get('id');
          if($id !== null) {
              $extraParams->appendChild(<input type="hidden" name="id" value={$id} />);
          }

          $slug = $request->getParams()->get('slug');
          if($slug != null) {
              $extraParams->appendChild(<input type="hidden" name="slug" value={$slug} />);
          }

          return
              <div id="toolbar">
                <div id="toolbar">
                  <form method="get">
                    <label for="releaseSelector">See this website: </label>
                    <select id="releaseSelector" name="ref" onchange="this.form.submit()">
                      {$master}
                      <optgroup label="Or preview the website in a future release:">
                        {$exceptMaster}
                      </optgroup>
                    </select>
                    {$extraParams->getChildren()}
                  </form>
                </div>
              </div>;
      } else {
          return <span></span>;
      }
  }

  final private function renderFooter(Context $ctx): :xhp {
    if(!$ctx->hasPrivilegedAccess()) {
        return <a href={Routes::signin()}>Sign in to preview changes</a>;
    } else {
        return <a href={Routes::signout()}>Signout</a>;
    }
  }

  final protected function render(Context $ctx, Request $request): :xhp {
    return
     <div>
       <header>
         {$this->renderToolbar($ctx, $request)}
         <hr/>
         {$this->renderSearch($ctx->getRef())}
       </header>
       <hr/>
       <div class="main">
         {$this->renderMain()}
       </div>
       <hr/>
       <footer>
         {$this->renderFooter($ctx)}
       </footer>
     </div>;
  }
}
