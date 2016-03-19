# gtfs-query

System to import Googles GTFS data into a database and allowing querying via a website. Uses Steffen Martinsen php-gtfs-mysql tool to import into a database. This system can only search single legs at a time and does not join routes. For example if you need to get to point B and you need to take a bus to point C to get to point B this system will not work. I have made this project open source so that hopefully someone might want to make a more elaborate system.<br>
<br>
At demo site is at http://skinhat.com/gtfs-query
<br>

Instructions<br>
1. Put source onto web server<br>
2. Create a database to put the GTFS data into eg travelangency-gtfs<br>
3. Put your GTFS data into gtfs-query/php-gtfs-mysql/gtfs (by default it is Googles test data)<br>
4. Go to http://localhost/gtfs-query/php-gtfs-mysql and enter the database name and its username and password and click yes to create and import the tables<br>
5. Got to http://localhost/gtfs-query/ to do a query. To see some results try departure 'Nye County' and arrival 'Bullfrog' at time '07:00'<br>