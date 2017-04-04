## PHP版的BigBlueButton Playback

用來將多台BBB的影片集中控管

Centralized BBB's playback.

1. cd to bbbplayback directory
<pre>
cd bbbplayback
</pre>

2. Install packages
<pre>
composer install
</pre>

2. Add new .env file.
<pre>
cp .env.example .env
</pre>

3. Edit .env, and config your database settings.
<pre>
vim .env
</pre>

4. Create the application's database schema 
<pre>
php artisan migrate
</pre>

5. Rsync presentation files from BBB Server. 
<pre>
rsync -av yourserver:/var/bigbluebutton/published/presentation/ storage/app/presentation/
</pre>

6. Upate meetings table. 
<pre>
php artisan build
</pre>

7. Using tinker to create login user
<pre>
php artisan tinker
</pre>

<pre>
use App\User
$u = new User
$u->name='Admin'
$u->email='admin@example.com'
$u->password=bcrypt('secret')
$u->save()
exit
</pre>

8. Input email and password to login

http://localhost/login
