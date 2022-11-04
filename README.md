# 3ProTroodosV1
Open source IoT platform for 3pro Troodos project.


The Troodos Mountains are the green heart of Cyprus. The mountains capture and manage the rains that form our natural water resources. Agricultural dry-stone terraces, rural communities and forests shape the diverse landscape of Troodos. The agricultural and food processing sectors in the Troodos Mountains have high potentials but also face many challenges.

The 3PRO-TROODOS Project is an Integrated Research Project (2019-2022), funded by the Research and Innovation Foundation of Cyprus, and coordinated by The Cyprus Institute. The project aims to improve agricultural production and food processing in the Troodos Mountains of Cyprus, through social innovation, sustainable natural resource management and climate change adaptation.

The 3PRO-TROODOS Consortium conducts research, in cooperation with the agri-food producers and processors of the Troodos Mountains, to achieve:

A quality certification label for Troodos food products
Improved fruit tree production with protective nets
New products and practices for local herbs
Maintenance and rehabilitation of agricultural dry-stone terraces
Improved irrigation water use with wireless sensors and mobile Apps
Guidelines for sustainable water use under current and future climate conditions
Insights in the socioeconomic impact of quality labelling on Troodos
To perform the necessary research a number of wireless sensors had to be used to take various measurements of the state of the soil as well as the environmental conditions in an area. To keep all these data easily accessible, a sensor observation IoT platform had to be developed.

# Warning

This project is not obsolete and not supported in any way or form. 
An updated version of the project can be found on the following [link](https://github.com/sigintsolutions/3ProTroodosV2)


# Instructions for use. 

Argus Login page 

By using User name and password you can Enter the Dashboard page.

 ![](Documentation/images/2022-11-04-16-59-40.png)

 2.	Once you Login in the dashboard, the page will be look like below image.
3.	In the dashboard page you can see the total number of Agent, Gateway Group, Hubs and Sensors you created.
4.	In the Agent Log, you can monitor Agent login and Logout time status.
5.	In the Console table you can trace all sensor reading.

![](Documentation/images/2022-11-04-17-00-00.png)

6.	Agents: In the top menu click on the Agent button. See the below screen shot,

![](Documentation/images/image.png.png)

7.	Add agents by press the plus button at bottom right corner  . On click the plus button a popup form you can enter agent details then click on save. Once you save the details, the agent will appear in the screen.
a.	If you need to import bulk of agent then import the bulk agent as excel file. In the top header there is a button Agent Import sheet by click that button you can download a excel template then you can import by click the right corner button .
b.	From here we can import Gateway group for single Agent and multiply agent you can select the check box at top profile card. Dowload Gateway group import sheet from top header. Then import the Gateway group excel by click bottom right    button.
c.	You view the Agent profile by click on the profile Icon in the agent card .
d.	If you need to check the Agent dashboard just click on the dashboard icon .

e.	Need to edit any agent you can click the edit icon  .You can set agent active and Inactive. The active agent in card it will show green   and  Inactive it will show as red  .
f.	If you need to edit bulk agent at same time the you can easly select the agent by click at the check box then click at export button at bottom right   . After edit the excel you can import the agent.
     
g.	For delete agent click delete icon  . If you need to delet more agent you can select agent by click checkbox in the bottom right click delete button   .
h.	In the profile card the is a option to look all the assigned Gateway group, Hubs and Sensor in tree structure. There is a button name as Visual Hierarchy    by click it you can get a screen like below

![](Documentation/images/2022-11-04-17-02-35.png)

a.	You can Add , Edit and you can also delete Gateway group, Hubs and sensor from here.

8.	Click on the Group Icon    in agent profile card you can go to Gateway group page look like

![](Documentation/images/2022-11-04-17-02-55.png)

a.	Add Gateway Group by press the plus button at bottom right corner  . On click the plus button a popup form you can enter Group details then click on save. The saved Group will appear in the screen.
b.	In the Gateway group popup screen you can add Gateway group Name by click the plus button near Gateway group name dropdown. So no need to go on setting page for create a name. It will save your time. 

![](Documentation/images/2022-11-04-17-03-12.png)

c.	If you need to import bulk of Gateway Group then go to the top header there is a button Gateway group Import sheet by click that button you can download a excel template then you can import by click the right corner button    .
d.	From here we can import Hubs for single Gateway Group or multiply Gateway Group. For this you can use the same methods as agent page.
e.	You can View and edit the Gatway Group by click  .
f.	For edit click edit icon  .
g.	For delete Gateway Group click delete icon   . If you need to delet more group - use the same methods as agent.

h.	Visual Hierarchy   same as agent but here we show tree from Gateway group.

9.	Click Hubs Icon   from the Gateway group card. You can enter Hub create the Page looks like

![](Documentation/images/2022-11-04-17-03-33.png)

a.	Add Hubs by press the plus button at bottom right corner  . Same as gateway group methods
b.	If you need to import bulk of Hubs – same as gateway group methods 
c.	You can View and edit the Hubs by click  .
d.	For edit click edit icon  .
e.	For delete Gateway Group click delete icon  . If you need to delet more group use the same methods as gateway group.
f.	Visual Hierarchy   same as agent but here we show tree from Hubs.
10.	Click sensor  Icon   from the Hubs card. You can enter Sensor create the Page looks like

![](Documentation/images/2022-11-04-17-03-48.png)

a.	Add Sensor by press the plus button at bottom right corner  . Same as Hubs methods
b.	If you need to import bulk of Sensor – same as Hubs methods 
c.	You can View and edit the Sensor by click  .
d.	For edit click edit icon  .
e.	For delete Sensor click delete icon  . If you need to delet more group use the same methods as Hubs.

11.	In the menu click on the weather link 

![](Documentation/images/2022-11-04-17-04-10.png)

a.	In this page we can assign weather for different agent. The assigned weather will appear on the agent dashboard. Select agent and select the place you need as weather then click on save.
b.	The add location button used for add some new location as your need. The screen look like

![](Documentation/images/2022-11-04-17-04-27.png)


i.   Enter location name, Generate code form the link given. Copy and past the code you generated and save the template. The location will added in list.

12.	By Sensor Report menu you can go to the page
a.	Sensor Time Report – Here we select one agent, Multiply Gateway group, Multiply Sensor Hubs, one Unit and only three sensors and the time stamp as your choice.    
b.	You can see the result as table format and Graphical format. In the graphical report you can choose different chart based on your wish. 

c.	You can export data in excel format by click on export button. 

![](Documentation/images/2022-11-04-17-05-03.png)

d.	Hub Sensor Report – Here all items need to select as single. you can see the result as table and graphical report.
e.	You can export data in excel format by click on export button.           

![](Documentation/images/2022-11-04-17-05-23.png)

f.	Push notification – All the assigned algoritham push notification need will show in the table. 

![](Documentation/images/2022-11-04-17-05-38.png)

13.	By click Algorithm Editor – go on add algorithm

![](Documentation/images/2022-11-04-17-05-56.png)

a.	Here we can add only three condition.
b.	Select agent, Type algorithm name , Select Gateway group name, Select Hub Name, Select sensor Id and now choose condition
a.	First Method – In drop down we have different formula such as <, >, <= , >= , ==  we can select any formula then enter value and then select None, OR, And.
i.	If we select None then we can’t able to add more condition.
ii.	If we select OR , AND we can choose more condition.
b.	Second Method – Min and Max value 

14.	Setting page

![](Documentation/images/2022-11-04-17-06-20.png)

a.	Here we Add Gateway group name, Sensor type and Sensor chart.

b.	By click the plus button   the form will appear in screen you can enter the detail and save.
c.	For bulk import first you need to down load the excel template by click download icon  .Then you can import the excel through import button  .

15.	System setting by click  
a.	Email – You can set email template for agent and admin.

![](Documentation/images/2022-11-04-17-06-49.png)

b.	Admin – by click add new admin you can create admin.

![](Documentation/images/2022-11-04-17-07-03.png)

c. If you need to go back to the dashboard just click on the Home button It will take you dashboard. 

# Project Developer Guidelines.  

## OVERVIEW
1.	Project Background and Description
 	Hardware & Tools Used
    1. Operating system	Ubuntu Linux 16.04.6
    2. Apache version 2.4.43
    3. PHP version 7.2 (Laravel 6)
    4. MySQL version 5.7.30-0 ubuntu0.16.04.1
    5. Mosquito
    6. Python 3.5

2.	Project Scope

 	Mosquito data inserting to the Mysql dbo_payloader table through Python Script. There are several Cron jobs running in specified intervals to process the data as per the project requirement.

3.	Database Structure and Tables.

 	Following are the tables used.

    •	`algorithm` - To store algorithm of various agents.

    •	`algorithm_sensor` - To store sensor, hub, conditions of various algorithm of various agents.

    •	`chart` -  To store the unit and type of chart varies on the basis of unit in application.

    •	`dbo_payloader`-  Mosquito data storing in this table. 

    •	 `dbo_payloaderalgorithmtemp298`
       - 298 is the agentid or userid,runtime table created for each agent for storing data from dbo_payloader for sending push notifications using 1 condition algorithm(none).This table created at the time of adding agents and deleted while removing an agent. 

    •	`dbo_payloaderalgorithmtempandor298`
    - 298 is the agentid or userid,runtime table created for each agent for storing data from dbo_payloader for sending push notifications using more than 1 condition algorithm(and,or,and-and,or-or,and-or,or-and etc).This table created at the time of adding agents and deleted while removing an agent.

    •	`dbo_payloadercharttemp`
    - To store sensor chart details temporarily by logged user for generating charts.

    •	`gateway_groups`
    - To store gateway groups

    •	`loc`
    - To store location template

    •	`log_details` 
    - To track login and logout of various users

    •	`roles`
    - To store type of users(1-Admin,2-Agent-Only 2 users)

    •	`role_user` 
    – To mapping users with their roles

    •	`sensors`
    - To store the sensors of various agents

    •	`sensor_groups`
    - Master for various sensor groups.

    •	`sensor_hubs`
    - To store hubs of various agents

    •	`settings`
    - Template for sending emails

    •	`types`
    - To store sensor types

    •	`userdatamessagesagent`
    - To store messages of various agents (pushnotification messages)

    •	`users`
    - to store user details(Admin,Agent)

    •	`weather`
    - Mapping agent with location

    •	`sensordata`(master table)
    - For populating in sensor dropdowns while assigning new  sensors to agents.

    •	`hubdata`(master table)
    - for populating in hub dropdowns while assigning new  hubs to agents.
        


4.	Source Code Details
 	Framework used is `laravel6` with `model–view–controller` architectural pattern (MVC). 
    We have two Modules - I. Admin and II. Agent.

Admin -Path(argus/app/Http/Controllers/Admin)
               
Following are the controllers and files in Admin module

•	`AdminsController` - Managing Users and sending mails

•	`AlgorithmController` 
- Algorithm handling and Hub Sensor Report(Table,Chart) of Admin

•	`Agents Controller`
- For Handling Agents
  
•	`Emails Controller`
  - Sending Mail
   
•	`GatewayGroup Controller`

- For Handling Gateway Groups
  
•	`Home Controller`

- Code for admin dashboard,weather details,agent-login,logout time etc
  
•	`Report Controller`

- Code for Sensor Time Table,Chart,Push Notification etc
  
•	`Sensor Controller`

- Code for handling sensors of various agents
  
•	`Sensor hub Controller`

- Code for handling sensor hubs of various agents
  
•	`Settings Controller`

- Code for settings module(Unit,chart for various units,sensor type etc)
  
•	`Web.php`
- used for routing `Path(argus/routes/web.php)`

•	`Blade files` Path(argus/resources/views/admin)

•	`.env` 
database settings (inside argus folder).

•	`Exporting Excel`-Laravel Excel Export used(argus/app/Exports)

---

Agent -Path(argus/app/Http/Controllers/Agent)

Agent Module following are the controllers and files used.

•	`AlgorithmController`

- Algorithm handling and Hub Sensor Report(Table,Chart) of Agents

•	`Agents Controller`

- For Handling Agents

•	`GatewayController`

- For Handling Gateway Groups(agent)

•	`GatewaygroupController`

- For Handling Gateway Groups(agent)

•	`Home Controller`
    
- Code for agent dashboard

•	`Profile Controller`
    
- Profile for agent

•	`Report Controller`
    
- Sensor Time Report(Table,Chart),Push Notification

•	`SensorhubController`
    
- Sensor Hubs of Agent

•	`Settings Controller`
    
- Code for settings module(Unit,chart for various units,sensor type etc)

•	`UserController`
    
- For Managing Users

•	`Blade files`
           Path(argus/resources/views/agent)

•	`Exporting Excel`
    
  - Laravel Excel Export used(argus/app/Exports)
  



Points to note.

- **Admin and Agent Sensor Time Report**:  we are using temporary table to store the data for the searched criteria (User) for displaying sensor chart report.

- **Function** used is s`avecharttempdata` in `ReportController`.
Table used is `dbo_payloadercharttemp` with loginid(agent or admin logged into the application)

- **Login Customization done inside below path** : *argus/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticateUsers.php*

- **Algorithm-Single condition logic**:
  
We are using Cron job for push messages in the userdatamessagesagent table for various agents.
We used two cron jobs, one for single condition and the second for more than 1 condition. For push notification, we are taking data from `dbo_payloader` and stored it in each agent temporary table(eg: `dbo_payloaderalgorithmtemp298`).`298-agentid.`
From this table `dbo_payloaderalgorithmtemp298-program` will take data for processing.
Cron job, for fetching data from dbo_payloader to `dbo_payloaderalgorithmtemp298` is `pushsingleagent.php` and single condition algorithm program is `pushnotagent.php`
both of these files are in argus root folder.
`Pushnotagent.php`(code details)


  - Get sensors of agent from algorithm with single condition-more condition  flag—0
  - Get data from table where processedflag is 0. (dbo_payloaderalgorithmtemp298)
  
  -	Compare its value with algorithm sensor value
  
  -	If it meets condition data or message inserted into userdatamessagesagent table.
  
  -	Once record is processed data deleted from this dbo_payloaderalgorithmtemp298 table
  
  -	Records which are not these agent it will be deleted.
  
  -	Cron job triggered for every 1 minute.

  - Algorithm-More than 1 condition logic
  
We are using Cron job for pushing messages in the `userdatamessagesagent` table of various agents.

We used two Cron job one for single condition and the second one for more than one condition. For push notification, we are taking data from dbo_payloader and stored it in each agent temporary table (eg: `dbo_payloaderalgorithmtempandor298`).298-agentid.
From this table dbo_payloaderalgorithmtempandor298-program will take data for processing.
Cron job, for fetching data from dbo_payloader to `dbo_payloaderalgorithmtempandor298` is pushallagent.php and more than 1 condition algorithm program is pushnotmsgagent.php
Both of these files are in argus root folder.
Pushnotmsgagent.php(code details)

- Get sensors of agent from algorithm with more condition flag—1

- Get data from table where `processedflagall` is `0`. (`dbo_payloaderalgorithmtempandor298`).

- Compare its value with algorithm sensor value

- If it meets condition, data or message inserted into userdatamessagesagent` table.

- Once the record processed then the data deleted from this `dbo_payloaderalgorithmtempandor298` table.

- Also records which are not these agent also deleted.

- Cron job triggered for every 1 minute.
	

6.	Cron Jobs Used in Argus.
 	- Push Notification Single- 
 - pushsingleagent.php
 - pushnotagent.php
 - Push Notification More than 1 Condition
 - pushallagent.php
 - pushnotmsgagent.php
- To reset the logout status of users:
-	If users are idle or closed the application without clicking logout then Cron job  reset loginstatus to 0 -sesexpnew.php.
-	sensor.php - to fetch new sensors from dbo_payloader and storing in sensordata (master table)-for populating in sensor dropdowns.
-	hub.php- to fetch new hubs from dbo_payloader and storing in hubdata(master table)-for populating in hub dropdowns
	

7.	Python File
 	•	Python is using for Mosquito data to insert data into dbo_payloader table.
Python File- mqtt-db.py


8.	To Run Source Code
 	 Source code has itself developer guide lines.
Configuration Instruction:
1. Install Operating system	Ubuntu Linux 16.04.6
2. Install Apache version 2.4.43
    See the document : Install_Apache.txt
3. Install PHP version 7.2
    See the document : Install_PHP7.2.txt
4. Install MySQL version 5.7.30-0 ubuntu0.16.04.6
    See the document : Install_MySQL5.7
5. Install Mosquito
    See the document : Install_Mosquitto.txt
6. Install Python 3.5
    See the document : Install_Python_3.5.txt
7. Create mySql database ‘mqttdata’ and then import the database mqttdata.sql 
8. Copy and Paste the source file in your destination. Add your new db user name and password, and URL in the .env file.
If application not working, then run the following command from your application root path
a. php artisan cache: clear; 
b. php artisan config:clear;
If application is still not working then update vendor file, the command you have to use “composer update”.

*If updating or installing vendor files—keep a backup of argus/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticateUsers.php and replace it with new AuthenticateUsers.php


























































