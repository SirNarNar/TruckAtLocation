<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
// add the timezone
date_default_timezone_set('America/Toronto');
// import the data from the form on index.php
$sDate = new DateTime($_GET['date']);
$eDate = clone($sDate);
$eDate->add(new DateInterval("P1D"));
$sTime = new DateTime($_GET['start']);
$eTime = new DateTime($_GET['end']);
// use switch to set the location variables
switch ($_GET['loc']) 
{
    case "tide":
        $latitude = "43.71257";
        $longitude = "-79.58380";
        $locName = "Tidemore";
        break;
    case "mcph":
        $latitude = "43.82232";
        $longitude = "-79.05951";
        $locName = "McPherson";
        break;
    case "emer":
        $latitude = "43.69702";
        $longitude = "-79.68171";
        $locName = "Emerald Power";
        break;
    case "other":
        $latitude = $_GET['lat'];
        $longitude = $_GET['lon'];
        $locName = "Latitude: " . $latitude . " & Longitude: " . $longitude;
        break;
    default:
        $latitude = "43.71257";
        $longitude = "-79.58380";
        $locName = "ERROR";
        break;
}
// echo the search criteria that the user entered
echo "<fieldset>";
echo "<legend><h2>Search Criteria:<br>\n</h2></legend>";
echo 'Date entered: ' . $sDate->format('Y-m-d') . '<br>';
//echo 'End Date:' . $eDate->format('Y-m-d') . '<br>';
echo 'Start Time entered: ' . $sTime->format('H:i:s') . '<br>';
echo 'End Time entered: ' . $eTime->format('H:i:s') . '<br>';
echo "Location entered: " . $locName . "</fieldset>";
echo "<h1 style=\"margin-right: 75%\">Results:</h1>";


#region truck class
class Truck
{
    #region variables
    private $truckName;
    private $lon;
    private $lat;
    private $time;
    #endregion

    function __construct ($truckName, $lon, $lat, $time)
    {
        $this->setTruckName($truckName);
        $this->setLon($lon);
        $this->setLat($lat);
        $this->setTime($time);
    }

    #region setters & getters
    public function setTruckName ($truckName)
        {$this->truckName = $truckName;}
    public function getTruckName ()
        {return $this->truckName;}

    public function setLon ($lon)
        {$this->lon = $lon;}
    public function getLon ()
        {return $this->lon;}
    
    public function setLat ($lat)
        {$this->lat = $lat;}
    public function getLat ()
        {return $this->lat;}

    public function setTime ($time)
        {$this->time = $time;}
    public function getTime ()
        {return $this->time;}
    #endregion

}
#endregion

#region Pulling truck data from API
$startDate = $sDate->format('Y-m-d') . 'T00:00:00';
$endDate = $eDate->format('Y-m-d') . 'T00:00:00';
$truckArray = array();
$endDate .= '.343Z';
$startDate .= '.343Z';
error_reporting(1);
$searchCriteria = "{ \n 
    \"startDate\":\"" . $startDate . "\", \n 
    \"endDate\":\"" . $endDate . "\", \n 
    \"lon\":\"" . $longitude . "\", \n
    \"lat\":\"" .$latitude. "\",\n
    \"radius\":\"100\"}";
$division = '******';
$apiKey = '******';
$url = '******';
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = 'Accept: application/json';
$headers[] = 'X-Apikey: ' . $apiKey;

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $searchCriteria);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$jsonExec = curl_exec($ch);
if(curl_errno($ch))
{
	echo 'Error:' . curl_error($ch);
}

curl_close($ch);

$json = json_decode($jsonExec, true);
$length = count($json['Data'], 0);
// echo $length . " locations for trucks pulled!<br>\n";
#endregion

#region make truck object for each truck
if ($length > 0)
    {
        for ($i = 0; $i < $length; $i++)
            {
                $truckName = $json['Data'][$i]['vehicleName'];
                $lon = $json['Data'][$i]['lon'];
                $lat = $json['Data'][$i]['lat'];
                $time = $json['Data'][$i]['timeStamp'];
                array_push($truckArray, new Truck($truckName, $lon, $lat, $time));
            }
    }

    $count=0;
#endregion

#region generate a message with the name of each truck near the yard
$newArray = array();

// echo the search results
echo "<table>";
echo "<tr>
        <th>Truck</th>
        <th>Time</th>
      </tr>";
foreach($truckArray as $truck)
    {
        foreach($newArray as $in)
        {
            if ($in->getTruckName() == $truck->getTruckName())
            {
               continue 2;
            }
        }

        if (substr($truck->getTime(), 11, 8) >= $sTime->format('H:i:s') && substr($truck->getTime(), 11, 8) <= $eTime->format('H:i:s'))
        {
            $newArray[$count]=$truck;
            $count++;
            // echo $count . " " .$truck->getTruckName() . " ". $truck->getLat() . "," . $truck->getLon() . " Time: " . $truck->getTime() . "<br>\n";
            echo "<tr>
                    <td>" . substr($truck->getTruckName(), 3) . "</td>
                    <td>" . substr($truck->getTime(), 11) . "</td>
                </tr>";
        }
            
    }
    echo "</table>";

    echo "<br><hr>Code is located at C:\Users\Staff\Downloads\Xampp\htdocs\scripts\WorkingCode\ on ******";
#endregion
?>
</body>