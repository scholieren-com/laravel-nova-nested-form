const mix = require('laravel-mix')
const path = require('path')

class NovaExtension {
    name() {
        return 'nova-extension'
    }

    register(name) {
        this.name = name
    }

    webpackConfig(webpackConfig) {
        webpackConfig.externals = {
            vue: 'Vue',
            'laravel-nova': 'LaravelNova',
            'laravel-nova-ui': 'LaravelNovaUi',
            'laravel-nova-util': 'LaravelNovaUtil',
        }

        webpackConfig.resolve.alias = {
            ...(webpackConfig.resolve.alias || {}),
            '@': path.resolve(__dirname, './vendor/laravel/nova/resources/js/'),
            'uid/single': path.join(__dirname, 'node_modules/uid/single/index.mjs'),
        }

        webpackConfig.output = {
            uniqueName: this.name,
        }
    }
}

mix.extend('nova', new NovaExtension())
