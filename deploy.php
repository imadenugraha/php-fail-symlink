<?php
namespace Deployer;

require 'recipe/common.php';

// Config

set('repository', 'git@github.com:imadenugraha/php-fail-symlink.git');

set('keep_releases', 3);

add('shared_files', ['config/config.php']);
add('shared_dirs', ['storage']);
add('writable_dirs', []);

// Hosts

host('your-server.com')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/home/php-fail-symlink');

// Tasks

task('deploy', [
    'deploy:prepare',
    'deploy:shared',
    'deploy:publish',
]);

// Hooks

after('deploy:failed', 'deploy:unlock');
