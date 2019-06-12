require "rubygems"
require "capistrano/setup"

require "capistrano/deploy"

# First deployment will fail if linked files (specifically, settings.php for Drupal sites) do not exist, but the file is only
# created after deployment. This gem allows this problem to be overcome. See https://github.com/rjocoleman/capistrano-touch-linked-files.
require "capistrano/touch-linked-files"

# Load the SCM plugin appropriate to your project:
#
# require "capistrano/scm/hg"
# install_plugin Capistrano::SCM::Hg
# or
# require "capistrano/scm/svn"
# install_plugin Capistrano::SCM::Svn
# or
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git

# Include composer
require "capistrano/composer"

# Include Drupal deployment tasks
require "capistrano/drupal-deploy"

# Include config/deploy
# require "config/deploy"

# Include tasks from other gems included in your Gemfile
#
# For documentation on these, see for example:
#
#   https://github.com/capistrano/rvm
#   https://github.com/capistrano/rbenv
#   https://github.com/capistrano/chruby
#   https://github.com/capistrano/bundler
#   https://github.com/capistrano/rails
#   https://github.com/capistrano/passenger
#
# require "capistrano/rbenv"
# require "capistrano/chruby"
require "capistrano/bundler"
# require "capistrano/rails/migrations"
# require "capistrano/passenger"

# Load custom tasks from `lib/capistrano/tasks` if you have any defined
Dir.glob("lib/capistrano/tasks/*.rake").each { |r| import r }
