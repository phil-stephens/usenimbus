![Nimbus](https://philstephens.io/image/Media/nimbus-icon.png)

# Nimbus
### Really Simple File-sharing

## Version 1

This is the original codebase for a file-sharing service (think Droplr) that enabled you to use your own cloud-based storage service to host the files.

This initial version was designed to work with Dropbox, Copy.com and Amazon S3.  It also has Facebook registration/login enabled.  It was originally intended to be a SAAS-type offering (and might still be) but life got in the way and I ended up not finishing the first round of coding.

I will be revisiting the system with a complete overhaul of the codebase and some major changes in functionality, re-focussing the service on leveraging AWS (let's face it, Dropbox is already pretty awesome at sharing files!).  I probably will open-source it, but in the meantime I figured I might as well put this first round of development up for grabs.

## Caveats

This version of the system is offered as-is and without warranty.  I will not be maintaining this version, nor will I be accepting pull-requests or responding to issues (unless they are questions relating to how it works/how to get it set up).  If you want to do something with it, go for it!

There are no tests set up (yeah, yeah, I know!) nor is there any kind of consistent code commenting/Doc blocks.  The whole system is based on the Laravel 5 framework (version 5.0) so you should be able to find your way around it easily enough.

The system uses a slightly hacked version of the awesome Glide image manipulation package.  It was at a time where a number of underlying flaws were found in the Intervention package that the author was working through addressing, so I extended the package and made my own adjustments.  I also added a rudimentary watermarking package (just enough for what I needed) - something that is now available as part of the Glide core.

The system also bypassed the built-in Filesystem service with it's own interface for Flysystem - not overly elegant but a good solution to having numerous remote file systems in play at any given time (whose configuration is controlled via the database).

## Setup

Assuming that you can get a modern web server spun up with database (I would recommend a combination of Laravel Forge and Digital Ocean - it's what the existing Nimbus website is running on) there are a number of configuration hoops to jump through:

### Installation

Navigate to the project folder and create your `.env` file:

`cp .env.example .env`

Open it up in your favourite editor and complete your database credentials (we'll come to the other settings later).

Next install your Composer dependencies:

`composer update`

Build the database:

`php artisan migrate`

And then set up the uploads folder in the application storage directory:

`mkdir storage/app/uploads`

Depending on how your PHP installation is set up you might need to increase the upload/post size before you can upload any files of any kind of decent size:

`sudo nano /etc/php5/fpm/php.ini`

```
...
; Maximum allowed size for uploaded files.
; http://php.net/upload-max-filesize
upload_max_filesize = 100M

; Maximum size of POST data that PHP will accept.
; Its value may be 0 to disable the limit. It is ignored if POST data reading
; is disabled through enable_post_data_reading.
; http://php.net/post-max-size
post_max_size = 125M
...
```

`sudo service php5-fpm restart`


## Credentials etc

### Facebook Login/Registration

You will need to create a new app through the Developer portal and add the credentials to this block:

```
FACEBOOK_CLIENT_ID=XXXXXXXX
FACEBOOK_CLIENT_SECRET=XXXXXXXX
FACEBOOK_CALLBACK_URL=http://localhost/oauth/facebook/callback
```

### Dropbox

Create a new application through the Dropbox developer portal and add the credentials here:

```
DROPBOX_APP_NAME=Nimbus File Sharing
DROPBOX_CLIENT_ID=XXXXXXXX
DROPBOX_CLIENT_SECRET=XXXXXXXX
```

You will also need an SSL certificate for the Oauth flow used by Dropbox.  No dramas - you can pick one up pretty cheap (or even free) these days.

### ~Copy.com~

~Create a new application through the Copy.com developer portal and add the credentials here:~

```
COPY_IDENTIFIER=XXXXXXXX
COPY_SECRET=XXXXXXXX
COPY_BASE_FOLDER=Nimbus/
```

* The Copy storage platform is no longer available

### Default Filesystem

Nimbus bypassed Laravel's in-built Filesystem feature to enable it to connect to multiple filesystems whose credentials are stored in a database.  For that reason, if you want to use anything other than the local filesystem to store any image manipulations (via Glide) then you will need to add it's credentials as a JSON strong.  An example S3 configuration is provided.
