<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/standard-page/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/hhvm/xhp/src/init.php';

class DetailController extends GetController {
    use StandardPage;

    private function getDocumentId(): ?string {
        return (string)parent::getRequest()->getParams()->get('id');
    }

    private function getSlug(): ?string {
        return (string)parent::getRequest()->getParams()->get('slug');
    }

    protected function getTitle(): string {
        return 'Hack Plain Starter - Document detail - ' . $this->getSlug();
    }

    protected function renderMain(): :xhp {
        $ctx = parent::getContext();
        $documentId = $this->getDocumentId();
        if($documentId !== null) {
            $document = Prismic::getDocument($ctx, $documentId);
            if($document) {
                $html = $document->asHtml($ctx->getLinkResolver());
                return <p>{HTML($html)}</p>;
            }
        }
        return <p>Not found !</p>;
    }
}
