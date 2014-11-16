# [ItalyStrap Theme](http://www.overclokk.net/italystrap-wordpress-starter-theme)

ItalyStrap is a Wordpress starter theme based on [HTML5 Boilerplate](http://html5boilerplate.com/), [Bootstrap](http://getbootstrap.com/), [Schema.org](http://schema.org/), [Open Graph](https://developers.facebook.com/docs/opengraph/), [Twitter cards](https://dev.twitter.com/docs/cards)

[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

## Installation

Clone the git repo

'''git clone git://github.com/overclokk/ItalyStrap.git'''

or [download it](https://github.com/overclokk/ItalyStrap/archive/master.zip) unzip and place it in your folder themes (/wp-content/themes/) directory and activate it via Admin - Appearance - Themes



## Configuration and Documentation

### English description coming soon :-)

http://www.overclokk.net/italystrap-wordpress-starter-theme


## Features

* HTML5 Bolierplate
* CSS3
* Twitter Bootstrap 3
* Schema.org
* Google Authorship
* Facebook opengraph
* Twitter cards
* SEO Friendly (che vuol dire tutto e niente :-))
* WPO Friendly ;-)
* E chi più ne ha più ne metta :-P

##Changelog

###1.9.3

+ Add fully translations in Italian, English, French, German
+ Fix php error in search.php (the_ID() outside the loop)
+ Add author name in breadcrumbs author page
+ Add  get_option('date_format') in meta.php
+ Add description in meta.php
+ Add carousel-indicators in index.php
+ Fix margin in gallery img class
+ Modify Favicon function for child theme or partent theme
+ Fix issue category icon viewed even if the content is not in category (meta.php)
+ Add custom.js file in js/src directory
+ Move home.js in js/src
+ Add CSS stile for dropdown category in custom.js
+ Fix $content_width issue
+ Fix echo current page in CPT for Facebook open graph
+ Add is_preview() in single.php, page,php and footer.php (for footer only for analytics) (@link http://www.hongkiat.com/blog/wordpress-preview-mode/)

###1.9.2

+ Add new function for reveal hidden tinymce buttons (styleselect) in new file custom_shortcode.php
+ Add button for insert <!--nextpage--> quicktag in the editor
+ Retrieve number $posts_per_page from wp backend configuration for blog.php template
+ Add rel canonical if SEO Yoast and AIOSP are not installed (cleanup.php)
+ Add rel next and prev for paginations (cleanup.php)

###1.9.1

+ Fix issue in index.php for no content in CPT Prodotti
+ Add rel="noffolow" and button class to comment_reply_link() filter
+ Add CSS style img-rounded for all author image

###1.9.0

+ Add TGM-Plugin-Activation for require plugin
+ Fix object error in breadcrumbs.php
+ Add function for adding custom CSS class in get_avatar (Added in comments.php, author.php and author-meta.php)
+ Add function for retrieve avatar url
+ Improve if statement in author.php


###1.8.7

+ Add commented line in custom-post-type.php
+ Fix display description for CPT in Archive page archive.php line 34, now display description for all custom post without type slug
+ Fix ID's name for author.php (chage in author-page)
+ Add <?php create_breadcrumbs() ?> to search.php
+ Improve breacrumb.php, now show custom_post_type name
+ Improve Read more link in excerpt function (custom_excerpt.php)
+ Fix domain name in single.php

###1.8.6

+ Change loop in file blog.php, now pagination and excerpt works well
+ Add CSS Style for css class in standard WordPress
+ Fix category view in meta.php
+ Fix display post in index.php when there is a sticky post
+ Add img-responsive in wp-caption (cleanup.php)
+ Removes img-rounded in add image class image.php

###1.8.5

+ Add my name in licence.md
+ Add support array with all supports in custom-post-type.php
+ Add daschicon in custom post icon
+ Add ID to section tag on 404.php, archive.php, author.php, blog.php, ful-width.php, page.php, search.php, single.php, sitemap-html.php
+ New file and code for Entry Meta
+ Remove img-rounded class and add center-block instead

###1.8.4

+ New description README.md
+ Fix issue in archive.php
+ Add new function for post/page password protection
+ Improve italystrap_add_style_and_script function

###1.8.3

+ Fix issue "Header already sent"
+ Add description echo for custom post type inside a bootstrap's alert

###1.8.2

+ Fix some issue in file comments.php (comment-reply.js)

###1.8.1

+ Add File readme.txt (Correct theme check issue)
+ Renamed file social-button.php in social-button.bak (I will develope soon)
+ Add wp standard class in style.css (Correct theme check issue)
+ Add wp_link_pages() for pagineted post (Correct theme check issue)
+ Replaced bloginfo('url') with echo home_url() (Correct theme check issue)
+ Add post_class in search.php file (Correct theme check issue)
+ Fix variable issue in widget.php (Correct theme check issue)
+ Replaced bloginfo( 'wpurl' ) with echo site_url() in facebook_opengraph (Correct theme check issue)
+ Add textdomain in comment-replay.php (Correct theme check issue)
+ Modified Root function for new bootstrap class for video
+ Replaced get_option('home') with home_url() in breadcrumbs.php (Correct theme check issue)
+ Add has_post_format custom function in index.php (Correct theme check issue)
+ Add $content_width in functions.php (Correct theme check issue)
+ Fix theme check issue in footer.php
+ Add pagination to comments.php

###1.8.0

+ Update Botstrap to 3.2.0
+ Update Gruntfile for build bootstrap js and css after update

###1.7.3

+ Add conditional tag for view version only in parent theme

###1.7.2

+ Add post_type_archive_title() in archive.php
+ Add changelog to file Readme.md

###1.7.1

+ Update navwalker to 2.0.4 and add itemprop= to menù
+ Built with grunt the javascript task runner

###1.6.3

+ Add less file
+ Add file with funtction in lib
+ Fix some bug

###1.6.2

+ Fix some bug

###1.6.1

+ Fix some bug

###1.6.0

+ Update to Bootstrap 3.1.1

###1.5.7

+ Add css class to wrapper all html

###1.5.6

+ Fix Warning:Cannot modify header information

###1.5.5

+ Migliorata la gestione degli script e degli stili, aggunto CDN fallback

###1.5.4

+ Aggiunte funzionalità di roots

###1.5.3

+ Migliorata la gestione delle slide in home

###1.5.1

+ Corretto problema stile thumb quando non presenti

###1.5.0

+ Aggiunto layout per la Sitemap HTML

###1.4.1

+ Sostituita classe alle immagini (thumbnail + img-rounded)

###1.4.0

+ Aggiornato a Bootstrap 3

###1.3.3

+ Separato gli script del file function in un file esterno e commentato riga menu_icon dei custom post type

###1.3.2

+ Corretto il tag HTML

###1.3.1

+ Aggiunto script per lo slider in home, ora parte in automatico

###1.3.0

+ Aggiunto htacces HTML5 Boilerplate

###1.2.0

+ Corretti bug e aggiunta classe css img-polaroid come classe default al caricamento di immagini
+ Aggiunto codice per i post correlati

###1.1.1

+ Migliorata la gestione della description di open graph e twitter card

###1.1.0

+ Aggiunto le twitter cards

###1.0.0

+ Rilasciata la versione Beta 1.0.0

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/overclokk/italystrap/trend.png)](https://bitdeli.com/free "Bitdeli Badge")