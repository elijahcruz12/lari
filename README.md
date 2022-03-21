# Lari

Lari (lar-ee) is an installer for Laravel, Laravel Zero, as well as packages for Laravel.

Note that it is still in beta, however installing Laravel and Laravel Zero do already work.

Note as well that this does not work on windows, but does work on Linux, MacOS, and WSL2.

## Installation.

`composer global require elijahcruz/lari`

## Requirements

- PHP 8.0+
- Composer 2+

If you need Tailwind or any of the installers that require NPM, make sure you have Node/NPM installed.

## Usage

Lari is pretty simple to use. After you install it globally, you can use it anywhere.

### Install Laravel

To create a Laravel project, just use the following command.

`lari install:laravel <app-name>`

### Install Laravel Zero

To create a Laravel Zero Project, just use the following command.

`lari install:laravelzero <app-name>`

### Packages.

I'm working on adding packages as an installable option. Currently, you can install TailwindCSS on a FRESH Laravel installation with Lari.

`lari install:tailwind`

