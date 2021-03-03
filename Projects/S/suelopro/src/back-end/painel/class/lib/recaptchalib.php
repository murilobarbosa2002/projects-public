<?php function recaptcha_get_html ($pubkey) {
    return '<script src="https://www.google.com/recaptcha/api.js"></script><div class="captcha_wrapper"><div class="g-recaptcha" data-sitekey="'.$pubkey.'"></div></div>'; 
} ?>