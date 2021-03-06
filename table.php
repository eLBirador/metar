<html>
<head>
  <title>PHP Weather</title>
</head>
<body>
<?php

include('./locale_en.inc');
include('./images.inc');
include('./phpweather.inc');

$metar = get_metar('EHEH');
?>

<h1>Iconize PHPWeather info</h1>

<h2>Introduction</h2>

<p>Over the globe, a lot of weatherstations report the local
weatherconditions to the <a
href="http://weather.noaa.gov/weather/metar.shtml">NOAA
organisation</a>, most of the times on an hourly basis. The
weatherconditions are reported in the METAR format. The METAR data is
available through the internet. For example the METAR data for
Eindhoven Airport, Netherlands is:</p>

<blockquote><code><? echo $metar ?></code></blockquote>

<p>Martin Geisler (<a
href="http://www.gimpster.com">www.gimpster.com</a>) has developed a
PHP-script that retrieves and parses METAR data into readable text.
You can get the PHPWeather script from <a
href="http://sourceforge.net/projects/phpweather/">PHP Weather</a>. By
this script, the METAR data of above is converted into:</p>

<blockquote><? pretty_print_metar($metar, 'Eindhoven'); ?></blockquote>

<p>I thought it would be neat to represent the METAR data in a
graphical way as well. This is not new. Various portals and newspaper
sites have this kind of representation also. But there is no way to
personalize that representation: the information is statically built
into their web-pages.<br> What I had in mind was a form that gives
freedom in the choice of the icons and what kind of information that
is presented: wind, temperature, sky cover and precipitation. Of
course the freedom of choice ends with the one that builds the
webpage: the PHP script is executed on the server which contains the
webpage. There is no way that a user of the page can personalize
representation (at least that is what I have in mind).</p>

<p>So here it is. The current weather conditions in icons (so
far):</p>

<blockquote>
<? $decoded_metar=process_metar($metar); ?>
<img src="<? get_temp_image($decoded_metar) ?>" height="50" width="20" border="1">&nbsp;
<img src="<? get_winddir_image($decoded_metar) ?>" height="40" width="40" border="1">
<img src="<? get_sky_image($decoded_metar) ?>" height="50" width="80" border="1">&nbsp;
</blockquote>

<h2>At first...</h2>

<p>I searched for a set of icons on the internet. There are dozens of
them. But only few are closely related to METAR data. I have
downloaded the set of icons that I thought came very close to the
METAR data. Then I have adjusted, changed and updated them to what I
think that they should be and to the PHP script that I had in
mind.</p>

<p>First, I started with the sky cover and precipitation group within
the METAR data. The set of icons I have downloaded already
distinguises between day and night time, so I decided to take that
into account too. METAR data has a group that describes the sky
covering in five steps. Alltough sky covering can be described with a
maximum of 3 layers, the script uses the layer that has the heaviest
sky cover. The reason for this is because that probably describes the
weather condition best (from the point of view of someone who looks up
to the sky).</p>

<p>Then there is a group that describes the 'Present Weather Group'.
To me, this is the precipitation and related phenomenas, at least most
of the time. To reduce the set of required icons I grouped similar
precipitation phenomenas. I limited the script to rain (RA/DZ), snow
(SN/SG), hail (GR/GS/PE/IC), thunderstorm (TS) and fog (BR/FG). Those
are the most common weather types in the Netherlands. The script can
be changed to contain more types (you'll need more icons though!)</p>

<p>The script takes both the sky cover figure and the precipitation
phenomenas as table entries at searches for the proper image file
name. Finally, the time of the metar data is taken into account:
during day time (from 6:00 AM to 6:00 PM) a sun with some clouds is
displayed. At night time (from 6:00 PM to 6:00 AM) a moon with some
clouds is displayed. Of course, when overcast is present, no sun or
moon is presented.</p>

<p>Refer to the next sections that present two tables with various
icons that are resolved when METAR data is processed. One table
provides the day time images, while the other provides the night time
images. <a href="http://www.devolder.nl/table.txt">Click here</a> to
view the code of the 'images.inc' file and <a
href="http://www.devolder.nl/images.txt">click here</a> to view the
code of this page.</p>

<h2>Things to improve</h2>
<ul>
  <li>
  </li>
</ul>

<h2>Day time sky cover/precipitation icons</h2>

<p>The script creates one icon for a sky over and precipitation
combination. Basically, the METAR data distinguishes 5 different sky
covering types, which are listed horizontally in the table below.
There are a lot of precipitation and related types, but in this script
the number is limited to the most common types (at least in the
Netherlands ;-): rain, snow, hail, thunderstorm and fog.</p>

<p>Remarks:</p>
<ul>
  <li>For rain, three different intensities are distinguished: light,
  moderate and heavy.</li>
  <li>For snow and hail, it is assumed that light/moderate and heavy
  intensities only need to be distinguished when there is overcast
  (100% sky cover).</li>
  <li>In case of fog/mist, I use the sky cover figure to increase the
  'thickness' of the fog and to blend out sun light. I'm not sure that
  the skycover is being used as an indication of the 'fogginess'.
  Anyone?</li>
</ul>  

</p>
<? set_time('day'); ?>

<table class="weather" border="1">
  <tr>
    <th class="weather" colspan="2" width=200>Sky Cover/<br>Precipitation</th>
	  <th class="weather" width=80>Clear<br>(CLR/SKC)</th>
	  <th class="weather" width=80>Few<br>(FEW)</th>
	  <th class="weather" width=80>Scattered<br>(SCT)</th>
	  <th class="weather" width=80>Broken<br>(BKN)</th>
	  <th class="weather" width=80>Overcast<br>(OVC/VV)</th>
	</tr>
	<tr>
	  <th class="weather" colspan=2>None</th>
	  <td><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" rowspan=3>Drizzle/Rain<br>(DZ/RA)</th>
	  <td>light</td>
	  <td rowspan=3><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>moderate</td>
	  <td><img src="<? $test['metar'] = 'RA FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'RA SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'RA BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'RA OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>heavy</td>
	  <td><img src="<? $test['metar'] = '+RA FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '+RA SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '+RA BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '+RA OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" rowspan=2>Snow/Snow Grains<br>(SN/SG)</th>
	  <td>light/<br>moderate</td>
	  <td rowspan=2><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
    <td rowspan=2><img src="<? $test['metar'] = 'SN FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'SN SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'SN BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'SN OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>heavy</td>
	  <td><img src="<? $test['metar'] = '+SN OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" rowspan=2>Ice Crystals/Ice Pellets/<br>Hail/Small Hail<br>(IC/PE/GR/GS)</th>
	  <td>light/<br>moderate</td>
	  <td rowspan=2><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'IC FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'IC SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'IC BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'IC OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>heavy</td>
	  <td><img src="<? $test['metar'] = '+IC OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" colspan=2>Thunderstorm<br>(TS)</th>
	  <td><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" colspan=2>Mist/Fog<br>(BR/FG)</th>
	  <td><img src="<? $test['metar'] = 'FG CLR000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
</table>

<p>Note: with the sky cover/precipitation icons, there is no such
thing as 'no data'. When both groups are omitted, this could mean
sunny and no precipitation, and 'no data' as well. Since the metar
exists, I decided to show the 'sunny' icon.</p>

<h2>Night time sky cover/precipitation icons</h2>

<p>To the night time sky cover/precipitation icons the same remarks as
to the day tim icons apply.</p>

<? set_time('nite'); ?>
<table border="1" class="weather">
        <tr>
    <th class="weather" colspan=2 width=200>Sky Cover/<br>Precipitation</th>
	  <th width=80>Clear<br>(CLR/SKC)</th>
	  <th width=80>Few<br>(FEW)</th>
	  <th width=80>Scattered<br>(SCT)</th>
	  <th width=80>Broken<br>(BKN)</th>
	  <th width=80>Overcast<br>(OVC/VV)</th>
	</tr>
	<tr>
	  <th class="weather" colspan=2>None</th>
	  <td><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" rowspan=3>Drizzle/Rain<br>(DZ/RA)</th>
	  <td>light</td>
	  <td rowspan=3><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '-RA OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>moderate</td>
	  <td><img src="<? $test['metar'] = 'RA FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'RA SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'RA BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'RA OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>heavy</td>
	  <td><img src="<? $test['metar'] = '+RA FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '+RA SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '+RA BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = '+RA OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" rowspan=2>Snow/Snow Grains<br>(SN/SG)</th>
	  <td>light/<br>moderate</td>
	  <td rowspan=2><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
    <td rowspan=2><img src="<? $test['metar'] = 'SN FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'SN SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'SN BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'SN OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>heavy</td>
	  <td><img src="<? $test['metar'] = '+SN OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" rowspan=2>Ice Crystals/Ice Pellets/<br>Hail/Small Hail<br>(IC/PE/GR/GS)</th>
	  <td>light/<br>moderate</td>
	  <td rowspan=2><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'IC FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'IC SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td rowspan=2><img src="<? $test['metar'] = 'IC BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'IC OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <td>heavy</td>
	  <td><img src="<? $test['metar'] = '+IC OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" colspan=2>Thunderstorm<br>(TS)</th>
	  <td><img src="<? $test['metar'] = 'CLR'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'TS OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
	<tr>
	  <th class="weather" colspan=2>Mist/Fog<br>(BR/FG)</th>
	  <td><img src="<? $test['metar'] = 'FG CLR000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG FEW000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG SCT000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG BKN000'; get_sky_image($test) ?>" height="50" width="80"></td>
	  <td><img src="<? $test['metar'] = 'FG OVC000'; get_sky_image($test) ?>" height="50" width="80"></td>
	</tr>
</table>

<p>Note: with the sky cover/precipitation icons, there is no such
thing as 'no data'. When both groups are omitted, this could mean
'moony' (as opposed to 'sunny' ;-) and no precipitation, and 'no data'
as well. Since the metar exists, I decided to show the 'moony'
icon.</p>

<? set_time(''); ?>
<h2>Wind direction</h2>

<p>A dedicated group in the METAR data provides wind related
information. Of this data, the wind direction can be visualized
graphically (as an arrow indicating the wind direction). I designed 16
wind direction icons (north, north-north-east, north-east etc), a
special icon for variable wind direction (speed 6 knots or less) and a
calm wind icon. The variable wind direction with speeds greater than 6
knots is not covered by an icon. The icon should then show the
'directional variability', which is pretty complex.</p>

<p>Each of the 16 wind direction is mapped onto a icon, e.g. angles
from 348.75 degrees through 11.25 degrees are mapped to the 'North'
icon. Angles from 11.25 through 33.75 degrees are mapped to
'North-east' etc. This leads to the following icons:</p>

<table class="weather" border="1">
  <tr>
    <th>N</th>
    <th>NNE</th>
    <th>NE</th>
    <th>NEE</th>
    <th>E</th>
    <th>SEE</th>
    <th>SE</th>
    <th>SSE</th>
  </tr>
  <tr>
    <td><img src="<? $test['wind_deg'] =   1.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] =  22.5; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] =  45.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] =  67.5; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] =  90.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 112.5; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 135.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 157.5; get_winddir_image($test) ?>" height="40" width="40"></td>
  </tr>
  <tr>
    <th>S</th>
    <th>SSW</th>
    <th>SW</th>
    <th>SSW</th>
    <th>W</th>
    <th>NWW</th>
    <th>NW</th>
    <th>NNW</th>
  </tr>
  <tr>
    <td><img src="<? $test['wind_deg'] = 180.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 202.5; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 225.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 247.5; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 270.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 292.5; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 315.0; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = 337.5; get_winddir_image($test) ?>" height="40" width="40"></td>
  </tr>
  <tr>
    <th>VRB</th>
    <th>Calm<br>wind</th>
    <th>No<br>data</th>
  </tr>
  <tr>
    <td><img src="<? $test['wind_deg'] = $strings['wind_vrb_long'];          get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? $test['wind_deg'] = '0.0'; $test['wind_knots'] = '0.0'; get_winddir_image($test) ?>" height="40" width="40"></td>
    <td><img src="<? get_winddir_image('') ?>" height="40" width="40"></td>
  </tr>
</table>

<h2>Temperature</h2>

<p>Another group in the METAR data provides temperature data. Only the
actual temperature is being used to show either a blue (below 0
degrees C) or a red (above 0 degrees C) thermometer is shown. I know
it is possible to generate images during php script execution with the
GD lib, but I think changes in thermometer would be very small and
hard to see.</p>

<table class="weather" border="1">
  <tr>
    <th>Below<br>0<br>deg C</th>
    <th>Above<br>0<br>deg C</th>
    <th>No<br>data</th>
  </tr>
  <tr>
    <td><img src="<? $test['temp_c'] =  -1; get_temp_image($test) ?>" height="50" width="20"></td>
    <td><img src="<? $test['temp_c'] =   1; get_temp_image($test) ?>" height="50" width="20"></td>
    <td><img src="<? get_temp_image('') ?>" height="50" width="20"></td>
  </tr>
</table>

<h2>Change history</h2>

<ul>
  <li>17 feb: EHEH 180825Z 22008KT 2500 R22/2000N -RA BR FEW008 BKN010 04/03 Q1017 YLO YLO BECMG GRN<br>
  Specifies Light rain, and mist. The icon shown is sun/mist. There is only clouds and rain, and no sun. Maybe the fog phenomena should only be taken into account when CLR or FEW. All others (SCT/BKN/OVC) ignore fog?
  <blockquote>Changed the mist icons to show clouds as well.</blockquote>
  </li>
  <li>19 feb: EHEH 191145Z 29016G30KT 4000 -SHRA BKN020CB 05/04 Q1015 TEMPO 4000 -TSRAGS<br>
  Specifies light showering rain, but also light thunderstorm of rain and small hail. Results in no image at all. Apparently, the script cannnot resolve this.<br>
  <blockquote>The metar contains a forcast part (from 'TEMPO...' and further). The script did not detect that and ran into the -TSRAGS part.
              Now the script stops before RMK|TEMPO|BECMG. </blockquote>
  </li>
  <li>25 feb: .... BR OVC020....<br>
  Specifies mist with overcast. Leads to 'fully white' image. This should be changed to normal overcast image
  <blockquote>Changed the mist icons to show clouds as well.</blockquote>
  </li>
</ul>

</body>
</html>
