<?php if (!defined('APPLICATION')) exit();

// Conversations
$Configuration['Conversations']['Version'] = '2.0.18rc2';

// Database
$Configuration['Database']['Name'] = 'geekrpg';
$Configuration['Database']['Host'] = 'localhost';
$Configuration['Database']['User'] = 'cdavid';
$Configuration['Database']['Password'] = 'dewqas';

// EnabledApplications
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['WattsApp'] = 'wattsapp';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledPlugins
$Configuration['EnabledPlugins']['GettingStarted'] = 'GettingStarted';
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['Facebook'] = TRUE;
$Configuration['EnabledPlugins']['OpenID'] = TRUE;
$Configuration['EnabledPlugins']['GoogleSignIn'] = TRUE;
$Configuration['EnabledPlugins']['Twitter'] = TRUE;
$Configuration['EnabledPlugins']['cleditor'] = TRUE;

// Garden
$Configuration['Garden']['Title'] = 'wattsapp';
$Configuration['Garden']['Cookie']['Salt'] = 'CB7743T27S';
$Configuration['Garden']['Cookie']['Domain'] = '';
$Configuration['Garden']['Registration']['ConfirmEmail'] = FALSE;
$Configuration['Garden']['Registration']['Method'] = 'Connect';
$Configuration['Garden']['Registration']['CaptchaPrivateKey'] = '';
$Configuration['Garden']['Registration']['CaptchaPublicKey'] = '';
$Configuration['Garden']['Registration']['InviteExpiration'] = '-1 week';
$Configuration['Garden']['Registration']['ConfirmEmailRole'] = '8';
$Configuration['Garden']['Registration']['InviteRoles'] = 'a:5:{i:3;s:1:"0";i:4;s:1:"0";i:8;s:1:"0";i:32;s:1:"0";i:16;s:1:"0";}';
$Configuration['Garden']['Email']['SupportName'] = 'wattsapp';
$Configuration['Garden']['Version'] = '2.0.18rc2';
$Configuration['Garden']['RewriteUrls'] = TRUE;
$Configuration['Garden']['CanProcessImages'] = TRUE;
$Configuration['Garden']['Installed'] = TRUE;
$Configuration['Garden']['Messages']['Cache'] = 'a:0:{}';
$Configuration['Garden']['InstallationID'] = '97C3-FF6ACB33-9E7092E3';
$Configuration['Garden']['InstallationSecret'] = '32722970c4add7f35385fdf49414199e989fe7da';
$Configuration['Garden']['Theme'] = 'default';

// Modules
$Configuration['Modules']['Vanilla']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';
$Configuration['Modules']['Conversations']['Content'] = 'a:6:{i:0;s:13:"MessageModule";i:1;s:7:"Notices";i:2;s:21:"NewConversationModule";i:3;s:19:"NewDiscussionModule";i:4;s:7:"Content";i:5;s:3:"Ads";}';

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['GettingStarted']['Registration'] = '1';
$Configuration['Plugins']['Facebook']['ApplicationID'] = '110881549020771';
$Configuration['Plugins']['Facebook']['Secret'] = 'aedf92b11f57a4a2c1e91aec4693e53f';

// Routes
$Configuration['Routes']['DefaultController'] = 'discussions';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.0.18rc2';

// Last edited by cdavid (::1)2011-10-20 09:43:40