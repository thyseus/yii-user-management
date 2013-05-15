<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

// ------------------------------------------------------------------------
//	HybridAuth End Point
// ------------------------------------------------------------------------

require_once( "protected/modules/user/vendors/hybridauth/Hybrid/Auth.php" );
require_once( "protected/modules/user/vendors/hybridauth/Hybrid/Endpoint.php" ); 

Hybrid_Endpoint::process();
