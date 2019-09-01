#
# This file is only needed for Compass/Sass integration.
#
# If you'd like to learn more about Sass and Compass, see the sass/README.txt
# file for more information.
#

# Change this to :production when ready to deploy the CSS to the live server.
environment = :development

# In development, we can turn on the FireSass-compatible debug_info.
firesass = true


# Location of the theme's resources.
css_dir         = "dist/css"
sass_dir        = "src/scss"
images_dir      = "dist/images"
javascripts_dir = "dist/js"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :expanded

# To enable relative paths to assets via compass helper functions. Since Drupal
# themes can be installed in multiple locations, we don't need to worry about
# the absolute path to the theme from the server root.
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = true

# Pass options to sass. For development, we turn on the FireSass-compatible
# debug_info if the firesass config variable above is true.
sass_options = {:sourcemap => true}
