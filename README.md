yii-user-management
===================

A user management module collection for the yii framework 1.1.x

Features:
---------

* An automated Installer
* User Administration
* Role Administration
* Hybrid auth is bundled and can easily be integrated, see docs/hybridauth.txt.
* All providers of hybrid auth and hybrid auth extra package are integrated:
AOL, Google, Mail.ru, Plurk, Tumblr, Yahoo, Disqus, Identica, Murmur, px500, 
TwitchTV, Yandex, Facebook, Instagram, MySpace, QQ, Twitter, Foursquare, 
LastFM, Odnoklassniki, Sina, Viadeo, GitHub, LinkedIn, OpenID, Skyrock, 
Vimeo, Goodreads, Live, Pixnet, Steam, Vkontakte
* Permission System with a mixture of RBAC and ACL (see docs)
* Profiles & Profile history & Profile Comments & Profile Fields Administration
* Messaging System (send/receive Messages between Users) Submodule
* User groups (user can add new groups, other users can join)
* User Avatar upload
* User Registration
* Password Recovery
* Friendship system
* Mailing component (users can choose which messages he gets by email)
* Base Language: English 
* Complete Translations to german, french
* Almost complete Translation to spain thanks to bigchirv@gmail.com
* Incomplete Translations to russian and polish

Installation Instructions:
--------------------------

* The Yii User Management Module needs a mysql Database Connection to 
work. 

* Extract the Yii User Management Module under the modules/ directory
of your Web Application. 

```
$ cd testdrive/protected
$ mkdir modules
$ cd modules
$ wget http://www.yiiframework.com/extension/yii-user-management/files/yii-user-management_0.9.tar.bz2
$ tar xvf yii-user-management_0.9.tar.bz2
```

* The Yii-user-management module contains submodules that you just extracted
into your application's modules/ directory. You can remove all submodules
you do not need.

$ [youreditor] protected/config/main.php

Add these lines:

```
'modules' => array(
		'user' => array(
			'debug' => true,
			)
		),
```

The debug option is needed for the installation and should be set to false 
after the installation. 

* To let your Web Application use the Authentification Methods of
the User Management Module, we need to overwrite the default 
CWebUser Component with YumWebUser in your Application Configuration:

```
 'components'=>array(
   'user'=>array(
        'class' => 'application.modules.user.components.YumWebUser',
        'allowAutoLogin'=>true,
        'loginUrl' => array('//user/user/login'),
        [...]
      ),

 'import'=>array(  
  'application.modules.user.models.*',
	[...]
```
    
This tells our Web Application that is can access the Model 'User'
even when not in the modules/user environment. This is needed for calling
User::hasRole($role) in your Code to check if the logged in User belongs to the
role. This is explained in the detailed Documentation. It is good to let this 
line occur as the first included Model, so you can extend the User-Model with 
your own in your Application models/ Directory if you like.

* Make sure to set a caching component in your application components
section. Yum relies on it. If you do not want to use a cache, add

```
	'components' => array(
			'cache' => array('class' => 'system.caching.CDummyCache'),
```

inside the components section of your config/main.php.

Also see http://www.yiiframework.com/doc/guide/1.1/en/caching.overview about
some general information about caching in yii.

* Run the User Management Installer in your Web-Browser:

http://localhost/testdrive/index.php/user/install
or
http://localhost/testdrive/index.php?r=user/install

depending on your URL route setup. 

* Now the Installer of the User Management Module should appear.
To the right you can set up alternate Table Names used by the
Module. In most cases this is not needed and you can keep this 
Settings. If you do change this, be sure to set up the correct table
Names in your Application Configuration, so the User Module can access
them.

Click 'Install Module'. After clicking it, the install script will
create the database tables needed by the module(s). Then it will show
you the neccesary modifications to be made. Add the Modules you need to your 
Application Configuration as provided by the install script in config/main.php.
You can also remove the Yum modules you don't want to use.

* Congratulations, you have installed the User Management Module! Lets
tidy up a little bit:

* Login as admin/admin and navigate to index.php?r=user/user/admin.
This is your user management administration panel. Click on "Administrate your Users"
Now you are taken to the default Front-End Login-Screen of the User 
Management Module. Log in with the Username admin and Password admin.

* Click on the 'update Icon' (the pencil) of your administrator User.
Change the Password to something more safe than 'admin'. Click Save.

* If you didn't already, remove the 'debug' => 'true' line from your
Application Configuration, so your new data can't get overwritten accidentally
by the installation process.

Configuration of your freshly installed User Management Module:
---------------------------------------------------------------

Language:
---------
The Yii-User Management Module uses the language that is set in
the Application Configuration. For example, you can add a 

'language' => 'de',

in your config/main.php to get German Language strings. At the moment
English, German, French and Polish are supported. 

Quick Login Widget:
-------------------
If you want to display a quick login widget somewhere in your Web Application,
just call in your view file:

<?php $this->widget('application.modules.user.components.LoginWidget'); ?>

Password Requirements:
----------------------
You can setup the password Requirements within the 'passwordRequirements' 
option of the Module, for example:

 'user' => array(
        'passwordRequirements' => array(                                        
          'minLen' => 4,
          'maxLen' => 16,
          'maxRepetition' => 2,
          'minDigits' => 3,
          ),

Please see components/CPasswordValidator.php for possible password 
requirement options

User Registration:
------------------
Set the Variable 'enableActivationConfirmation' to false in the module configuration to 
let users register for your application without needing to receive/click an emailed confirmation link.

Role Management:
----------------
You can add up new roles in the Role Manager. To check for access
to this roles, you can use this code Snippet everywhere in your
Yii Application. Most likely it will be used in the ACL Filter of
your Controllers:


```
if(Yii::app()->user->can('action'))
{
 // user is allowed
}
else
{
 // user is not allowed to do this
}
```

Please see the file docs/logging.txt for information on how to set up
the logging functions of the Yii User Management module.

Where to go from now on?
------------------------
There are some examples on how to extend from the Yii User Management
Module and how to implement project-specific stuff. See the files in 
the docs/ directory for all this.

See docs/hybridauth.txt for instruction on how to use the wonderful
hybrid auth framework that is bundled with yii-user-management.


FAQ:
----
Q: I get an exception when running the Installer

A: Please make sure to log out from any session. Clear your cookies to make
sure you are not logged in in your Web Application anymore.

Q: I get the error Message: CWebUser does not have a method named "isAdmin":

A: Please make sure that you have the following in your application configuration:

```
	'components'=>array(
		'user'=>array(
			'class' => 'application.modules.user.components.YumWebUser',
```


Q: I get the error Message: the table "{{users}}" for active record class "YumUser" cannot be found in the database.

A: Please make sure that you have the following in your application configuration:

```
		'db'=>array(
			'tablePrefix' => '',
			[...]
```

Q: Why doesn´ t the yii-user-management have submodules?

A: Submodules are supported by yii, but having a path like 
application.modules.user.modules.role.controllers.YumRoleController
really looks strange, so we decided it is better to keep all modules inside
the root modules/ directory.

Q: I get the following error while installing:
General error: 2014 Cannot execute queries while other unbuffered queries are active

A: thanks to NetDabbler, there is a workaround:

Comment the folowing lines in YumInstallController.php
// $sql = file_get_contents(Yii::getPathOfAlias('application.modules.user.docs') . '/yum_translation.sql');
// $db->createCommand($sql)->execute();

Insert the translation data manually in a cmd window as:
mysql -u yourusername -p testyum < docs/yum_translation.sql


Q: I still got errors ! 

A: Make sure to enable a caching component, at least CDummyCache, in your config/main.php:

'cache'=>array( 'class'=>'system.caching.CDummyCache',	),  

Q: I still got errors !

A: Try to add this in your config/main.php:

```
'session' => array(
		'sessionName' => 'SiteSession',
		'class' => 'CHttpSession',
		'autoStart' => true,
		),
```

The documentation is stored in the user/docs directory.
Please read user/docs/install.txt for a installation instruction.

Please DO read the documentation since it is not 100% trivial to install
this module. There also is a FAQ of common mistakes at the end.

Report all issues to the github issue tracker, thank you!

Enjoy this module.
