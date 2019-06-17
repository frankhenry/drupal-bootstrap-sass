# config valid for current version and patch releases of Capistrano
lock "~> 3.11.0"

set :application, "example" # Often, the root folder name. Try using File.basename(Dir.getwd)
#set :deploy_user, "git"
set :repo_url, "path-to-repo"  # example: git@bitbucket.org:fhenry99/fcd8.git"
# set :local_repository, "file://."

# Default branch is :test for now
# ask :branch, "test"

# There can be multiple stages on the same server, so deploy_to is defined in the stage-specific file rather than here.
# set :deploy_to, "/var/www/#{fetch(:application)}"

# Default value for :format is :airbrussh.
set :format, :airbrussh

# App path for D8 projects is usually "web"
set :app_path, "web"
set :drupal_version, "8"

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push("#{fetch(:app_path)}/sites/default/files", "private-files")

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
set :keep_releases, 3

