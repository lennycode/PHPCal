# PHPCal
Script to Generate a Graphical Calendar(as an image) in PHP <br/>
Parameters:

----------

<b>Required:</b> <br/>
month (ex: 08) <br/>
year (ex: 2017) <br/>

<b>Optional:</b> <br/>
size (width in px) <br/>
days (comma seperated array of days to control day sequence, default: Sun,Mon,Tue,Wed,Thu,Fri,Sat) <br/>
activity_days (comma seperated list of numerical days that correspond to below) <br/>
activity_action (comma seperated list of actions or events that correspond to above) <br/>


Sample: <br/>

`cal.php?month=8&year=2018&width=1000&activity_days=1,2,3&activity_action=eat,sleep,work&days=Mon,Tue,Wed,Thu,Fri,Sat,Sun` <br/>

TODO: Create "REST" like interface. <br/>
