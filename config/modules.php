<?php

use Nwidart\Modules\Activators\FileActivator;
use Nwidart\Modules\Commands;

return [
    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    "namespace" => "Module",

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    "stubs" => [
        "enabled" => false,
        "path" => base_path(
            "vendor/nwidart/laravel-modules/src/Commands/stubs",
        ),
        "files" => [
            "routes/web" => "Presentation/Route/web.php",
            "routes/api" => "Presentation/Route/api.php",
            "views/index" => "Presentation/Resource/View/index.blade.php",
            "views/master" => "Presentation/Resource/View/layouts/master.blade.php",
            "scaffold/config" => "config/config.php",
            "composer" => "composer.json",
            "assets/js/app" => "Presentation/Resource/Asset/js/app.js",
            "assets/sass/app" => "Presentation/Resource/Asset/sass/app.scss",
            "vite" => "vite.config.js",
            "package" => "package.json",
        ],
        "replacements" => [
            "routes/web" => [
                "LOWER_NAME",
                "STUDLY_NAME",
                "MODULE_NAMESPACE",
                "CONTROLLER_NAMESPACE",
            ],
            "routes/api" => ["LOWER_NAME", "STUDLY_NAME"],
            "vite" => ["LOWER_NAME"],
            "json" => [
                "LOWER_NAME",
                "STUDLY_NAME",
                "MODULE_NAMESPACE",
                "PROVIDER_NAMESPACE",
            ],
            "views/index" => ["LOWER_NAME"],
            "views/master" => ["LOWER_NAME", "STUDLY_NAME"],
            "scaffold/config" => ["STUDLY_NAME"],
            "composer" => [
                "LOWER_NAME",
                "STUDLY_NAME",
                "VENDOR",
                "AUTHOR_NAME",
                "AUTHOR_EMAIL",
                "MODULE_NAMESPACE",
                "PROVIDER_NAMESPACE",
            ],
        ],
        "gitkeep" => true,
    ],
    "paths" => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path is used to save the generated module.
        | This path will also be added automatically to the list of scanned folders.
        |
        */

        "modules" => base_path("src"),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules' assets path.
        |
        */

        "assets" => public_path("module"),
        /*
        |--------------------------------------------------------------------------
        | The migrations' path
        |--------------------------------------------------------------------------
        |
        | Where you run the 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        "migration" => base_path("database/migrations"),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate's key to false to not generate that folder
        */
        "generator" => [
            /* Domain */
            "domain-entity" => ["path" => "Domain/Entity", "generate" => true],
            "domain-value-object" => [
                "path" => "Domain/ValueObject",
                "generate" => true,
            ],
            "domain-repository" => [
                "path" => "Domain/Repository",
                "generate" => true,
            ],
            "domain-service" => [
                "path" => "Domain/Service",
                "generate" => true,
            ],
            "domain-event" => ["path" => "Domain/Event", "generate" => true],

            /*
             * Application
             */
            "application-command" => [
                "path" => "Application/UseCase/Command",
                "generate" => true,
            ],
            "application-query" => [
                "path" => "Application/UseCase/Query",
                "generate" => true,
            ],
            "application-event" => [
                "path" => "Application/UseCase/Event",
                "generate" => true,
            ],

            /*
             * Infrastructure
             */
            "migration" => [
                "path" => "Infrastructure/Database/Migration",
                "generate" => true,
            ],
            "seeder" => [
                "path" => "Infrastructure/Database/Seeder",
                "generate" => true,
            ],
            "factory" => [
                "path" => "Infrastructure/Database/Factory",
                "generate" => true,
            ],
            "model" => ["path" => "Infrastructure/Model", "generate" => true],
            "observer" => [
                "path" => "Infrastructure/Observer",
                "generate" => false,
            ],
            "provider" => [
                "path" => "Infrastructure/Provider",
                "generate" => true,
            ],
            "repository" => [
                "path" => "Infrastructure/Repository",
                "generate" => true,
            ],
            "event" => ["path" => "Infrastructure/Event", "generate" => false],
            "listener" => [
                "path" => "Infrastructure/Listener",
                "generate" => false,
            ],
            "rules" => ["path" => "Infrastructure/Rule", "generate" => false],
            "jobs" => ["path" => "Infrastructure/Job", "generate" => false],
            "policies" => [
                "path" => "Infrastructure/Policy",
                "generate" => false,
            ],
            "resource" => [
                "path" => "Infrastructure/Resource",
                "generate" => false,
            ],

            /*
             * Presentation
             */
            "command" => [
                "path" => "Presentation/Console",
                "generate" => false,
            ],
            "channels" => [
                "path" => "Presentation/Channel",
                "generate" => false,
            ],
            "routes" => ["path" => "Presentation/Route", "generate" => true],
            "controller" => [
                "path" => "Presentation/Controller",
                "generate" => true,
            ],
            "filter" => [
                "path" => "Presentation/Middleware",
                "generate" => true,
            ],
            "request" => ["path" => "Presentation/Request", "generate" => true],
            "assets" => [
                "path" => "Presentation/Resource/Asset",
                "generate" => true,
            ],
            "lang" => [
                "path" => "Presentation/Resource/Lang",
                "generate" => true,
            ],
            "views" => [
                "path" => "Presentation/Resource/View",
                "generate" => true,
            ],
            "component-view" => [
                "path" => "Presentation/Resource/View/Component",
                "generate" => false,
            ],
            "component-class" => [
                "path" => "Presentation/Resource/View/Component",
                "generate" => false,
            ],
            "emails" => ["path" => "Presentation/Email", "generate" => false],
            "notifications" => [
                "path" => "Presentation/Notification",
                "generate" => false,
            ],

            /*
             * Test
             */
            "test" => ["path" => "Test/Unit", "generate" => true],
            "test-feature" => ["path" => "Test/Feature", "generate" => true],

            /*
             * Other
             */
            "config" => ["path" => "config", "generate" => true],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Package commands
    |--------------------------------------------------------------------------
    |
    | Here you can define which commands will be visible and used in your
    | application. If for example, you don't use some of the commands provided
    | you can simply comment them out.
    |
    */
    "commands" => [
        Commands\CommandMakeCommand::class,
        Commands\ComponentClassMakeCommand::class,
        Commands\ComponentViewMakeCommand::class,
        Commands\ControllerMakeCommand::class,
        Commands\ChannelMakeCommand::class,
        Commands\DisableCommand::class,
        Commands\DumpCommand::class,
        Commands\EnableCommand::class,
        Commands\EventMakeCommand::class,
        Commands\FactoryMakeCommand::class,
        Commands\JobMakeCommand::class,
        Commands\ListenerMakeCommand::class,
        Commands\MailMakeCommand::class,
        Commands\MiddlewareMakeCommand::class,
        Commands\NotificationMakeCommand::class,
        Commands\ObserverMakeCommand::class,
        Commands\PolicyMakeCommand::class,
        Commands\ProviderMakeCommand::class,
        Commands\InstallCommand::class,
        Commands\LaravelModulesV6Migrator::class,
        Commands\ListCommand::class,
        Commands\ModuleDeleteCommand::class,
        Commands\ModuleMakeCommand::class,
        Commands\MigrateCommand::class,
        Commands\MigrateFreshCommand::class,
        Commands\MigrateRefreshCommand::class,
        Commands\MigrateResetCommand::class,
        Commands\MigrateRollbackCommand::class,
        Commands\MigrateStatusCommand::class,
        Commands\MigrationMakeCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\ResourceMakeCommand::class,
        Commands\RequestMakeCommand::class,
        Commands\RuleMakeCommand::class,
        Commands\RouteProviderMakeCommand::class,
        Commands\PublishCommand::class,
        Commands\PublishConfigurationCommand::class,
        Commands\PublishMigrationCommand::class,
        Commands\PublishTranslationCommand::class,
        Commands\SeedCommand::class,
        Commands\SeedMakeCommand::class,
        Commands\SetupCommand::class,
        Commands\TestMakeCommand::class,
        Commands\UnUseCommand::class,
        Commands\UpdateCommand::class,
        Commands\UseCommand::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    "scan" => [
        "enabled" => false,
        "paths" => [base_path("vendor/*/*")],
    ],
    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for the composer.json file, generated by this package
    |
    */

    "composer" => [
        "vendor" => "makeitlv",
        "author" => [
            "name" => "Viktors Vipolzovs",
            "email" => "viktor.vipolzov@gmail.com",
        ],
        "composer-output" => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up the caching feature.
    |
    */
    "cache" => [
        "enabled" => false,
        "driver" => "file",
        "key" => "laravel-modules",
        "lifetime" => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    "register" => [
        "translations" => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        "files" => "register",
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database, etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    "activators" => [
        "file" => [
            "class" => FileActivator::class,
            "statuses-file" => base_path("modules_statuses.json"),
            "cache-key" => "activator.installed",
            "cache-lifetime" => 604800,
        ],
    ],

    "activator" => "file",
];
