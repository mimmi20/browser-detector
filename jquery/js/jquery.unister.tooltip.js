/**
 * jQuery Tooltip Plugin
 * 
 * 
 * Ein einfaches Tooltip-Plugin fuer jQuery. Tooltip klebt automatisch am
 * Mouse Cursor und unterstuezt das nachladen der Inhalte ueber Ajax sowie
 * Delay, Offset, Fade(NYI), Width und Height Parameter.
 * 
 * Automatisch wird im IE6 ein IFrame hinter den Tooltip geklebt, um das durch-
 * scheinen von Selectelementen zu verhindern.
 * Eine routine verhindert das hinauslaufen des Tooltip ueber die
 * Browserraender.
 *
 * @author    Andreas Hoffmann <andreas.hoffmann@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: jquery.unister.tooltip.js 4111 2010-11-18 17:38:16Z t.mueller $
 */

/*  - HOWTO -
 * 
 *  [TOOLTIP_ELEMENT].tooltip( [AKTIVIERUNGS_ELEMENT], [OPTIONEN] );
 * 
 *  - VERWENDUNGSBEISPIELE -
 *  
 *  ----------------------------------------------------------------------------
 *  1.) Einen normalen, versteckten Div-Kontainer zum Tooltip befoerdern.
 *      Kontainer hat die ID 'tooltip_1'
 *      Activator hat die ID 'fragezeichen'
 *      Tooltip soll eine Breite von 400px und einen Delay von 200ms haben
 *  
 *  var Options = new Object();
 *  Options.width = 400;
 *  Options.delay = 200;
 *  jQuery('#tooltip_1').tooltip(
 *      jQuery('#fragezeichen'),
 *      Options
 *  );
 *  
 *  
 *  ----------------------------------------------------------------------------
 *  2.) Tooltio-Text soll ueber Ajax geladen werden. Der Kontainer fuer den Text
 *      wird dabei erst dynamisch erzeugt.
 *  
 *  jQuery('<div />').appendTo('body').tooltip(
 *      jQuery('#fragezeichen'),
 *      {    width:        400,
 *          remote:        "http://some.url/module/ctrl/action/..."
 *      }
 *  );
 *  
 * 
 * 
 */

jQuery.fn.tooltip = function( Activator, Options ) {

    /* Standartkonfiguration */
    var Config = {
            
            /**
             * Verzoegerung bis der Tooltip angezeigt wird.
             * Greift nur bei nicht-Remote aufrufen. 
             */
            delay:        '0',
            
            /**
             * Niedrigster Z-Index des Tooltip.
             */
            zindex:     990,
            
            /**
             * @TODO Wert greift noch nicht!
             * Wenn true, dann blendet der Tooltip langsam ein und aus
             */
            fade:        false,
            
            /**
             * Offset in Pixeln vom Mouse Pointer
             */
            offsetX:    10,
            offsetY:    10,
            
            /**
             * Remote (Ajax) Url
             * Wird hier eine URL gesetzt, laed sich der Inhalt des
             * Tooltip von dieser URL. Delay-Parameter wird ncihtig.
             */
            remote:        null,
            
            /**
             * Breite
             * Die Breite des Tooltip-Fensters. -1 fuer Auto
             */
            width:      -1,
            
            /**
             * Hiehe
             * Die Hoehe des Tooltip-Fensters. -1 fuer Auto
             */
            height:     -1,
            
            /**
             * Hintergrundfarbe
             * Falls nicht schon durch CSS-Parameter gesetzt
             */
            color:        '#FFF',
            
            /**
             * Bounding Box
             * Wenn gesetzt, versucht der Tooltip innerhalb dieses
             * Elements zu bleiben.
             */
            boundingBox:null,
            
            /**
             * AjaxLoader
             * Bild-Src was beim laden ueber Ajax angezeigt werden soll
             */
            ajaxLoader:    null
    }
    
    /* Timer im gesammten Plugin verfuegbar machen */
    var Timer = null;
    
    /* Status der Mause aus dem Element */
    var Status = false;
    
    /* Standartkonfiguration Ueberschreiben */
    if (Options) {
        jQuery.extend(Config, Options);
    }

    /* Tooltip-Element vorbereiten */
    var Sender = jQuery(this);
    Sender.each( function(){
        var tooltip = jQuery(this);

        /* Handler-Div (um den Tooltip ge-wrappt) */
        var handler = jQuery('<div />');
        handler.css('display',            'none')
               .css('position',            'absolute')
               .css('z-index',            Config.zindex)
               .css('top',                '0')
               .css('left',             '0')
               .css('background-color',    Config.color);
        
        /* Z-Index anpassen und tooltip in den Handler kleben */
        tooltip.css('z-index', parseInt(Config.zindex) + 2)
        tooltip.prependTo(handler);
        
        /* Breite/Hoehe */
        if (Config.width >= 0) {
            /* Breite erst bei show */
            /* handler.css('width', Config.width); */
        }
        if (Config.height >= 0) {
            handler.css('height', Config.height);
        }
        
        /*
         * Nachdem allen umgehaengt wurde, kann der Tooltip angezeigt werden.
         * Der Handler verhindert, das er sichtbar ist.
         */
        tooltip.css('display', 'block');
        
        /* Events binden */
        jQuery(Activator).each( function() {
            jQuery(this).mouseenter    ( function(event){ _tooltip_OnMouseEnter( event, jQuery(this), handler); } );
            jQuery(this).mousemove    ( function(event){ _tooltip_OnMouseMove ( event, jQuery(this), handler); } );
            jQuery(this).mouseout    ( function(event){ _tooltip_OnMouseLeave( event, jQuery(this), handler); } );
        });
        
        /* Handler(Tooltip) direkt an body kleben */
        handler.prependTo('body');
        
        /* IE6: iFrame mit in den Handler legen */
        if (jQuery.browser.msie && jQuery.browser.version == '6.0') {
            var iframe = jQuery('<iframe />');
            iframe.css('position',    'absolute')
                  .css('z-index',     -1)
                  .css('top',        '0')
                  .css('left',        '0')
                  .attr('border',     '0')
                  .attr('tab-index',-1)
                  .attr('src',window.location.protocol + '//kfzcalc.geld.de/refresh.gif');
            iframe.prependTo(handler);
        }
    } );
    
    /**
     * Event OnMouseEnter
     * @param Event
     * @param Activator
     * @Param Handler
     */
    function _tooltip_OnMouseEnter(Event, Activator, Handler) {
        /* Status setzen */
        Status = true;
        
        /* Wenn remote nicht null, content ueber Ajax holen */
        if (null != Config.remote) {
            /* Ajaxloader */
            if (Config.ajaxLoader) {
                Handler.css('width', 25);
                var loader = jQuery('<img />');
                loader.css('padding', '5px')
                      .attr('src', Config.ajaxLoader)
                      .attr('class', 'toolTipLoad')
                      .appendTo(Handler);
                _tooltip_Show(Event, Activator, Handler, true);
                _tooltip_updatePosition(Event, Activator, Handler);
            }
            jQuery.get(Config.remote, function(data) {
                /* Pruefen, ob Maus noch immer ueber dem Element ist */
                if (Status) {
                    Handler.children('div, img').remove();
                    jQuery('<div />').html(data).appendTo(Handler);
                    _tooltip_Show(Event, Activator, Handler);
                    _tooltip_updatePosition(Event, Activator, Handler);
                }
            });
        /* Anzeige mit Timeout */
        } else if (Config.delay > 0) {
            Timer = setTimeout( function(){
                _tooltip_Show(Event, Activator, Handler);
                _tooltip_updatePosition(Event, Activator, Handler);
            }, Config.delay );
        /* Kein Remote und kein Timeout: Sofort anzeigen */
        } else {
            _tooltip_Show(Event, Activator, Handler);
            _tooltip_updatePosition(Event, Activator, Handler);
        }
    }
    
    /**
     * Event OnMouseMove
     * @param Event
     * @param Activator
     * @Param Handler
     */
    function _tooltip_OnMouseMove(Event, Activator, Handler) {
        /* IE6: iFrame Groesse anpassen */
        _tooltip_updateIFrame(Event, Activator, Handler)
        
        /* Position update */
        _tooltip_updatePosition(Event, Activator, Handler);
    }
    
    /**
     * Event OnMouseLeave
     * @param Event
     * @param Activator
     * @Param Handler
     */
    function _tooltip_OnMouseLeave(Event, Activator, Handler) {
        /* Status setzen */
        Status = false;
        
        /* Clear Timeout wenn notwendig */
        if (null != Timer) {
            clearTimeout(Timer);
        }
        
        if (Config.remote) {
            Handler.children('div, img').remove();
        } else {
            Handler.children('img').remove();
        }
        
        /* Verstecke Handler */
        if (Config.fade) {
            /**
             * @TODO: Hier Fade einbauen!
             */
        } else {
            Handler.hide();
        }        
    }
    
    /**
     * Zeigt den Tooltip an
     * @param Event
     * @param Activator
     * @Param Handler
     */
    function _tooltip_Show(Event, Activator, Handler, excludeWidth) {
        /* Clear Timeout wenn notwendig */
        if (null != Timer) {
            clearTimeout(Timer);
        }
        
        /* Breite */
        if (!excludeWidth && Config.width > -1) {
            Handler.css('width', Config.width);
        }
        
        /* Anzeigen */
        if (Config.fade) {
            /**
             * @TODO: Hier Fade einbauen!
             */
        } else {
            Handler.show();
        }
        _tooltip_updateIFrame(Event, Activator, Handler)
    }
    
    /**
     * Position des Tooltip updaten
     * @param Event
     * @param Activator
     * @Param Handler
     */
    function _tooltip_updatePosition(Event, Activator, Handler) {
        var newX    = Event.pageX + Config.offsetX;
        var newY    = Event.pageY + Config.offsetY;
        var tooltip    = Handler.children('div');
        var wind    = jQuery(window);
        
        var ttBottom= newY + tooltip.height();
        var ttRight = newX + tooltip.width();
        
        /* Boundingbox abfangen */
        if (null != Config.boundingBox) {
            var bbBottom = Config.boundingBox.position().top + Config.boundingBox.offset().top + Config.boundingBox.height();
            var bbRight  = Config.boundingBox.position().left + Config.boundingBox.offset().left + Config.boundingBox.width();
            /* Unten */
            if ( ttBottom > bbBottom ) {
                newY = (bbBottom - tooltip.height());
            }
            /* Rechts */
            if ( ttRight > bbRight ) {
                newX = (bbRight - tooltip.width());
            }
            
        }
        
        /* Browserraender abfangen */
        /* Unten */
        if ( (newY + tooltip.height()) > (wind.height() + wind.scrollTop()) ) {
            newY = (wind.scrollTop() + wind.height()) - tooltip.height()-30;
        }
        // Rechts
        if ( (newX + tooltip.width()) > (wind.width() + wind.scrollLeft()) ) {
            newX = (wind.scrollLeft() + wind.width()) - tooltip.width();
        }
        
        /* Ist nach dem ganzen geschiebe der Tooltip ueber dem Cursor,
         * absolut positionieren, egal wo er dann haengt.*/
        if (Event.pageX > newX
        &&  Event.pageX < (newX + tooltip.width())
        &&  Event.pageY > newY
        &&  Event.pageY < (newY + tooltip.height())) {
            newX = Event.pageX - (tooltip.width() / 2);
            newY = Event.pageY - tooltip.outerHeight() -10;
        }
        
        /* Write! */
        Handler.css('left', newX)
               .css('top',  newY);        
    }
    
    /**
     * Update den iFrame !Nur IE6!
     * @param Event
     * @param Activator
     * @Param Handler
     */    
    function _tooltip_updateIFrame(Event, Activator, Handler) {
        if (jQuery.browser.msie && jQuery.browser.version == '6.0') {
            var tooltip    = Handler.children('div');
            var iframe    = Handler.children('iframe');
            iframe.attr('width',    tooltip.width() )
                    .attr('height',    tooltip.height() );
        }
    }
    
}