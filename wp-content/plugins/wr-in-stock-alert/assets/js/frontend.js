/**
 * @version 1.0
 * @package WR_In_Stock_Alert
 * @author WooRockets Team <support@woorockets.com>
 * @copyright Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * Websites: http://www.woorockets.com
 */

jQuery( function( $ ) {
	$( document ).ready( function() {
		// If unsubscribed from receiving in stock alert, show message.
		if ( $( '#in-stock-alert' ).hasClass( 'unsubscribed' ) ) {
			$( '#in-stock-alert-form .message' ).removeClass( 'hidden' ).prev( '.form' ).addClass( 'hidden' );
			$( '#in-stock-alert' ).addClass( 'show' ).removeClass( 'unsubscribed' );
		}

		// If product type is variable, track variation selection.
		if ( wr_in_stock_alert.product_type == 'variable' && wr_in_stock_alert.out_of_stock != null ) {
			$( '.variations [data-attribute_name]' ).change( function() {
				for ( var id in wr_in_stock_alert.out_of_stock ) {
					var is_selected = true;

					$( '.variations [data-attribute_name]' ).each( function( i, e ) {
						if ( !wr_in_stock_alert.out_of_stock[ id ][ $( e ).attr( 'data-attribute_name' ) ] ) {
							is_selected = false;
						} else if ( wr_in_stock_alert.out_of_stock[ id ][ $( e ).attr( 'data-attribute_name' ) ] != $( e ).val() ) {
							is_selected = false;
						}
					} );

					if ( is_selected ) {
						// Update product ID.
						$( '#in-stock-alert-form input[name="product"]' ).val( id );

						// Show the link to subscribe to receive in stock alert.
						$( '#in-stock-alert-link' ).parent().removeClass( 'hidden' );

						break;
					}
				}

				if ( !is_selected ) {
					// Show the link to subscribe to receive in stock alert.
					$( '#in-stock-alert-link' ).parent().addClass( 'hidden' );
				}
			} );
		}

		// Setup subscribe action.
		$( '#in-stock-alert-link' ).click( function() {
			var name = $( '#in-stock-alert-form input[name="name"]' ), email = $( '#in-stock-alert-form input[name="email"]' );
			// Clear inputted data.
			name.length && name.val( '' );
			email.val( '' );

			// Hide previous message then show popup.
			$( '#in-stock-alert-form .message' ).addClass( 'hidden' ).prev( '.form' ).removeClass( 'hidden' );
			$( '#in-stock-alert' ).addClass( 'show' );
			$( 'body' ).addClass( 'in-stock-alert-mask' );

		} );

		// Setup popup handler.
		$( '#in-stock-alert-form .close' ).click( function() {
			$( '#in-stock-alert' ).removeClass( 'show' );
			$( 'body' ).removeClass( 'in-stock-alert-mask' );
		} );

		// Setup form submission.
		$( '#in-stock-alert-form form[action]' ).submit( function( event ) {
			event.preventDefault();

			// Make sure both name and email fields are filled.
			var name = $( this ).find( 'input[name="name"]' ), email = $( this ).find( 'input[name="email"]' );

			// Disable input fields then show processing icon.
			name.length && name.attr( 'disabled', 'disabled' );
			email.attr( 'disabled', 'disabled' );
			$( this ).find( 'button' ).addClass( 'hidden' ).next().removeClass( 'hidden' );

			// Send Ajax request to store subscription.
			$.ajax( {
			    url: $( '#in-stock-alert-form form' ).attr( 'action' ),
			    data: {
			        name: name.length ? name.val() : '',
			        email: email.val(),
			        product: $( '#in-stock-alert-form input[name="product"]' ).val(),
			        timezone: ( new Date ).getTimezoneOffset(),
			    },
			    type: 'POST',
			    dataType: 'json',
			    context: this,
			    complete: function( response ) {
				    // Hide form, show message.
				    $( this ).parent().addClass( 'hidden' ).next( '.message' ).removeClass( 'hidden' );

				    // Set message.
				    var msg = $( this ).parent().addClass( 'hidden' ).next( '.message' ).children( '.message-content' );

				    if ( response && response.responseJSON && response.responseJSON.data ) {
					    msg.html( response.responseJSON.data );
				    } else {
					    msg.text( wr_in_stock_alert.server_error );
				    }

				    // Enable input fields then hide processing icon.
				    name.length && name.removeAttr( 'disabled' );
				    email.removeAttr( 'disabled' );
				    $( this ).find( 'button' ).removeClass( 'hidden' ).next().addClass( 'hidden' );
			    },
			} );
		} );
	} );
} );
