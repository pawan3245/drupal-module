<?php
 
/**
* Autoload files of https://github.com/google/google-api-php-client
*
*/
require_once 'google-api-php-client/src/Google/autoload.php';
 
 
/**
* If you install https://github.com/asimlqt/php-google-spreadsheet-client through composer
* Then you can just do:
* require 'vendor/autoload.php';
*
* If you just download the zip file of https://github.com/asimlqt/php-google-spreadsheet-client
* Then, you need to load the following files:
*
*/
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/ServiceRequestInterface.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/DefaultServiceRequest.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/Exception.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/UnauthorizedException.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/ServiceRequestFactory.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/SpreadsheetService.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/SpreadsheetFeed.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/Spreadsheet.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/WorksheetFeed.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/Worksheet.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/ListFeed.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/ListEntry.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/CellFeed.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/CellEntry.php';
require_once 'php-google-spreadsheet-client/src/Google/Spreadsheet/Util.php';
 
 
/**
* AUTHENTICATE
*
*/
// These settings are found on google developer console
const CLIENT_APP_NAME = 'addtogooglesheet';
const CLIENT_ID       = 'c58d9c9486a01cbfd63c0fa4fd3a54b69892235a.apps.googleusercontent.com';
const CLIENT_EMAIL    = 'maninder@signitysolutions.com';
const CLIENT_KEY_PATH = 'My Project-c58d9c9486a0.p12'; // PATH_TO_KEY = where you keep your key file
const CLIENT_KEY_PW   = 'notasecret';
 
 echo "pawan";die;
 
$objClientAuth  = new Google_Client ();
$objClientAuth -> setApplicationName (CLIENT_APP_NAME);
$objClientAuth -> setClientId (CLIENT_ID);
$objClientAuth -> setAssertionCredentials (new Google_Auth_AssertionCredentials (
    CLIENT_EMAIL,
    array('https://spreadsheets.google.com/feeds','https://docs.google.com/feeds'),
    file_get_contents (CLIENT_KEY_PATH),
    CLIENT_KEY_PW
));
$objClientAuth->getAuth()->refreshTokenWithAssertion();
$objToken  = json_decode($objClientAuth->getAccessToken());
$accessToken = $objToken->access_token;
 
 
/**
* Initialize the service request factory
*/
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
 
$serviceRequest = new DefaultServiceRequest($accessToken);
ServiceRequestFactory::setInstance($serviceRequest);
 
 
/**
* Get spreadsheet by title
*/
$spreadsheetTitle = 'ApiTest';
$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
$spreadsheetFeed = $spreadsheetService->getSpreadsheets();
$spreadsheet = $spreadsheetFeed->getByTitle($spreadsheetTitle);
echo '<pre>';
print_r($spreadsheet );die;
 
 
/**
* Add new worksheet to the spreadsheet
*/
$worksheetTitle = 'New Worksheet';
$spreadsheet->addWorksheet($worksheetTitle, 50, 20); // 50 rows & 20 columns
 
 
/**
* Get particular worksheet of the selected spreadsheet
*/
$worksheetTitle = 'YOUR-WORKSHEET-TITLE'; // it's generally named 'Sheet1'
$worksheetFeed = $spreadsheet->getWorksheets();
$worksheet = $worksheetFeed->getByTitle($worksheetTitle);
 
 
/**
* Delete a particular worksheet from the spreadsheet
* I have commented out the worksheet delete code
* but it works well
*/
//$worksheetTitle = 'YOUR-WORKSHEET-TITLE';
//$worksheet = $worksheetFeed->getByTitle($worksheetTitle);
//$worksheet->delete();
 
 
/**
* Add/update headers of worksheet
*/
$cellFeed = $worksheet->getCellFeed();
$cellFeed->editCell(1,3, "name"); // 1st row, 3rd column
$cellFeed->editCell(1,4, "age"); // 1st row, 4th column
 
 
/**
* Insert row entries
* Supposing, that there are two headers 'name' and 'age'
*/
$row = array('name'=>'John', 'age'=>25);
$listFeed->insert($row);
 
 
/**
* Get row lists of worksheet
*/
$listFeed = $worksheet->getListFeed();
 
 
/**
* Print row lists
*/
foreach ($listFeed->getEntries() as $entries) {
    print_r($entries->getValues());
}
 
 
/**
* Update row entries
* Supposing, that there are two headers 'name' and 'age'
*/
$entries = $listFeed->getEntries();
$listEntry = $entries[0]; // 0 = 1st row (editing value of first row)
$values = $listEntry->getValues();
$values['name'] = 'Bob';
$values['age'] = '45';
$listEntry->update($values);
 
?>
