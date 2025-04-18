# Theme instructions

## Installation:
1. Download theme files
2. Rename theme folder according to your project requirements
3. edit the theme `/style.css` so your theme will match your project requirements in WP Theme selector.
4. change the default `/screenshot.jpg` to the image that will match your project. Image dimensions: 1200px*900px
5. edit `/tools/gulpfile.js:11` - **wp_domain** should match your local development domain
6. install node modules: `npm -i`

## Gulp tasks:
* `gulp serve` - starts file watcher and automatically updates CSS when you're editing SCSS files and reloads page when you're editing PHP files.
* `gulp styles` - recompiles main SCSS=>CSS
* `gulp blocksStyles` - recompiles all 'blocks' styles
* `createNewBlock --name="BlockName"` - creates new block folder with default settings where {BlockName} will be folder name and will be used as the main class for the block CSS 

## Included modules:
All modules are enabled by default. You can disable/enable them in `./functions.php`
* wp-cleanup

    _Removes WP RSS feed, jQuery migrate etc._
* svg-support

  _Adds SVG support for Media Library upload_
* register-json-blocks

  _Registers ACF Blocks support. ACF Pro is required to be installed and activated. All blocks in /blocks folder will be automatically registered. Use gulp 'createNewBlock' action to create new blocks._
* ht-disable-emoji

  _Disables Emoji support in comments and content_
* ht-dashboard-cleanup

  _Removes all default Dashboard widgets except the 'Site health' widget_
* ht-custom-login-styles

  _Adds custom styling to WP login page_