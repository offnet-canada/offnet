<?php
/* ____  _____________   ______________
  / __ \/ ____/ ____/ | / / ____/_  __/
 / / / / /_  / /_  /  |/ / __/   / /   
/ /_/ / __/ / __/ / /|  / /___  / /    
\____/_/   /_/   /_/ |_/_____/ /_/  
 
This is the initation file
*/
//TODO auto detect dir files

//Core
require_once "../core/core.php";
require_once "../core/dbconn.php";
require_once '../core/mail.php';
require_once '../core/Account.php';
require_once '../core/Subscription.php';
require_once '../core/MessageLog.php';
require_once '../core/Verify.php';

//Base
require_once "functions.php";
require_once "read.php";
require_once "Phone.php";
require_once "Email.php";
require_once "Response.php";

//Apps
require_once "apps/help.php";
require_once "apps/weather.php";
require_once "apps/word.php";
require_once "apps/way.php";
require_once "apps/wiki.php";

require_once "apps/RSS/rss.php";
//require_once "apps/Web/web.php";

