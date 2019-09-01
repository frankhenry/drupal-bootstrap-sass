# FC Bootstrap - a Drupal 8 Bootstrap subtheme with Sass, Grunt, and Font Awesome

This is a Bootstrap subtheme for Drupal 8 that uses Sass, Grunt, and Font Awesome. It was designed for a specific project but I tried to make it comprehensive and cleanly structured so that it can be useful as a starting point for others.

The key principle is the theme includes all the resources you need to build and maintain a Bootstrap theme that includes Bootswatch themes and Font Awesome. The various Grunt commands compile Sass into CSS, merge and minimize CSS and Javascript, optimize images, and copy files from various folders into the `dist` folder that is referenced by the actual theme. This causes some duplication but it has the advantage of allowing to easily clean up and start afresh by emptying the `dist` folder and executing `grunt` commands again.

The table below lists the essential components

Component | Location
--------- | --------
Bootstrap core Javascript|bootstrap/assets/javascripts
Bootstrap Javascript plugins|bootstrap/assets/javascripts/bootstrap
Bootstrap Glyphicon fonts|bootstrap/assets/fonts/bootstrap
Bootswatch themes - stylesheets that provide alternatives to the standard Bootstrap styling. See [bootswatch.com](https://www.bootswatch.com) for details. The files are provided by the [unicorn-fail/drupal-bootstrap-styles](https://github.com/unicorn-fail/drupal-bootstrap-styles) project.|assets/bootstrap/3.4.1/8.x-3.x
Font Awesome SCSS stylesheets|assets/fontawesome/scss
Font Awesome webfonts|assets/fontawesome/webfonts


## Installation

You'll need `node.js` and `npm` installed to use the Gruntfile. More info is available at [nodejs.org](https://nodejs.org/en/) and [npmjs.com/get-npm](https://www.npmjs.com/get-npm). 

Tip: [Grunt for People Who Think Things Like Grunt are Weird and Hard](https://24ways.org/2013/grunt-is-not-weird-and-hard/) is an excellent intro if you're new to Grunt.

The command to install the Gruntfile is

`npm install --save-dev`

This will install the packages listed in `package.json` and will create a `package-lock.json` file in your subtheme folder.

To build the theme components after customising them, use this command

`grunt <command-name>`

For example, to compile the Sass files, the command is

`grunt build-css`

When you're building for production, add `--target=prod` to the command. Typically, you would use that only with `grunt deploy`, e.g. 

`grunt deploy -- target=prod`

If you don't specify a target, `dev` is used as the default. CSS and JS files are minified when you build for `prod` but not when you build for `dev`.

The table below lists the commands defined in the Gruntfile.


## Structure of the Gruntfile

The various folders and files in the theme are specified in a `resources` object which is referenced by the tasks in the file. This avoids duplication of file names. 

Command|Description
-------|-----------
`grunt build-js`|Builds the site Javascript and places it in `dist/js`
`grunt build-css`|Builds the site stylesheets and places them in `dist/css`
`grunt build-img`|Minimizes the theme images and copies them to `dist/img`
`grunt clean`|Clears the `dist` folder.
`grunt deploy`|Clears the `dist` folder, rebuilds the site CSS and JS, and copies images and fonts
`grunt deploy --target=prod`|Same as `grunt deploy` except the files are minified
`grunt lint`|Run `sass-lint` on styles
`grunt watch`|Watch the theme folder and run `compass` and `uglify` when changes are detected


## Limitations

Using the Gruntfile in this theme leads to some duplication of resources, i.e. files from the `assets`, `bootstrap`, and `src` folders are copied into the `dist` folder. You can add the `dist` folder to your `.gitignore` file to keep the duplicated files out of the repo, but if you do, you'll need to populate the `dist` folder during your deployment. This in turn requires installation of node modules on your deployment server &ndash; I find it more convenient to include the `dist` folder in the repo because it simplifies deployment, but others might disagree - there are lots of ways to do these things, all with their own advantages and disadvantages.




