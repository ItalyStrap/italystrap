=== ItalyStrap ===
Contributors: overclokk
Donate link: https://italystrap.com
Tags: breadcrumbs, breadcrumb, seo, performance, schema.org, rich snippet, bootstrap, twitter bootstrap, css, responsive-layout, custom-menu, editor-style, featured-images, flexible-header, post-formats, sticky-post, translation-ready, blog, design, journal, lifestream, tumblelog, bright, clean, colorful, geometric, modern, playful, simple, whimsical, vibrant
Requires at least: 5.0
Tested up to: 5.2
Stable tag: 4.0.0-beta.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Make your web site more powerfull.

== Description ==

**This is a complete rebuild of the theme, it is a breaking changes, always do a backup first**

= Docs coming soon =

**[ItalyStrap WordPress Theme Framework](https://italystrap.com)** will add powerful features to your WordPRess site.

ItalyStrap is a WordPress framework theme based on [HTML5 Boilerplate](http://html5boilerplate.com/), [Bootstrap](http://getbootstrap.com/), [Schema.org](https://schema.org/), [Open Graph](https://developers.facebook.com/docs/opengraph/), [Twitter cards](https://dev.twitter.com/docs/cards)

[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

**Features include:**

* WPO Friendly
* SEO Friendly
* HTML5 Bolierplate
* CSS3
* Twitter Bootstrap 3
* Schema.org
* **Breadcrumbs.**

== Installation ==

First of all you have to install the core plugin [Advanced Control Manager](https://wordpress.org/plugins/advanced-control-manager/)

Clone the git repo of the theme:

`git clone git://github.com/ItalyStrap/italystrap.git`

`cd italystrap`

Install composer dependencies:

`composer install --no-dev`

or [download the zip file](https://github.com/ItalyStrap/italystrap/releases/latest), unzip it, place it in your folder themes `/wp-content/themes/` directory and activate it via Admin > Appearance > Themes

Then [download the child cheme](https://github.com/ItalyStrap/ItalyStrap-child/archive/master.zip) and use it for your customizations.

== How to migrate from older version of 4.0.0 ==

Remember! This is a full refactoring of the theme, consider it like a new theme, if you have the old version you have to do a migration to the new version.

**Do always a backup first**

= In file functions.php add this constant =
```define( 'ITALYSTRAP_CHILD_PATH', get_stylesheet_directory_uri() );```

= In file script.php =
Change all $pathchild variable to ITALYSTRAP_CHILD_PATH constant

= Deprecated Class =
wp_bootstrap_navwalker is deprecated, use Bootstrap_Navwalker instead


== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

= 4.0.0-beta.5 =

Release Date: Feb 5th, 2019

(Dev time 2 years)

**This is a complete rebuild of the theme, it is a breaking changes, always do a backup first**

* Better support for loading the framework with child theme
* Improvements of the botstrapping of the framework
* New API for MCE button
* New API for View in beta
* New filter for title tag `italystrap_entry_title_tag`
* Now breadcrumbs are echoed with hook `do_breadcrumbs`
* Refactoring of some classes
* Fixed some issue
* Added theme support for breadcrumbs
* Added theme support for Gutenberg
* Support for custom 404 page
* Improved assets structure
* Added navbar option for logo on mobile
* Almost compatible with theme check
* Autodefinitions of the theme constants
* CSS for editor is now loaded with the init class
* Added style for gutenberg editor
* Example for Injector
* Example in full-width.php for changing thumbnail size
* Maybe use the EDD to update the theme

= 4.0.0-beta.4 =

Release Date: July 1st, 2017

(Dev time 3 month)

**This is a complete rebuild of the theme, it is a breaking changes, always do a backup first**

* New template files structure
* Improved classes file structure
* Improved classes autoload
* Better theme_supports autoload
* Added new image size
* Removed Github Updater dependency
* Removed old template parts
* Removed vendor dir from repo
* Fixed image in 404.php
* Updated plugin requirements

= 4.0.0-beta.1|2|3 =

Release Date: April 18th, 2017

(Dev time 2 year)

**This is a complete rebuild of the theme, it is a breaking changes, always do a backup first**

* Deprecated class `ItalyStrapBreadcrumbs()`. The breadcrumbs functionality is moved to the plugin.
* Added [AnonymizeIP](https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#anonymizeIp) for cookie law
* Fixed regex in italystrap_embed_wrap cleanup.php
* [Fixed Warning: Illegal string offset](https://github.com/ItalyStrap/ItalyStrap/commit/4c2e4f9afc48e123dbebfa85509774d155b6adf8)
* Fixed do_action hook name in comments.php
* Added new class for sidebars and made dynamic the footer's sidebars
* Deprecated breadcrumbs.php and sidebar.php
* Deprecated file sitemap-html.php
* Deprecated file globals.php
* Deprecated file init.php
* Deprecated function get_html_tag_attr()
* Now the index.php is only a simple loop, [more info](https://developer.wordpress.org/themes/basics/template-hierarchy/)
* Added Theme customizer (with: logo image, custom image, 404 image, custom css, analytics ID)
* Added support to [custom-header](https://codex.wordpress.org/Custom_Headers)
* Added support to [custom-background](https://codex.wordpress.org/Custom_Backgrounds)
* Improved performance with new constant for home url `HOME_URL`, blog name `GET_BLOGINFO_NAME`, and blog description `GET_BLOGINFO_DESCRIPTION`, use it with `esc_attr()` and `echo`
* Added new hooks in template files
* Moved breadcrumbs functions to hook
* Added new Author info file
* Page template HTML sitemaps and Blog moved to child theme
* Added namespace PHP 5.3 to all files
* wp_bootstrap_navwalker is deprecated, use Bootstrap_Navwalker instead
* PSR-4 ready
* New layout API
* Better selection of nabar brand image or name
* Added Upgrade Class API
* New Router API
* New Customizer API
* New files template structure


= 3.0.5 =
Release Date: May 8th, 2015

(Dev time 2h)

* Move image.php in core directory
* Add some file for future develope
* Update TGM to 2.4.2
* Fix some error

= 3.0.4 =
Release Date: April 30th, 2015

(Dev time 3h)

* Delete custom style example
* Add custom jQuery in home for table, select box
* Fix register_sidebar error

= 3.0.3 =
Release Date: April 22th, 2015

(Dev time 5h)

* Edit hr HTML tag in loop
* Add new function to echo 404 image
* Fix XSS vulnerability in Custom Walker nav menu
* Update TGM class due to XSS vulnerability

= 3.0.2 =
Release Date: April 12th, 2015

(Dev time 1h)

* Fix some issue
* Change class in reply button and edit button (comments.php)

= 3.0.1 =
Release Date: April 12th, 2015

(Dev time 1h)

* Fix variable error

= 3.0.0 =
Release Date: April 8th, 2015

(Dev time 200h)

* Update to Bootstrap 3.3.4
* Update to jQuery 2.3.1
* Add [Mobile Detect Library](http://mobiledetect.net)
* Fix missing ul in comment template
* Fix gruntfile syntax
* Add grunt task for update bower dependency
* Update node modules
* Add grunt tasks for update bower packages
* Improved functions in comment_reply.php
* Add span clearfix to pagination function
* Fix comments paragraph break
* Improved italystrap_open_graph_desc() and italystrap_ttr_wc() in schema.php
* Add italystrap_get_words_count()
* Add class for adding glyphicon in new menu item
* Add markup for Sitelinks Search Box in searchform.php
* @see link below for more informations
* @link https://developers.google.com/structured-data/slsb-overview
* Add width:100% to table in sass files
* Add Bootstrap class to table calendar with jQuery
* Add flush_rewrite_rules(); for CPT
* Add new CPT description
* Update file structure
* Gallery deactivated for more future improvements
* Fix some issue
* Add new admin panel for Theme options


= 2.1.0 =
Release Date: 31-01-2015

(Dev time 50h)

* Add dev time
* Add ITALYSTRAP_THEME constant for internal use
* Fix for deprecated function WordPress SEO by Yoast
* Add external loop files for DRY don't repeat yourself (single, page, full-width, archive.php. search.php and blog.php)
* Fix error Schema.org markup for wordcount in archive page
* Add lang attribute for HTML tag lang
* Fix navbar display
* Add new class for BreadCrumbs in case the ItalyStrap plugin is not active
* Deprecated old Breadcrumbs function "create_breadcrumbs"
* Improved script for debug
* Add init.php for after_setup_theme and $content_width
* Add content for readme.txt
* Some improvements

= 2.0.0 =
Release Date:

(Dev time 100h)

* Add fully translations in Italian, English, French, German
* Fix php error in search.php (the_ID() outside the loop)
* Add author name in breadcrumbs author page
* Add  get_option('date_format') in meta.php
* Add description in meta.php
* Add carousel-indicators in index.php
* Fix margin in gallery img class
* Modify Favicon function for child theme or partent theme
* Fix issue category icon viewed even if the content is not in category (meta.php)
* Add custom.js file in js/src directory
* Move home.js in js/src
* Add CSS stile for dropdown category in custom.js
* Fix $content_width issue
* Fix echo current page in CPT for Facebook open graph
* Add is_preview() in single.php, page,php and footer.php (for footer only for analytics) (@link http://www.hongkiat.com/blog/wordpress-preview-mode/)
* Update Bootstrap to 3.3.1
* Improve load JS and CSS on hierarchy of page
* Some fix and improvement
* Change license from MIT to GPLv2

= 1.9.2 =
Release Date:

(Dev time 10h)

* Add new function for reveal hidden tinymce buttons (styleselect) in new file custom_shortcode.php
* Add button for insert <!--nextpage--> quicktag in the editor
* Retrieve number $posts_per_page from wp backend configuration for blog.php template
* Add rel canonical if SEO Yoast and AIOSP are not installed (cleanup.php)
* Add rel next and prev for paginations (cleanup.php)

= 1.9.1 =
Release Date:

(Dev time 7h)

* Fix issue in index.php for no content in CPT Prodotti
* Add rel="nofollow" and button class to comment_reply_link() filter
* Add CSS style img-rounded for all author image

= 1.9.0 =
Release Date:

(Dev time 15h)

* Add TGM-Plugin-Activation for require plugin
* Fix object error in breadcrumbs.php
* Add function for adding custom CSS class in get_avatar (Added in comments.php, author.php and author-meta.php)
* Add function for retrieve avatar url
* Improve if statement in author.php


= 1.8.7 =
Release Date:

(Dev time 15h)

* Add commented line in custom-post-type.php
* Fix display description for CPT in Archive page archive.php line 34, now display description for all custom post without type slug
* Fix ID's name for author.php (chage in author-page)
* Add <?php create_breadcrumbs() ?> to search.php
* Improve breacrumb.php, now show custom_post_type name
* Improve Read more link in excerpt function (custom_excerpt.php)
* Fix domain name in single.php

= 1.8.6 =
Release Date:

(Dev time 10h)

* Change loop in file blog.php, now pagination and excerpt works well
* Add CSS Style for css class in standard WordPress
* Fix category view in meta.php
* Fix display post in index.php when there is a sticky post
* Add img-responsive in wp-caption (cleanup.php)
* Removes img-rounded in add image class image.php

= 1.8.5 =
Release Date:

(Dev time 10h)

* Add my name in licence.md
* Add support array with all supports in custom-post-type.php
* Add daschicon in custom post icon
* Add ID to section tag on 404.php, archive.php, author.php, blog.php, ful-width.php, page.php, search.php, single.php, sitemap-html.php
* New file and code for Entry Meta
* Remove img-rounded class and add center-block instead

= 1.8.4 =
Release Date:

(Dev time 10h)

* New description README.md
* Fix issue in archive.php
* Add new function for post/page password protection
* Improve italystrap_add_style_and_script function

= 1.8.3 =
Release Date:

(Dev time 2h)

* Fix issue "Header already sent"
* Add description echo for custom post type inside a bootstrap's alert

= 1.8.2 =
Release Date:

(Dev time 3h)

* Fix some issue in file comments.php (comment-reply.js)

= 1.8.1 =
Release Date:

(Dev time 15h)

* Add File readme.txt (Correct theme check issue)
* Renamed file social-button.php in social-button.bak (I will develope soon)
* Add wp standard class in style.css (Correct theme check issue)
* Add wp_link_pages() for pagineted post (Correct theme check issue)
* Replaced bloginfo('url') with echo home_url() (Correct theme check issue)
* Add post_class in search.php file (Correct theme check issue)
* Fix variable issue in widget.php (Correct theme check issue)
* Replaced bloginfo( 'wpurl' ) with echo site_url() in facebook_opengraph (Correct theme check issue)
* Add textdomain in comment-replay.php (Correct theme check issue)
* Modified Root function for new bootstrap class for video
* Replaced get_option('home') with home_url() in breadcrumbs.php (Correct theme check issue)
* Add has_post_format custom function in index.php (Correct theme check issue)
* Add $content_width in functions.php (Correct theme check issue)
* Fix theme check issue in footer.php
* Add pagination to comments.php

= 1.8.0 =
Release Date:

(Dev time 3h)

* Update Botstrap to 3.2.0
* Update Gruntfile for build bootstrap js and css after update

= 1.7.3 =
Release Date:

(Dev time 2h)

* Add conditional tag for view version only in parent theme

= 1.7.2 =
Release Date:

(Dev time 3h)

* Add post_type_archive_title() in archive.php
* Add changelog to file Readme.md

= 1.7.1 =
Release Date:

(Dev time 5h)

* Update navwalker to 2.0.4 and add itemprop= to menù
* Built with grunt the javascript task runner

= 1.6.3 =
Release Date:

(Dev time 5h)

* Add less file
* Add file with function in lib
* Fix some bug

= 1.6.2 =
Release Date:

(Dev time 2h)

* Fix some bug

= 1.6.1 =
Release Date:

(Dev time 2h)

* Fix some bug

= 1.6.0 =
Release Date:

(Dev time 3h)

* Update to Bootstrap 3.1.1

= 1.5.7 =
Release Date:

(Dev time 2h)

* Add css class to wrapper all html

= 1.5.6 =
Release Date:

(Dev time 3h)

* Fix Warning:Cannot modify header information

= 1.5.5 =
Release Date:

(Dev time 2h)

* Migliorata la gestione degli script e degli stili, aggunto CDN fallback

= 1.5.4 =
Release Date:

(Dev time 2h)

* Aggiunte funzionalità di roots

= 1.5.3 =
Release Date:

(Dev time 3h)

* Migliorata la gestione delle slide in home

= 1.5.1 =
Release Date:

(Dev time 2h)

* Corretto problema stile thumb quando non presenti

= 1.5.0 =
Release Date:

(Dev time 2h)

* Aggiunto layout per la Sitemap HTML

= 1.4.1 =
Release Date:

(Dev time 1h)

* Sostituita classe alle immagini (thumbnail * img-rounded)

= 1.4.0 =
Release Date:

(Dev time 2h)

* Aggiornato a Bootstrap 3

= 1.3.3 =
Release Date:

(Dev time 2h)

* Separato gli script del file function in un file esterno e commentato riga menu_icon dei custom post type

= 1.3.2 =
Release Date:

(Dev time 2h)

* Corretto il tag HTML

= 1.3.1 =
Release Date:

(Dev time 2h)

* Aggiunto script per lo slider in home, ora parte in automatico

= 1.3.0 =
Release Date:

(Dev time 2h)

* Aggiunto htacces HTML5 Boilerplate

= 1.2.0 =
Release Date:

(Dev time 10h)

* Corretti bug e aggiunta classe css img-polaroid come classe default al caricamento di immagini
* Aggiunto codice per i post correlati

= 1.1.1 =
Release Date:

(Dev time 5h)

* Migliorata la gestione della description di open graph e twitter card

= 1.1.0 =
Release Date:

(Dev time 10h)

* Aggiunto le twitter cards

= 1.0.0 =
Release Date:

(Dev time 200h)

* Rilasciata la versione Beta 1.0.0

== Translations ==
 
* English: default, always included.
* Italian: Italiano, sempre incluso.
* German: Deutsch - immer dabei!
* French: Français, toujours inclus.
 
*Note:* This plugins is localized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating I recommend the awesome ["Codestyling Localization" plugin](http://wordpress.org/extend/plugins/codestyling-localization/) and for validating the ["Poedit Editor"](http://www.poedit.net/).
 
== Additional Info ==
**Idea Behind / Philosophy:** A theme for improve and add some powerful improvement to your site. I'll try to add more feautures if it makes some sense. So stay tuned :).
 
== Credits ==


[![Analytics](https://ga-beacon.appspot.com/UA-75347190-2/readme)](https://github.com/igrigorik/ga-beacon)