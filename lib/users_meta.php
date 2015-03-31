<?php
//http://yoast.com/user-contact-fields-wordpress/
function italystrap_add_social_contactmethod( $contactmethods ) {
  // Add Avatar
  if ( !isset( $contactmethods['avatar'] ) )
	$contactmethods['avatar'] = 'Url avatar' ; 
  // Add Skype
  if ( !isset( $contactmethods['skype'] ) )
	$contactmethods['skype'] = 'Skype' ; 
  // Add Twitter
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = 'Twitter';
	// Add Google Profiles
  if ( !isset( $contactmethods['google_profile'] ) )
	$contactmethods['google_profile'] = 'Google Profile URL';
	// Add Google Page
  if ( !isset( $contactmethods['google_page'] ) )
	$contactmethods['google_page'] = 'Google Page URL';
	// Add Facebook Profile
  if ( !isset( $contactmethods['fb_profile'] ) )
	$contactmethods['fb_profile'] = 'Facebook Profile URL';
	// Add Facebook Page
  if ( !isset( $contactmethods['fb_page'] ) )
	$contactmethods['fb_page'] = 'Facebook Page URL';
	// Add LinkedIn
  if ( !isset( $contactmethods['linkedIn'] ) )
	$contactmethods['linkedIn'] = 'LinkedIn';
	// Add Pinterest
  if ( !isset( $contactmethods['pinterest'] ) )
	$contactmethods['pinterest'] = 'Pinterest';
	// Add Instagram
  //if ( !isset( $contactmethods['instagram'] ) )
	//$contactmethods['instagram'] = 'Instagram';

  // Remove Yahoo IM
  if ( isset( $contactmethods['yim'] ) )
    unset( $contactmethods['yim'] );
  // Remove jabber/Google Talk
  if ( isset( $contactmethods['jabber'] ) )	
	unset( $contactmethods['jabber'] );
  // Remove AIM
  if ( isset( $contactmethods['aim'] ) )		
	unset( $contactmethods['aim'] );

  return $contactmethods;
}
add_filter( 'user_contactmethods', 'italystrap_add_social_contactmethod', 10, 1 );