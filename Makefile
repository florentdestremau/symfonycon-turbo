start:
	symfony server:start &
	yarn encore dev-server
frankenphp:
	docker run -e FRANKENPHP_CONFIG="worker ./public/index.php" -e APP_RUNTIME=Runtime\\FrankenPhpSymfony\\Runtime -v $(PWD):/app -p 80:80 -p 443:443 dunglas/frankenphp
