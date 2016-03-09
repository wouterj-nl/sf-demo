WouterJ's Symfony Example App: Finance
======================================

This application is a big showcase of some of my best practices when
writing Symfony applications that have some complexity. It doesn't
contain lots of features (yet), it's just meant as an example when
helping other people.

Feel free to read the documentation in the source code!

A Small Overview
----------------

**General idea**: This app is meant to keep track of your finances.
The main entities are the *wallets* (e.g. a "Food & Drinks" wallet, a
"Worksalary" one, etc.). Money can be transfered between these wallets
using *transactions*.

There are 2 big seperations in this code: The Bundle and the Finance
library.

 * The Finance library is completely decoupled from Symfony stuff
(the *infrastructure*) and in theory could be used with any framework.

 * The Bundle integrates this library in the Symfony framework, by
   providing controllers, service configuration and implementations of
   the interfaces in the Finance library.

The Symfony application provides an API, which is used by [ReactJS][reactjs]
to generate the front-end. The ReactJS components and the Sass CSS stylesheets
can be found in the `/assets/` directory.

Running the Application Locally
-------------------------------

 1. Clone the project: `git clone https://github.com/WouterJ/sf-demo`
 2. Install PHP and NodeJS dependencies: `composer install & npm install`
 3. Run [webpack][webpack] to compile all front-end assets: `webpack`
 4. Start the webserver and visit the site

Questions?
----------

Feel free to create an issue to ask some questions or suggest some other
best practices or talk to me on IRC (WouterJ on freenode).

Interesting Reads
-----------------

Lots of the concepts used in this project are well documented in blog posts.
Reading them will provide more background information.

 * [Code Folder Structure, Mathias Verraes](http://verraes.net/2011/10/code-folder-structure/)
 * [A wave of command buses, Matthias Noback](http://php-and-symfony.matthiasnoback.nl/2015/01/a-wave-of-command-buses/)
 * [Hexagonal Architecture, Matthias Noback](https://www.youtube.com/watch?v=fgQWnglnGeU)
 * [Integrate Symfony and Webpack, Benjamin Eberlei](http://www.whitewashing.de/2015/02/26/integrate_symfony_and_webpack.html)
 * [The Symfony Framework Best Practices](http://symfony.com/doc/current/best_practices/introduction.html)

 [reactjs]: https://facebook.github.io/react/
 [webpack]: https://webpack.github.io/
