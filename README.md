Workflow Overview
=================

`environment.php` is your environment configuration; for the most part it sets
the basic PHP settings (error reporting, etc), and defines the main constant
to the main folder structure of the project.

`plugins/` contains external libraries and tools, be it modules or other 
libraries that are not modules themselves but also not module dependent; such as 
the autoloader

`modules/` contains your project modules. All code goes here.

`application/` is a special module where your log, cache and main configuration 
files are stored. It may also contain special classes and tweaks for the current
server, where the application is running on (ie. the current installation). All 
core classes should be located in `modules/`

Ideally `application/` should only contain `cache/` `config/` `logs/` and 
`bootstrap.php`. Everything else should go in the module where it's values are 
actually used. During development `config/` should also only exist for 
`plugins/` configuration, every piece of configuration required by modules 
should be located in the module.

`minion` is a command line utility. Call `minion help` on the command line for 
more information. Tasks for minion are defined by each module, so it's features
are dependent on which modules you have loaded. Windows users are advised to use
the git bash command line and add php to their path for running minion.

`public/` is folder your users should be accessing. The media folder on it's 
root is where general purpose static content should be placed.
