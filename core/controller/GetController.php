<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';

abstract class GetController extends Controller {
    final protected function __construct(private Request $request, private Context $ctx) {
        parent::__construct();
    }

    final protected function getRequest(): Request {
        return $this->request;
    }

    final protected function getContext(): Context {
        return $this->ctx;
    }

    final public function go(array<mixed, mixed> $get, array<mixed, mixed> $cookies): void {
        $request = new Request(Map::fromArray($get)->toImmMap(), Map::fromArray($cookies)->toImmMap());
        $ctx = Prismic::buildContext($request);
        $controller = new static($request, $ctx);
        echo "<!DOCTYPE html>";
        $head = $controller->getHead();
        $body = $controller->render($ctx);
        echo (string)$head;
        echo (string)$body;
    }
}
