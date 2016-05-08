<?php

namespace Pcaptcha\Pcaptcha;
use Cake\Network\Http\Client;

use Pcaptcha\Pcaptcha\PcaptchaResponse;
/**
 * Recaptcha class
 */
class Pcaptcha
{
    /**
     * @var string
     */
    protected static $signupUrl = "https://www.google.com/recaptcha/admin";
    /**
     * @var string
     */
    protected static $siteVerifyUrl = "https://www.google.com/recaptcha/api/siteverify";
    /**
     * @var string
     */
    protected $secret;
    /**
     * @var RecaptchaResponse Recaptcha Response.
     */
    protected $recaptchaResponse;
    /**
     * Constructor.
     *
     * @param RecaptchaResponse $recaptchaResponse Recaptcha Response.
     * @param string $secret Required. The shared key between your site and ReCAPTCHA.
     *
     * @return void
     */
    public function __construct(PcaptchaResponse $recaptchaResponse, $secret)
    {
        $this->recaptchaResponse = $recaptchaResponse;
        if ($secret == null || $secret == "") {
            
        }
        $this->secret = $secret;
    }
    /**
     * Calls the reCAPTCHA siteverify API to verify whether the user passes
     * CAPTCHA test.
     *
     * @param HttpClientInterface $httpClient Required. HttpClient.
     * @param string $response Required. The user response token provided by the reCAPTCHA to the user and provided to your site on.
     * @param string $remoteIp Optional. The user's IP address.
     *
     * @return bool
     */
    public function verifyResponse(Client $httpClient, $response, $remoteIp = null)
    {
        if (is_null($this->secret)) {
            return false;
        }
        // Get Json GRecaptchaResponse Obj from Google server
        $postOptions = [
            'secret' => $this->secret,
            'response' => $response
        ];
        if (!is_null($remoteIp)) {
            $postOptions['remoteip'] = $remoteIp;
        }
        $gRecaptchaResponse = $httpClient->post(self::$siteVerifyUrl, $postOptions);
        // problem while accessing remote
        if (!$gRecaptchaResponse->isOk()) {
            return false;
        }
        $this->recaptchaResponse->setJson($gRecaptchaResponse->json);
        if ($this->recaptchaResponse->isSuccess()) {
            return true;
        }
        return false;
    }
}