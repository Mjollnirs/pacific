# Pacific

[![Build Status](https://travis-ci.org/BrazenlyGeek/pacific.svg?branch=master)](https://travis-ci.org/BrazenlyGeek/pacific) [![devDependency Status](https://david-dm.org/BrazenlyGeek/pacific/dev-status.svg)](https://david-dm.org/BrazenlyGeek/pacific#info=devDependencies) [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/BrazenlyGeek/pacific)

* Author:		Rick Beckman
* Author URL:	https://rickbeckman.com/
* License:		[GNU General Public License v3.0](http://www.gnu.org/licenses/gpl-3.0.html)

## Description

A crisp WordPress theme built using Bootstrap styling, Font Awesome icons, and all the power of WordPress. This is an eternal WIP: Here there be dragons.

## Features (excluding external resources, see below)

* Responsive layout
* Off-canvas sidebar on handheld devices and small screens
* WordPress customizer options:
  * Add site logo
  * Add favicon
  * Select fonts (via Google Fonts)
  * Choose colors
  * And more!
* Editor style for a more WYSIWYG post-editing experience
* Fully HTML5 compatible
* Compatible up to WordPress 4.4.2
* Customization ready via child themes and/or hooks (see below for available hooks)
* Microdata and microformats - Enhancements for richer posts
* Translation ready

## Resources

* Pacific is a port of [Flat](https://github.com/Codeinwp/flat) ([GPL v3.0](http://www.gnu.org/licenses/gpl-3.0.html)), originally by [Yoarts](http://www.yoarts.com/free-flat-design-wordpress-theme/)
* Flat was based on [DW Minion](http://www.designwall.com/wordpress/themes/dw-minion/) ([GPL v3.0](http://www.gnu.org/licenses/gpl-3.0.html))

* Front-end styling built on [Bootstrap](http://getbootstrap.com/) ([MIT](https://opensource.org/licenses/mit-license.html))
* Iconography by [Font Awesome](http://fortawesome.github.io/Font-Awesome/) ([MIT](https://opensource.org/licenses/mit-license.html))
* HTML5 compatibility amplified by [HTML5 Shiv](https://github.com/aFarkas/html5shiv) ([MIT](https://opensource.org/licenses/mit-license.html) / [GPL2](http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html) dual licensed)
* Development augmented by [Grunt](http://gruntjs.com/)
* Package management by [Bower](http://bower.io/)

## Contributers

There have been no direct third-party contributions to Pacific. It's parent theme, Flat, received many contributions; Pacific, of course, benefits from them, and you are encouraged to appreciate the contributors highlighted at [Flat](https://github.com/Codeinwp/flat)'s project page.

## Theme development

Pacific uses [Grunt](http://gruntjs.com/) for compiling LESS to CSS, checking for JS errors, live reloading, concatenating and minifying files.

Add the following to your `wp-config.php` on your development installation:

```php
define('WP_ENV', 'development');
```

### Install Grunt

**Unfamiliar with npm? Don't have node installed?** [Download and install node.js](http://nodejs.org/download/) before proceeding.

From the command line:

1. Install `grunt-cli` globally with `npm install -g grunt-cli`.
2. Navigate to the theme directory, then run `npm install`. npm will look at `package.json` and automatically install the necessary dependencies. It will also automatically run `bower install`, which installs front-end packages defined in `bower.json`.

When completed, you'll be able to run the various Grunt commands provided from the command line.

### Available Grunt commands

* `grunt dev` — Compile LESS to CSS, concatenate and validate JS
* `grunt watch` — Compile assets when file changes are made
* `grunt build` — Create minified assets, then export theme package

## Customization

Pacific is able to be customized extensively by the [WordPress hooks and filters API](http://codex.wordpress.org/Plugin_API), which is a fancy way of saying that without creating a child theme, you have the freedom to add, remove, and change a lot of what makes Pacific what it is. In addition to the default hooks and filters that just about any WordPress theme has available, Pacific is equipped with the following:

### Available hooks

* `pacific_html_before`
* `pacific_head_top`
* `pacific_head_bottom`
* `pacific_body_top`
* `pacific_body_bottom`
* `pacific_header_before`
* `pacific_header_after`
* `pacific_header_top`
* `pacific_header_bottom`
* `pacific_content_before`
* `pacific_content_after`
* `pacific_content_top`
* `pacific_content_bottom`
* `pacific_entry_before`
* `pacific_entry_after`
* `pacific_entry_top`
* `pacific_entry_bottom`
* `pacific_page_before`
* `pacific_page_after`
* `pacific_page_top`
* `pacific_page_bottom`
* `pacific_index_before`
* `pacific_index_after`
* `pacific_index_top`
* `pacific_index_bottom`
* `pacific_archive_before`
* `pacific_archive_after`
* `pacific_archive_top`
* `pacific_archive_bottom`
* `pacific_search_before`
* `pacific_search_after`
* `pacific_search_top`
* `pacific_search_bottom`
* `pacific_comments_before`
* `pacific_comments_after`
* `pacific_comments_top`
* `pacific_comments_bottom`
* `pacific_comment_author`
* `pacific_comment_metadata`
* `pacific_sidebar_before`
* `pacific_sidebar_after`
* `pacific_sidebar_top`
* `pacific_sidebar_bottom`
* `pacific_404_content`
* `pacific_footer_before`
* `pacific_footer_after`
* `pacific_footer_top`
* `pacific_footer_bottom`
* BONUS! All [Theme Hook Alliance](https://github.com/zamoose/themehookalliance) hooks are included!

### Available filters

* `pacific_404_title` — (string) The title of the 404 error page
* `pacific_comment_form_parameters` — (array) Parameters passed to `comment_form()` for customizing the comment form
* `pacific_list_comments_parameters` — (array) Parameters passed to `wp_list_comments()` for customizing comments display
* `pacific_moderation_notice` – (string) Message given to users when their comment is held for moderation
* `pacific_show_footer` — (boolean) Whether to show the `footer` block or not