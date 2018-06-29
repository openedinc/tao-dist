web: ./bin/init && heroku-php-apache2 -l log.txt
worker: touch log.txt && tail -f log.txt & php index.php 'oat\taoTaskQueue\scripts\tools\RunWorker'
