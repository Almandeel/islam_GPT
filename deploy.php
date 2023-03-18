<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
// require 'contrib/npm.php';

set('application', 'gpt');
set('repository', 'git@github.com:Almandeel/islam_GPT.git');
set('php_fpm_version', '8.0');
set('http_user', 'fvccdoee');
set('writable_mode', 'chmod');
// set('bin/composer',
// 	function () {
// 		return '/opt/cpanel/ea-php80/root/usr/bin/php /opt/cpanel/composer/bin/composer --ignore-platform-req=ext-zip --ignore-platform-req=ext-zip';
// 	}
// );
// set('branch', '9fe4e74afc00d09f87b17ede9b45975b06d638ed');
// set('bin/php', '/opt/alt/php80/var/lib/php');


// host('main')
//     ->set('remote_user', 'fvccdoee')
//     ->set('hostname', 'exo-contructing.com')
//     ->set('deploy_path', '~/app.exo-contructing.com');


// host('dev')
//     ->set('remote_user', 'fvccdoee')
//     ->set('hostname', 'exo-contructing.com')
//     ->set('deploy_path', '~/dev.exo-contructing.com');

host('mobile')
    ->set('remote_user', 'spatiula')
    ->set('hostname', 'spatiulab.com')
    ->set('deploy_path', '~/gpt.spatiulab.com');


task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:key:generate',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:optimize:clear',
    // 'artisan:migrate',
    // 'artisan:db:seed',
    // 'npm:install',
    // 'npm:run:prod',
    'deploy:publish',
    // 'php-fpm:reload',
]);

task('npm:run:prod', function () {
    cd('{{release_or_current_path}}');
    run('npm run prod');
});

after('deploy:failed', 'deploy:unlock');
