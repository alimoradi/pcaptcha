<?php

namespace Pcaptcha\Controller\Component;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Http\Client;
use Exception;
use Pcaptcha\Pcaptcha\Pcaptcha;
use Pcaptcha\Pcaptcha\PcaptchaResponse;

class CaptchaComponent extends Component {
	protected $_defaultConfig = [];
    /**
     * RecaptchaResponse.
     *
     * @var RecaptchaResponse
     */
    protected $pcaptchaResponse;
    /**
     * Recaptcha.
     *
     * @var Recaptcha
     */
    protected $pcaptcha;
    
    
	public function initialize(array $config) {
	}
	public function startup(Event $event) {
		$secret = Configure::read ( 'Pcaptcha.secret' );
		// throw an exception if the secret is not defined in config/recaptcha.php file
		if (empty ( $secret )) {
			throw new Exception ( __d ( 'recaptcha', "You must set the secret Recaptcha key in config/pcaptcha.php file" ) );
		}
		$this->pcaptchaResponse = new PcaptchaResponse ();
		// instantiate Recaptcha object that deals with retrieving data from google recaptcha
		$this->pcaptcha = new Pcaptcha ( $this->pcaptchaResponse, $secret );
		
		$controller = $event->subject ();
		$this->setController ( $controller );
	}
	public function setController($controller) {
		// Add the helper on the fly
		//debug(Configure::read ( 'Pcaptcha.sitekey' ));die;
		if (! isset ( $controller->helpers ['Pcaptcha.Captcha'] )) {
			$controller->helpers ['Pcaptcha.Captcha'] = ['sitekey' =>Configure::read ( 'Pcaptcha.sitekey' ) ];
		}
	}
	public function verify($inQuery = false)
	{
		$controller = $this->_registry->getController();
		
		if($inQuery)
			$r = $controller->request->query["g-recaptcha-response"];
		else 
			$r = $controller->request->data["g-recaptcha-response"];
		$controller = $this->_registry->getController();
		if (isset($r)) {
			$gRecaptchaResponse = $r;
			$resp = $this->pcaptcha->verifyResponse(
					new Client(),
					$gRecaptchaResponse
			);
			// if verification is correct,
			if ($resp) {
				return true;
			}
		}
		return false;
	}
}