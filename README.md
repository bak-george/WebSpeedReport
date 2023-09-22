<h1>WebSpeedReport</h1>
<p>WebSpeedReport it's an <b>open source tool</b> that provides more in depth information about your internet connection.</p>
<ul><b>Features:</b>
    <li>It utilises SpeedTest from Ookla.</li>
    <li>Has a command that handles the database along with the created data.</li>
    <li>Gives you an overall view of your data in a dashboard.</li>
    <li>Provides an in-depth view from your internet test runs.</li>
</ul>
<img src="public/images/demo1.png">
<img src="public/images/demo2.png">

<h1>Installation</h1>
<h2><b>1. SpeedTest</b></h2>
<p>First of all, you need to install SpeedTest CLI from Ookla. You can find the installation instructions <a href="https://www.speedtest.net/apps/cli">here</a>.</p>
<h2>2.Install PHP</h2>
<p>Based on your operating system install PHP</p>
<h2>3.Install MySql</h2>
<p>Based on your operating system install MySQL</p>
<h2><b>4. Composer</b></h2>
<p>After you have installed SpeedTest CLI, you need to install Composer. You can find the installation instructions <a href="https://getcomposer.org/download/">here</a>.</p>
<h2><b>5. Clone the repository</b></h2>
<p>After you have installed Composer, you need to clone the repository. You can do that by running the following command in your terminal:</p>

```bash
git clone https://github.com/bak-george/WebSpeedReport.git 
```
<p>This will create a directory named WebSpeedReport containing all the repository files. Navigate into it with:</p>
    
```bash
cd WebSpeedReport
```
<h2><b>6. Install dependencies</b></h2>
<p>After you have cloned the repository, you need to install the dependencies. You can do that by running the following command in your terminal:</p>

```bash
composer install
```

<h2><b>7.Provide Permissions for the executable</b></h2>
<p>After you have installed the dependencies, you need to provide permissions for the executable. You can do that by running the following command in your terminal:</p>

```bash
chmod +x ./webspeedreport
```

<h1>Usage</h1>
<h2><b>1. Run the speedtest</b></h2>
<p>After you have installed the dependencies, you need to run the speedtest. 

You can do that by changing the directory to WebSpeedReport and running the following command in your terminal:</p>

```bash
cd WebSpeedReport

./webspeedreport app:speedtest
```
<p>This command will also create the database and table to insert the generated data.</p>
In order to get help for the command you can run the following command in your terminal:

```bash
./webspeedreport app:speedtest --help
```

<h2>2.Starting the local PHP server</h2>
<p>In order to see your generated data you'll need to run PHP localy on your computer.</p>
<p>You can do that by running the following command in your terminal:</p>

```bash
php -S localhost:8000 -t public
```

<h2>3.Accessing the dashboard</h2>
<p>After you have started the local PHP server, you can access the dashboard by opening the following link in your browser:</p>

```bash
http://localhost:8000
```

<h1>Contributing</h1>
<p>Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.</p>

<h1>Notice of Usage of Speedtest® by Ookla® in Open Source Projects</h1>
<p>In this open source project, we incorporate the use of Speedtest CLI provided by Ookla®. We acknowledge and respect Ookla® and its contributors' rights to the Speedtest® technology.

The Speedtest CLI tool allows users to test internet performance metrics, and this is utilized in our project to provide users with insights into their internet connectivity.

Our use of Speedtest CLI is in accordance with its licensing terms. We do not claim any ownership or rights over the Speedtest technology, logo, or other related properties, and all respective rights remain with Ookla®.

All users and contributors of this open source project are advised to review Ookla's terms of service and any related licensing agreements to ensure compliance when integrating or working with Speedtest technology.

Please support the original creators by visiting Ookla's official website for Speedtest: https://www.speedtest.net/

If there are any concerns or copyright issues, please contact george_bak'at'proton.me to address them promptly.</p>