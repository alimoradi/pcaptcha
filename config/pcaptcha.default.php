<?php
return [
		'Pcaptcha' => [
				// Register API keys at https://www.google.com/recaptcha/admin
				'sitekey' => 'site-key',
				'secret' => 'secret',
				// reCAPTCHA supported 40+ languages listed
				// here: https://developers.google.com/recaptcha/docs/language
				'lang' => 'en',
				// either light or dark
				'theme' => 'light',
				// either image or audio
				'type' => 'image',
		]
];