# Frontend workflow


## 1. Development and build process

### Development

Start the project in **development mode** with:

    $ grunt

In development mode grunt watches your resources (CSS, JS, Sprites), recompiles them on changes and comes up with a livereload in your browser.

_Hint: Stop anytime with `ctrl + c`._

### Build

Build the project by typing:

    $ grunt build

The build process graps all resources, compiles, combines and minifies them (CSS, JS), generates sprites and does some copy tasks to target folders.

**Build your project at all times before deploying to a webserver!**


### Release

Generate a release

	$ grunt dist

**uses [grunt-php2html](https://github.com/bezoerb/grunt-php2html). Install this first!**
You might have to stop your local development server, if the task fails.

## 2. Switch mode between develop and live

First up, the idea: We **do not** separate a development site folder (usually: `dev/` or `app/`) and a production/live site folder (usually: `dist/`). Instead there is one `app/` folder only containing both the development resources and the distributed live resources.

Why is it?
We tried to achieve a rather simple environment where a single **CMS** instance may run along and deal with both the development website and the live website. This was done by a trigger `app/_DEBUG` and a PHP class `app/static/php/dcf.html.class.php` which manages to include either the raw development resources (CSS/JS) or the minified live resources. You will find more details later on in the document.


__Switch to develop mode__  
Place an empty file `app/_DEBUG`.

__Switch to live mode__
Remove or rename the file `app/_DEBUG`.



## 3. Project folder structure

#### Root

    app/
       static/
          coffee/
          components/
          css/
          css_src/
          img/
          js/
          php/
          sass/
       _DEBUG
    node_modules/
    Gemfile
    Gruntfile.js
    package.json
    scripts.json

Description:

* `app/`  
  Contains the website/webapp.
* `app/static/`  
  Contains the website's resources like CSS, JS, images, third-party components et all.
* **`app/_DEBUG`**  
  **Important: Toggles the website mode between development/debug and live. If the file is available the website/webapp will be in debug mode. Remove (or rename) the file in order to switch to the live mode.**  
  _Hint: In debug mode resoures (CSS/JS) are unminified and each file included separately (which causes multiple server requests). In live mode everything is minified and combined to one resource._ 
* `node_modules/`  
  Contains the modules used with Node.js for this website/webapp.
* `Gemfile`  
  Bundler file: defines the ruby gems used for this website/webapp.
* `Gruntfile.js`  
   Used to configure or define tasks and load Grunt plugins.
* `package.json`  
  Used by npm to store project metadata.
* **`scripts.json`**  
  **Important: This is where we define all JavaScripts resources. You will update this file regularly while developing the website.**



#### CSS

    app/
       static/
          css/
             site.css
          css_src/
             site.css
          sass/
             partials/
             vendor/
             site.scss

Description:

* `../css/`  
  `../css/site.css`  
  Combined and minified CSS generated in build process and used for the live site. Do not modify!
* `../css_src/`  
  `../css_src/site.css`  
  Combined but unminified CSS generated in development process and used for debugging the dev site. Do not modify!
* **`../sass/`**  
  **`../sass/site.scss`**  
  **Sass development folder containing the main sass file. This is where you write CSS with Sass.**
* **`../sass/partials/`**  
  **Contains Sass partials which are '@import'ed by the sass file. This is where you develop CSS modules/elements/components.**
* `../sass/vendor/`  
  Contains CSS of third-party components and will be '@import'ed by the Sass file when you want them to be compiled with your CSS.  
  Do not modify! However: You need to customise file paths sometimes.

_Hint: Due to Internet Explorer's 4096 selector limit it may be necessary to use more than one CSS file. Instead of `site.scss` you'll find `site1.scss` and `site2.scss` or something like that._



#### Javascript

    app/
       static/
          coffee/
          js/
             coffee/
             src/
                vendor/
                general.js
             body.json
             body.min.js
             head.json
             head.min.js

Description:

* **`../coffee/`**  
  **Contains your CoffeeScript sources. This is where you develop JavaScript when writing coffee.**
* `../js/coffee/`  
  Compiled coffee scripts. Do not modify!
* **`../js/src/`**  
  **`../js/src/general.js`**  
  **Source folder of your JavaScript files. This is where you develop JavaScript without coffee, e.g. general.js**
* **`../js/src/vendor/`**  
  **Contains third-party JavaScript resources such as jQuery, modernizr et all.**  
  _(Hint: Single files only, use `app/static/components/` for packages!)_
* `../js/body.json`  
  `../js/head.json`  
  JSON files containing scripts (URIs). Generated by Grunt, do not modify!
* `../js/body.min.js`  
  `../js/head.min.js`  
  Minifed scripts generated in build process. Do not modify!



#### Third-party components

    app/
       static/
          components/

Description:

* `../components/`  
  Contains third-party packages, e.g. Twitter Bootstrap, Fancybox, Video players et all.  
  Do not modify in order to allow for future updates!



#### Images and CSS sprites

    app/
       static/
          img/
             sprites/
                assets/
                assets2x/

Description:

* **`../img/`**  
  **This is where you place images used in the website/webapp templates.**  
  _Hint: We recommend not to place user generated images in this folder, e.g. images managed by a CMS. Better keep it separated and maintainable!_
* `../img/sprites/`  
  **`../img/sprites/assets/`**  
  **`../img/sprites/assets2x/`**  
  **Assets folder for CSS sprites. This is where you place images of which Compass automatically generates CSS sprites.**  
  _Hint: `assets2x/` is for HiDPI/Retina images!_



#### PHP and the dcf.html.class

    app/
       static/
          php/
             dcf.html.class.php

Description:

* **`../php/`**  
  **This is where you can place PHP resources if you like to.**
* `../php/dcf.html.class.php`  
  Important: The class manages to include either the raw development resources (CSS/JS) or the minified live resources, based on the availability of `app/_DEBUG`.



## 3. How to use the PHP class `dcf.html.class`

__1. Include the class to your templates and define the path prefix__

    require_once( $PATH/$TO/static/php/dcf.html.class.php' );
    DCF_HTML::setPathPrefix( '../' );

The path prefix manages to find the CSS and JS resources based on the path of your templates. In our default setup we'll have to go one level up `../` in order to get to the `static/` folder.

__2. Add CSS resources__

    DCF_HTML::setCssFiles( array('site.css') );

You can use more than one CSS file, that's why we use the array notation.  
Here is an example for multiple files:

    DCF_HTML::setCssFiles( array('site1.css', 'site2.css', 'theme.css') );

__3. Compose the head resources__  
Simply place the one line of code in the `<head>` section of the HTML document:

    echo DCF_HTML::composeHead();

__4. Compose the `<body>` resources__  
Place the code at the end of the HTML document right before the closing `</body>` tag:

    echo DCF_HTML::composeBody();

Done.

_Hint: If you don't want to use the PHP class — maybe because you use Ruby on Rails, not PHP — you'll have to adopt the business logic to your code. Unfortunately we can present a PHP solution only._

