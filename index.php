<?php 
echo '<p>Hello world!</p>';
echo '<p>This is a new line update check its updated!</p>';
echo '<table width=100 height=100 border=tick><td><th></th></td></table>';

$mysqli = new mysqli(getenv('RDS_HOSTNAME'), getenv('RDS_USERNAME'), getenv('RDS_PASSWORD'), getenv('RDS_DATABASE'));
if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
echo $mysqli->host_info . "\n";

?>
