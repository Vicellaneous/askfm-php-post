<?php
$ask = new AskFM();
$ask->username="xxx";
$ask->password="yyy";
$login = $ask->getLoginPage();
$authenticity_token = $ask->getAuthenticityToken($login[0]);
$logged = $ask->postLogin($authenticity_token, $login[1]);