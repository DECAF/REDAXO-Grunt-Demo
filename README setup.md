# System and project setup


## 1. Requirements (system setup)

The frontend workflow requires some tools installed on your system. Please check and install in this order:   

__1. Ruby__  
Programming language. Required for Sass/Compass and extensions.  
  
Windows: Use installer from http://rubyinstaller.org  
Mac OS: Ruby is already installed.


__2. PHP__  
Programming language. While in development mode, parts of this project setup are based on PHP. Most notably we make use of a PHP class which handles the CSS/JS resources in production and live modes _(see README workflow.md)_.


__3. Node.js and npm__  
Node.js is a JavaScript based software platform. npm is the package manager for Node.  
Required for Grunt, CoffeeScript and further tools.  
  
Windows and Mac OS: Use installer from http://nodejs.org


__4. Grunt__  
The JavaScript Task Runner for our frontend workflow. See setup infos at http://gruntjs.com/getting-started.  
  
Install the command line interface (CLI) globally by:

    $ npm install -g grunt-cli

_Hint: You may need to use `sudo` (for OSX, *nix, BSD etc) or run your command shell as Administrator (for Windows) to do this — now and later on in this setup process!_


__5. CoffeeScript__  
JavaScript on caffeine. http://coffeescript.org/.

    $ npm install -g coffee-script

_Hint: Remember `sudo` and the admin shell if necessary._


__6. Bundler__  
A sort of package manager for ruby applications, see http://bundler.io/.

    $ gem install bundler


__7. Sass/Compass__  
Compass is an open-source CSS Authoring Framework, see http://compass-style.org/. It uses Sass (http://sass-lang.com/), which will be installed right along with Compass.

    $ gem install compass


Your system is ready for our frontend workflow now. Next up we'll setup the project.



## 2. Project setup

Use the terminal, change to the **project folder**.

    $ bundle install

This will install all required ruby gems (which are defined in the `Gemfile` in the root folder of the project).

Now install the required node modules (which are defined in `package.json`):

    $ npm install

_Hint: Again, if you run into errors, prepend `sudo` and try again acting as administrator, e.g. `sudo npm install`._


The project setup is complete. You can start developing now.
Set your Apache localhost/vhost to `app/`.


---

Find information about the project structure and its workflow in  
**README workflow.md**
