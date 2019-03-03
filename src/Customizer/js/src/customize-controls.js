/**
 * Hide or show a control if a setting has certain value.
 *
 * @link https://wordpress.stackexchange.com/a/211953/90337
 *
 * @param control_ID The control ID to hide or show.
 * @param setting_ID The setting ID.
 * @param keys        The key.
 */
// function italystrap_toggle_control( control_ID, setting_ID, key ) {
//     wp.customize.control( control_ID, function( control ) {
//         var setting = wp.customize( setting_ID );
//         control.active.set( key === setting.get() );
//         setting.bind( function( value ) {
//             control.active.set( key === value );
//         } );
//     } );
// }
function italystrap_toggle_control( control_ID, setting_ID, keys ) {
    wp.customize.control( control_ID, function( control ) {
        var setting = wp.customize( setting_ID );

        // console.log( setting.get());
        // console.log( setting.get('default'));
        // console.log( control );
        // console.log( control.setting.get() );

        control.active.set( keys.indexOf( setting.get() ) >= 0  );

        setting.bind( function( value ) {

            control.active.set( keys.indexOf( value ) >= 0 );
        } );
    } );
}

( function( $ ) {

    wp.customize.bind( 'ready', function () {

        /**
         * Hide or show the control for menu width
         */
        // italystrap_toggle_control(
        //     'italystrap_navbar[menus_width]',
        //     'navbar[nav_width]',
        //     'navbar[nav_width]',
        //     'none'
        // );
        italystrap_toggle_control(
            'italystrap_navbar[menus_width]',
            'navbar[nav_width]',
            ['none']
        );


        // italystrap_toggle_control(
        //     'italystrap_navbar[nav_width]',
        //     'navbar[position]',
        //     ['navbar-relative-top','navbar-static-top']
        // );
    } );
} )( jQuery );
