/**
 * fbautocomplete jQuery plugin
 * version 1.0 
 *
 * Copyright (c) 2010 Igor Crevar <crewce@hotmail.com>
 *
 * Licensed under the MIT (MIT-LICENSE.txt) 
 *
 * Requires: jquery UI autocomplete plugin, jquery offcourse
 * Based on tutorial from Dan Wellman 
 * http://net.tutsplus.com/tutorials/javascript-ajax/how-to-use-the-jquery-ui-autocomplete-widget/
 * TODO: global functions are bad?
 **/
 
(function($) {
    $.fn.autocompletevarieties = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrial/autovarieties',
            title: 'Remove %s',
            useCache: true,
            formName: 'varieties[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };

    $.fn.autocompletevariablesmeasured = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrial/autovariablesmeasured',
            title: 'Remove %s',
            useCache: true,
            formName: 'variablesmeasured[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };

    $.fn.autocompleteusers = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrial/autousers',
            title: 'Remove %s',
            useCache: true,
            formName: 'users[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };

    $.fn.autocompleteweathervariablesmeasured = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrialsite/autocompleteweathervariablesmeasured',
            title: 'Remove %s',
            useCache: true,
            formName: 'weathervariablesmeasured[data]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };
    
    $.fn.autocompletecontactpersons = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrialsite/autocontactpersons',
            title: 'Remove %s',
            useCache: true,
            formName: 'contactpersons[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };
    
    $.fn.autocompletetrials = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrial/autotrials',
            title: 'Remove %s',
            useCache: true,
            formName: 'trials[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };
    
    $.fn.autocompletetrialgroups = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrialgroup/autotrialgroups',
            title: 'Remove %s',
            useCache: true,
            formName: 'trialgroups[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };
    
    $.fn.autocompleteweatherstations = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrialsite/autoweatherstations',
            title: 'Remove %s',
            useCache: true,
            formName: 'weatherstations[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };

    $.fn.autocompletegroups = function (options) {
        var defaultOptions = {
            minLength: 1,
            url: 'tbtrial/autogroups',
            title: 'Remove %s',
            useCache: true,
            formName: 'groups[user]',
            sendTitles: true,
            onChangeFunc: function($obj){ //$obj.css("top", 2);
            },
            onRemoveFunc: function($obj){
                //correct field position
                if( $obj.parent().find('span').length === 0 ) {
            //$obj.css("top", 0);
            }
            },
            onAlreadySelected: function($obj){},
            maxUsers: 0,
            onMaxSelectedFunc: function($obj){},
            selected: [],
            cache: {}
        };
        options = $.extend( true, defaultOptions, options);
        this.each(function(i){
            $(this).fbautocomplete = new $.fbautocomplete($(this), options );
        });
        return this;
    };
    
    $.fbautocomplete = function ($obj, options) { //constructor
        var $idObj = '#'+$obj.attr('id');
        var $parent = $obj.parent();
        $parent.addClass('fbautocomplete-main-div').addClass('ui-helper-clearfix');
        var selected = [];
        var lastXhr;
	  
        for (var i in options.selected){
            //be sure to use this only if sendTitles is true
            if ( typeof options.selected[i].title == 'undefined' ) continue;
            addNewSelected(options.selected[i].id, options.selected[i].title );
        }
        $obj.autocomplete({
            minLength: options.minLength,
            //
            source: function(request, response){
                var term = request.term;
                if ( options.useCache ) {
                    if ( term in options.cache ) {
                        response( $.map( options.cache[ term ], function( item ) {
                            return {
                                value: item.title,
                                label: item.title,
                                id: item.id
                            };
                        }));
                        return;
                    }
                }
                //pass request to server
                lastXhr = $.post( options.url, request, function(data,status, xhr){
                    data = eval('('+data+')' );
                    if ( options.useCache ){
                        options.cache[ term ] = data;
                    }
					
                    if ( lastXhr == xhr ){
                        //parse returned values
                        response( $.map( data, function( item ) {
                            return {
                                value: item.title,
                                label: item.title,
                                id: item.id
                            };
                        }));
                    }
                });
            },

            //define select handler
            select: function(e, ui) {
                addNewSelected(ui.item.id, ui.item.label);
                $obj.val("");
                //prevent ui updater to set input
                e.preventDefault();
            },

            //define change handler
            change: function(event, ui) {
                $obj.val("");
                options.onChangeFunc($obj);
            }
        });
	  
        //add live handler for clicks on remove links
        $(".remove-fbautocomplete", $parent.get(0) ).live("click", function(){
            //remove current friend
            $(this).parent().remove();
            var $input = $(this).parent().find('input.ids-fbautocomplete');
            if ($input.length)
                removeSelected($input.val());
            options.onRemoveFunc($obj);
        });
	
        //if user clicks on parent div input is selected
        $parent.click(function(){
            $obj.focus();
        });
	
        function addNewSelected(fId, fTitle){
            if ( isInSelected(fId) ){
                options.onAlreadySelected($obj);
                return false;
            }
            if ( isMaxSelected() ){
                options.onMaxSelectedFunc($obj);
                return false;
            }
            addToSelected(fId);
            var __title = options.title.replace( /%s/, fTitle );
		
            var $id_hidden = $('<input type="hidden" />').addClass("ids-fbautocomplete").attr('value', fId);
            var $span = $("<span>").text(fTitle).append($id_hidden);
            if ( options.sendTitles ){
                $span.append(
                    $('<input type="hidden" />').attr('value', fTitle).attr('name', options.formName+'[title][]')
                    );
                $id_hidden.attr('name', options.formName+'[id][]');
            }else{
                $id_hidden.attr('name', options.formName+'[]');
            }
		
            var $a = $("<a></a>").addClass("remove-fbautocomplete").attr({
                href: "#",
                title: __title
            }).text("x").appendTo($span);

            $span.insertBefore( $idObj );
            return true;
        }
	
        function posOfSelected(id){
            for (var i in selected){
                if ( selected[i] == id ){
                    return i;
                }
            }
            return -1;
        }
        function isMaxSelected(){
            return options.maxUsers > 0  && selected.length >= options.maxUsers;
        }
        function removeSelected(id){
            var pos = posOfSelected(id);
            if (pos != -1) selected.splice(pos,1);
        }
        function isInSelected(id){
            return posOfSelected(id) != -1;
        }
        function addToSelected(id){
            selected[selected.length] = id;
        }
    };
})(jQuery);

