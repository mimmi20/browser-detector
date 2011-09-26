/*!
 * postMessage - v0.4 - 8/23/2009
 * http://benalman.com/
 * 
 * Copyright (c) 2009 "Cowboy" Ben Alman
 * Licensed under the MIT license
 * http://benalman.com/about/license/
 */

// Script: postMessage
//
// Version: 0.4, Date: 8/23/2009
// 
// Tested with jQuery 1.3.2 in Internet Explorer 6-8, Firefox 3, Safari 3-4,
// Chrome, Opera 9.
// 
// Home       - http://benalman.com/projects/jquery-postmessage-plugin/
// Source     - http://benalman.com/code/javascript/jquery/jquery.ba-postmessage.js
// (Minified) - http://benalman.com/code/javascript/jquery/jquery.ba-postmessage.min.js (0.9kb)
// Example    - http://benalman.com/code/test/js-jquery-postmessage/
// 
// 
// About: License
// 
// Copyright (c) 2009 "Cowboy" Ben Alman
// 
// Licensed under the MIT license
// 
// http://benalman.com/about/license/
// 
// Topic: What this plugin does
// 
// With the addition of the window.postMessage method, JavaScript finally has a
// fantastic means for cross-domain frame communication. Unfortunately, this
// method isn't supported in all browsers. This jQuery plugin enables simple and
// easy window.postMessage communication in browsers that support it (FF3,
// Safari 4, IE8), while falling back to a document.location.hash communication
// method for all other browsers (IE6, IE7, Opera). One example where this is
// useful is when a child Iframe needs to tell its parent that its contents have
// resized.

(function($){
  '$:nomunge'; // Used by YUI compressor.
  
  // A few vars used in non-awesome browsers.
  var interval_id,
    last_hash,
    cache_bust = 1,
    
    // A var used in awesome browsers.
    rm_callback,
    
    // A few convenient shortcuts.
    window = this,
    FALSE = !1,
    
    // Reused internal strings.
    postMessage = 'postMessage',
    addEventListener = 'addEventListener',
    
    p_receiveMessage,
    
    // I couldn't get window.postMessage to actually work in Opera 9.64!
    has_postMessage = window[postMessage] && !$.browser.opera;
  
  // Method: jQuery.postMessage
  // 
  // This method will call window.postMessage if available, setting the
  // targetOrigin parameter to the base of the target_url parameter for maximum
  // security in browsers that support it. If window.postMessage is not available,
  // the target window's location.hash will be used to pass the message. If an
  // object is passed as the message param, it will be serialized into a string
  // using the jQuery.param method.
  // 
  // Usage:
  // 
  //  jQuery.postMessage( message, target_url [, target ] );               - -
  // 
  // Arguments:
  // 
  //  message - (String or Object) The window.postMessage method only supports a
  //    string message, but if an object is passed it will be serialized using
  //    the jQuery.param method.
  //  target_url - (String) The URL of the other frame this window is
  //    attempting to communicate with. This must be the exact URL (including
  //    query string) of the other window for this script to work in browsers
  //    that don't support window.postMessage.
  //  target - (Object) A reference to the other frame this window is
  //    attempting to communicate with. If unspecified, defaults to parent.
  // 
  // Returns:
  // 
  //  Nothing.
  
  $[postMessage] = function( message, target_url, target ) {
    if ( !target_url ) { return; }
    
    // Serialize the message if not a string. Note that this is the only real
    // jQuery dependency for this script. If removed, this script could be
    // written as very basic JavaScript.
    message = typeof message === 'string' ? message : $.param( message );
    
    // Default to parent if unspecified.
    target = target || parent;
    
    if ( has_postMessage ) {
      // The browser supports window.postMessage, so call it with a targetOrigin
      // set appropriately, based on the target_url parameter.
      target[postMessage]( message, target_url.replace( /([^:]+:\/\/[^\/]+).*/, '$1' ) );
      
    } else if ( target_url ) {
      // The browser does not support window.postMessage, so set the location
      // of the target to target_url#message. A bit ugly, but it works! A cache
      // bust parameter is added to ensure that repeat messages get trigger
      // the callback.
      target.location = target_url.replace( /#.*$/, '' ) + '#' + (cache_bust++) + '&' + message;
    }
  };
  
  // Method: jQuery.receiveMessage
  // 
  // Register a single callback for either a window.postMessage call, if
  // supported, or if unsupported, for any change in the current window
  // location.hash. If window.postMessage is supported and source_origin is
  // specified, the source window will be checked against this for maximum
  // security. If window.postMessage is unsupported, a polling loop will be
  // started to watch for changes to the location.hash.
  // 
  // Note that for simplicity's sake, only a single callback can be registered
  // at one time. Passing no params will unbind this event (or stop the polling
  // loop), and calling this method a second time with another callback will
  // unbind the event (or stop the polling loop) first, before binding the new
  // callback.
  // 
  // Usage:
  // 
  //  jQuery.receiveMessage( callback [, source_origin ] [, delay ] );       - -
  // 
  // Arguments:
  // 
  //  callback - (Function) This callback will execute whenever a <jQuery.postMessage>
  //    message is received, provided the source_origin matches. If callback is
  //    omitted, any existing event bind or polling loop will be canceled.
  //  source_origin - (String or Function) If window.postMessage is available,
  //    this optional param will be used to test the event.origin property. If
  //    the param is a string, and is not equal to the event.origin property, or
  //    a function that returns false when passed the event.origin property, the
  //    callback will not be called. From the MDC window.postMessage docs:
  //    This string is the concatenation of the protocol and "://", the host
  //    name if one exists, and ":" followed by a port number if a port is
  //    present and differs from the default port for the given protocol.
  //    Examples of typical origins are https://example.org (implying port 443),
  //    http://example.net (implying port 80), and http://example.com:8080.
  //  delay - (Number) An optional zero-or-greater delay in milliseconds at
  //    which the polling loop will execute (for browser that don't support
  //    window.postMessage). If unspecified, defaults to 100.
  // 
  // Returns:
  // 
  //  Nothing!
  
  $.receiveMessage = p_receiveMessage = function( callback, source_origin, delay ) {
    if ( has_postMessage ) {
      // Since the browser supports window.postMessage, the callback will be
      // bound to the actual event associated with window.postMessage.
      
      if ( callback ) {
        // Unbind an existing callback if it exists.
        rm_callback && p_receiveMessage();
        
        // Bind the callback. A reference to the callback is stored for ease of
        // unbinding.
        rm_callback = function(e) {
          if ( ( typeof source_origin === 'string' && e.origin !== source_origin )
            || ( $.isFunction( source_origin ) && source_origin( e.origin ) === FALSE ) ) {
            return FALSE;
          }
          callback( e );
        };
      }
      
      if ( window[addEventListener] ) {
        window[ callback ? addEventListener : 'removeEventListener' ]( 'message', rm_callback, FALSE );
      } else {
        window[ callback ? 'attachEvent' : 'detachEvent' ]( 'onmessage', rm_callback );
      }
      
    } else {
      // Since the browser sucks, a polling loop will be started, and the
      // callback will be called whenever the location.hash changes.
      
      interval_id && clearInterval( interval_id );
      interval_id = null;
      
      if ( callback ) {
        delay = typeof source_origin === 'number'
          ? source_origin
          : typeof delay === 'number'
            ? delay
            : 100;
        
        interval_id = setInterval(function(){
          var hash = document.location.hash,
            re = /^#?\d+&/;
          if ( hash !== last_hash && re.test( hash ) ) {
            last_hash = hash;
            callback({ data: hash.replace( re, '' ) });
          }
        }, delay );
      }
    }
  };
  
})(jQuery);