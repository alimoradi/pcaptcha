<?php
/**
 * Recaptcha Helper
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Pcaptcha\View\Helper;
use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\View\Helper;
use Cake\View\View;

class CaptchaHelper  extends Helper
{
  
    protected $widgets;
    /**
     * SecureApiUrl
     *
     * @var string
     */
    protected static $secureApiUrl = "https://www.google.com/recaptcha/api";
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        // If no language is found anywhere
        'lang' => 'en',
        // If no theme is found anywhere
        'theme' => 'light',
        // If no type is found anywhere
        'type' => 'image'
    ];
    /**
     * Constructor
     *
     * @param View $view View
     * @param array $config Config
     *
     * @return void
     */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);
        // Merge Options given by user in config/recaptcha
        $configRecaptcha = Configure::read('Recaptcha');
        $this->config($configRecaptcha);
        $lang = $this->config('lang');
        if (empty($lang)) {
            $this->config('lang', I18n::locale());
        }
        // Validate the Configure Data
       
        // unset secret param
        $this->config('secret', '');
    }
    /**
     * Render the recaptcha div and js script.
     *
     * @param array $options Options.
     * - sitekey
     * - lang
     * - theme
     * - type
     *
     * @return string HTML
     */
    public function display(array $options = [])
    {
        // merge options
        $options = array_merge($this->config(), $options);
        // Validate the Configure Data
        
        extract($options);
        return '<div class="g-recaptcha" data-sitekey="' . $sitekey . '" data-theme="' . $theme . '" data-type="' . $type . '"></div>
        <script type="text/javascript"
        src="' . self::$secureApiUrl . '.js?hl=' . $lang . '">
        </script>';
    }
   
}