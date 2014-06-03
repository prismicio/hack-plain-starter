<?hh // strict

require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/prismic/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/core/controller/standard-page/init.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/hhvm/xhp/src/init.php';

class SigninController extends GetController {
    use StandardPage;

    protected function getTitle(): string {
        return 'Hack Plain Starter - Signin';
    }

    protected function renderMain(): :xhp {
        $oauthInitiateEndpoint = Prismic::oauthInitiateEndpoint(parent::getContext());
        if($oauthInitiateEndpoint !== null) {
            header('Location: ' . $oauthInitiateEndpoint, false, 301);
        } else {
            return <div>Please provide clientId & clientSecret in the conf.</div>;
        }
    }
}
