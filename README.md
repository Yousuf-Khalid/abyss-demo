<h1>Abyss Demo Setup</h1>

<h3>Installation</h3>

<ul>
    <li>Clone the project</li>
    <li>Run <code>composer install</code></li>
    <li>Copy your <code>.env</code> file from <code>.env.example</code></li>
    <li>Run <code>php artisan config:cache</code></li>
    <li>Run <code>php artisan migrate</code></li>
    <li>Download <a href="https://drive.google.com/drive/folders/1y0H6WN4ELDeEurO8ine71nOHVkfUTRg2?usp=sharing">Postman Collection</a> for api's testing</li>
    <li>Initiate your server <code>php artisan serve</code></li>
</ul>

<br>

<b>Note:</b>
<i>This project has some cron jobs setup. You need to only configure command <code>php artisan schedule:run</code> in your cron job system setting.</i>
<br>
<h3>Congrats! You have everything ready.</p>
