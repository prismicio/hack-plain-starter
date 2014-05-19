<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';

use Prismic\Fragment\Link\DocumentLink;

class LinkResolver extends \Prismic\LinkResolver {

    public function __construct(private string $ref) {
    }

    public function resolve(DocumentLink $link): string {
        return Routes::detail($link->getId(), $link->getSlug(), $this->ref);
    }
};