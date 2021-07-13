**System Design:**
![blog_system_diagram](https://user-images.githubusercontent.com/20225436/125393779-77da4d80-e3a0-11eb-9bae-77fde723437f.png)


**Database Config:**
```
    DB_CONNECTION=mysql<br>
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=admin
    DB_PASSWORD=123456
```


**Setup Cron for FeedImportScheduler:**
```
* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
```


**Issues:**

I have an issue with my phpunit. The php I has installed is @7.3. It is the default version shipped with MacOS. I need to install php via brew and reconfig it as the default instead.
But it doesn't work out yet. I just write several feature tests for post model. As there is no way for me to run the tests, I decided not to write more until this issue is fixed.
I will update more tests when I get the latest PHP installed.
```
/usr/bin/php declares an invalid value for PHP_VERSION.
This breaks fundamental functionality such as version_compare().
Please use a different PHP interpreter.
```
