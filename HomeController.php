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
        $documents = $ctx->getApi()->forms()->at('everything')->ref($ctx->getRef())->submit();

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

        return <div>
        <h2>{$found}</h2>
        {$list}
        </div>;
    }
}
