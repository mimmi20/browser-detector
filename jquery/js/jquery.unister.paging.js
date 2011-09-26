/**
 * jQuery Paging Plugin
 *
 * @author    Andreas Hoffmann <andreas.hoffmann@unister-gmbh.de>
 * @copyright 2007-2010 Unister GmbH
 * @version   SVN: $Id: jquery.unister.paging.js 4111 2010-11-18 17:38:16Z t.mueller $
 */

jQuery.fn.pager = function(Options) {
    
    //Standartkonfiguration
    var Config = {
            entrysPerPage:        10,
            eventNext:            null,
            eventPrev:            null,
            displayContainer:    null,
            fade:                false
    }
    
    //Standartkonfig ueberbuegeln
    if (Options) {
        jQuery.extend(Config, Options);
    }
    
    //Zahl der eintraege
    var entryCount    = 0;
    
    //Zahl der Seiten
    var pageCount     = 0;
    
    //Array mit Listeneintraegen
    var Entrys        = new Array();
    
    var Sender        = jQuery(this);
    var page        = 0;
    
    //Kill elements swap
    var KillElements = jQuery('.jq_killpaging');
    
    //Binde click an die Buttons
    if (Config.eventNext) {
        Config.eventNext.bind('click', function(){
            _paging_Next();
        });
        Config.eventPrev.bind('click', function(){
            _paging_Prev();
        });
    }
    
    //Eintraege ueber Seite ausblenden, array befuellen
    Sender.each(function(index){
        if (index >= Config.entrysPerPage) {
            //jQuery(this).hide();
        }
        Entrys.push(jQuery(this));
        entryCount++;
    });
    
    //Berechne Seitenzahl
    pageCount = (entryCount / Config.entrysPerPage);
    
    //Baue Seitennavigation
    if (Config.displayContainer && pageCount > 1) {
        for (var index = 0; index < pageCount; index++) {
            var block = jQuery('<div class="jqPagingBlock" style="float:left"/>');
            block.attr('ref', index);
            block.html(index + 1);
            block.bind('click', function(){ _paging_setPage( jQuery(this).attr('ref') ) });
            block.appendTo(Config.displayContainer);
        }
        
        //Erste activieren
        jQuery('.jqPagingBlock:first').addClass('jqPagingBlockActive');
    }
    
    //Vor-Zurueck-Buttons ausblenden
    if (Config.fade) {
        if (entryCount <= Config.entrysPerPage) {
            Config.eventNext.fadeTo('fast', 0.33);
        }
        Config.eventPrev.fadeTo('fast', 0.33);
    }
    
    /**
     * Seite zurueck
     */
    function _paging_Prev() {
        if (page > 0) {
            page--;
        }
        _paging_setPage(page);
    }
    
    /**
     * Seite vor
     */
    function _paging_Next() {
        if (page < ((entryCount / Config.entrysPerPage )-1)) {
            page++;
        }
        _paging_setPage(page);
    }
    
    /**
     * Seite setzen
     */
    function _paging_setPage(newPage) {
        page = parseInt(newPage);
        var rangeBegin    = page        * Config.entrysPerPage;
        var rangeEnd    = ((page +1)* Config.entrysPerPage)-1;
        _paging_Parse(rangeBegin, rangeEnd);
        
        //Update PagingButtons
        jQuery('.jqPagingBlock').each(function(){
            if (jQuery(this).html() == (page +1)) {
                jQuery(this).addClass('jqPagingBlockActive');
            } else {
                jQuery(this).removeClass('jqPagingBlockActive');
            }
        });
    }
    
    /**
     * Neue Seite anzeigen, alte verstecken
     */
    function _paging_Parse(rangeBegin, rangeEnd) {
        KillElements.hide();
        
        for (var index = 0; index < entryCount; index++) {
            var Entry = Entrys[index];
            if (index >= rangeBegin && index <= rangeEnd) {
                Entry.removeAttr('style');
            } else {
                Entry.css('display', 'none');
            }
        }
        
        if (page <= 0 && Config.fade) {
            Config.eventPrev.fadeTo('fast', 0.33);
        } else {
            Config.eventPrev.fadeTo('fast', 1);
        }
        if (page >= ((entryCount / Config.entrysPerPage )-1)) {
            Config.eventNext.fadeTo('fast', 0.33);
        } else {
            Config.eventNext.fadeTo('fast', 1);
        }
    }
        
}
