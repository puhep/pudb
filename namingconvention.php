<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <link rel="stylesheet" type="text/css" href="css/namingconvention.css" />
  <title>Naming Convention</title>
</head>
<body>

<h>2012 6-inch CMSFPIX SENSOR & Bump-Bonded MODULE & Assembled 2x8 MODULE Naming Convention
</h>
<br>
<br>

<img src="pics/RTI_Numbering_Scheme.png" width="250" height="250">
<img src="pics/SINTEF_numbering_diagram_2x8s_Updated.jpg" width="320" height="300">

<br>
<br>
The naming convention for sensors on-wafers and bump-bonded modules is "XX_YY_ZZZ" (a total of 9 characters) where:
<br>
<p style="text-indent: 5em;">
1. The 1st character is either a "<b>W</b>" or a "<b>B</b>", with "<b>W</b>" designating sensor on-wafer and "<b>B</b>" designating a bump-bonded module.
<br>
<p style="text-indent: 5em;">
2. The 2nd character is a "<b>L</b>" or a "<b>S</b>" or an "<b>A</b>" or a "<b>D</b>" depending on the sensor type, either a <b>2x8</b>, <b>1x1</b>, <b>slim-edge</b>, or a <b>diode</b>.
<br>
<p style="text-indent: 5em;">
3. The 3rd character is always an "_" (underscore).
<br>
<p style="text-indent: 5em;">
4. The next 2 characters are associated with the position of diodes or sensors on the wafers and can be the following:
<br>
<p style="text-indent: 10em;">
a. 2x8(<b>L</b>)
<br>
<p style="text-indent: 15em;">
i. TT(Top)
<br>
<p style="text-indent: 15em;">
ii. FL(Far Left),LL(Left),CL(Center Left),CR(Center Right),RR(Right), and FR(Far Right)
<br>
<p style="text-indent: 15em;">
iii. BB(Bottom)
<br>
<p style="text-indent: 10em;">
b. 1x1(<b>S</b>)
<br>
<p style="text-indent: 15em;">
i. TL(Top Left),TR(Top Right)
<br>
<p style="text-indent: 15em;">
ii. CL(Center Left),CR(Center Right)
<br>
<p style="text-indent: 15em;">
iii. BL(Bottom Left),BR(Bottom Right)
<br>
<p style="text-indent: 10em;">
c. Slim-Edge(<b>A</b>)
<br>
<p style="text-indent: 15em;">
i. TL(Top Left), TR(Top Right)
<br>
<p style="text-indent: 15em;">
ii. BL(Bottom Left), BR(Bottom Right)
<br>
<p style="text-indent: 10em;">
d. Diode(<b>D</b>)
<br>
<p style="text-indent: 15em;">
i. TL(Top Left), TR(Top Right)
<br>
<p style="text-indent: 15em;">
ii. BL(Bottom Left, BR(Bottom Right)
<br>
<p style="text-indent: 5em;">
5. The next character is an "_"(underscore).
<br>
<p style="text-indent: 5em;">
6. The next three characters are 3 digits associated with the Sensor Wafer number:
<br>
<p style="text-indent: 10em;">
a. Preproduction sensors use 9 in the first of the 3 digits, ex. <b>901</b>
<br>
<p style="text-indent: 10em;">
b. Production sensors are limited to numbers between <b>001</b> and <b>200</b>
<br>
<br>
Examples:
<br>
<b>BL_TT_035</b>: A 2x8 bump-bonded module, using the top 2x8 sensor from production wafer #035.
<br>
<b>WS_BR_045</b>: A bottom right 1x1 sensor in production wafer #045.
<br>
<b>BA_TR_901</b>: A 1x1 bump-bonded module, using top-right slim-edge sensor from preproduction wafer #901.
<br>
<br>
<br>
The naming convention for a fully assembled 2x8 module (including HDI) is "X_YY_ZZZ"(a total of 8 characters) where:
<br>
<p style="text-indent: 5em;">
1. The 1st character is always a "<b>M</b>".
<br>
<p style="text-indent: 5em;">
2. The 2nd character is always an "_"(underscore).
<br>
<p style="text-indent: 5em;">
3. The next 2 characters are associated with the original position of the 2x8 sensor on the wafer and can be the following:
<br>
<p style="text-indent: 10em;">
a. TT(Top)
<br>
<p style="text-indent: 10em;">
b. FL(Far Left),LL(Left),CL(Center Left),CR(Center Right),RR(Right), and FR(Far Right)
<br>
<p style="text-indent: 10em;">
c. BB(Bottom)
<br>
<p style="text-indent: 5em;">
4. The next character is an "_"(underscore).
<br>
<p style="text-indent: 5em;">
5. The next three characters are 3 digits associated with the Sensor Wafer number:
<br>
<p style="text-indent: 10em;">
a. Preproduction sensors use 9 in the first of the 3 digits, ex. <b>901</b>
<br>
<p style="text-indent: 10em;">
b. Production sensors are limited to numbers between <b>001</b> and <b>200</b>
<br>
<br>
Example:
<br>
<b>M_CR_035</b>: A fully-assembled module, using the center right 2x8 sensor from production wafer #035.
<br>
<b>M_LL_911</b>: A fully-assembled module, using the leftmost 2x8 sensor from preproduction wafer #911.
<br>
<br>



<form method="link" action="index.php">
<input type="submit" value="BACK">
</form>
</body>
</html>
