<?php
namespace Deployer;

require 'recipe/common.php';

// Config

set('repository', 'git@github.com:imadenugraha/php-fail-symlink.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('192.168.122.10')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~//home/php-fail-symlink');

// Hooks

after('deploy:failed', 'deploy:unlock');
