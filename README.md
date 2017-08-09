# PHPCal
Script to Generate a Graphical Calendar(as an image) in PHP

Parameters:
----------
Required:
month (ex: 08)
year (ex: 2017)
Optional:
size (width in px)
days (comma seperated array of days to control day sequence, default: Sun,Mon,Tue,Wed,Thu,Fri,Sat)
activity_days (comma seperated list of numerical days that correspond to below)
activity_action (comma seperated list of actions or events that correspond to above)

Sample:
cal.php?month=8&year=2018&width=1000&activity_days=1,2,3&activity_action=eat,sleep,work&days=Mon,Tue,Wed,Thu,Fri,Sat,Sun

TODO: Create "REST" like interface.
