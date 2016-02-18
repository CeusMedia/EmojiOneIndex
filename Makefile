all: install set-rights

build:
	#@cd vendor/components/jquery && npm run build

install:
	@composer install
	@$(MAKE) --no-print-directory build
	
set-rights:
	@sudo chown -R kriss:www-data . && sudo chmod -R 770 .
	
update:
	@composer update
	@$(MAKE) --no-print-directory build

