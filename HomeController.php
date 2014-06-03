<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/standard-page/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/routes/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/hhvm/xhp/src/init.php';

class HomeController extends GetController {
    use StandardPage;

    protected function getTitle(): string {
        return 'Hack Plain Starter - All documents';
    }

    protected function renderMain(): :xhp {
        $ctx = parent::getContext();
        $page = parent::getRequest()->getParams()->get('page');
        $page = !is_null($page) ? (int)$page : 1;
        $response = $ctx->getApi()
                         ->forms()
                         ->at('everything')
                         ->ref($ctx->getRef())
                         ->pageSize(10)
                         ->page($page)
                         ->submit();

        $documents = $response->getResults();
        $found = "No documents found";
        if($documents->count() == 1) {
            $found = "One document found";
        } else if($documents->count() > 1) {
            $found = $documents->count() . " documents found";
        }

        $list = <ul />;
        foreach($documents as $doc) {
            $href = Routes::detail($doc->getId(), $doc->getSlug(), $ctx->getRef());
            $link = <a href={$href}>{$doc->getSlug()}</a>;
            $list->appendChild(<li>{$link}</li>);
        }

        $pagination = <div></div>;

        if($response->getPrevPage() !== null) {
            $href = Routes::index($ctx->getRef(), $response->getPage() - 1);
            $pagination->appendChild(<a href={$href}>Previous</a>)->appendChild(" ");
        }

        if($response->getNextPage() !== null) {
            $href = Routes::index($ctx->getRef(), $response->getPage() + 1);
            $pagination->appendChild(<a href={$href}>Next</a>);
        }

        return
            <div>
              <h2>{$found}</h2>
              {$list}
              {$pagination}
            </div>;
    }
}
