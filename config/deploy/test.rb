# server-based syntax
# ======================
# Defines a single server with a list of roles and multiple properties.
# You can define all roles on a single server, or split them:

server "example.com", user: "example", roles: %w{db app}
# server "example.com", user: "deploy", roles: %w{app web}, other_property: :other_value
# server "db.example.com", user: "deploy", roles: %w{db}



# role-based syntax
# ==================

# Defines a role with one or multiple servers. The primary server in each
# group is considered to be the first unless any hosts have the primary
# property set. Specify the username and a domain or IP for the server.
# Don't use `:all`, it's a meta role.

role :app, %w{example.com}
role :db,  %w{example.com}

# Configuration
# =============
# You can set any configuration variable like in config/deploy.rb
# These variables are then only loaded and set in this stage.
# For available Capistrano configuration variables see the documentation page.
# http://capistranorb.com/documentation/getting-started/configuration/
# Feel free to add new variables to customise your setup.
set :branch, "test"
set :stage, :test
set :settings_file, "test.settings.php"
set :deploy_to, "/var/www/#{fetch(:application)}"


# Not quite sure what this is used for, and 'cap test doctor' complain about it,  but the 
# deployment script won't work without it. The documentation mentions an 'app_path' variable so I think 
# it's a typo and should have said 'shared_path'.
set :shared_path, "/var/www/#{fetch(:application)}"

# Custom SSH Options
# ==================
# You may pass any option but keep in mind that net/ssh understands a
# limited set of options, consult the Net::SSH documentation.
# http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start
#
# Global options
# --------------
set :ssh_options, {
  keys: %w(/~/.ssh/id_rsa),
  forward_agent: true,
  auth_methods: %w(publickey)
}
#
# The server-based syntax can be used to override options:
# ------------------------------------
server "example.com",
  user: "example",
  roles: %w{web db},
  ssh_options: {
    user: "git", # overrides user setting above
    keys: %w(~/.ssh/id_rsa),
    forward_agent: true,
    auth_methods: %w(publickey)
  }
