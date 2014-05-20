<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/standard-page/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/hhvm/xhp/src/init.php';

class SearchController extends GetController {
    use StandardPage;

    private function getTerms(): ?string {
        return (string)parent::getRequest()->getParams()->get('q');
    }

    protected function getTitle(): string {
        return 'Hack Plain Starter - Document search - ' . $this->getTerms();
    }

    protected function renderMain(): :xhp {
        $ctx = parent::getContext();
        $terms = $this->getTerms();
        if($terms !== null) {
            $documents = Prismic::fulltext($ctx, $terms);
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
        } else {
            return <p>Not found !</p>;
        }
    }
}
