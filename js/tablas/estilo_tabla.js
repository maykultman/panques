$(function(){

var options = {
	widthFixed : true,
	showProcessing: true,
	headerTemplate: '{content} {icon}', // Add icon for jui theme; new in v2.7!

	widgets: [ 'zebra', 'cssStickyHeaders', 'filter' ],

	widgetOptions: {
		filter_columnFilters   : false,
		cssStickyHeaders_offset        : 0,
		cssStickyHeaders_addCaption    : true,
		cssStickyHeaders_attachTo      : null,
		cssStickyHeaders_filteredToTop : true,
		cssStickyHeaders_zIndex        : 10
	}

};


/* make second table scroll within its wrapper */
options.widgetOptions.cssStickyHeaders_attachTo = '.wrapper' // or $('.wrapper')
// $("#table1").tablesorter(options);
// $("#tbla_cliente").tablesorter(options);
// $("#consulta_tablaservicio").tablesorter(options);

});

/*TODO LO QUE SIGUE FUE COMENTADO CUANDO SE REALIZABA LAS MODIFICACIONES EN EL MODULO DE PROYECTOS, POR GEYSER*/

// $(function() {

// 	var $table = $('table').tablesorter({
// 		theme: 'blue',
// 		widgets: ["zebra", "filter"],
// 		widgetOptions : {
// 			// use the filter_external option OR use bindSearch function (below)
// 			// to bind external filters.
// 			// filter_external : '.search',

// 			filter_columnFilters: false,
// 			filter_saveFilters : true,
// 			filter_reset: '.reset'
// 		}
// 	});

// 	// Target the $('.search') input using built in functioning
// 	// this binds to the search using "search" and "keyup"
// 	// Allows using filter_liveSearch or delayed search &
// 	// pressing escape to cancel the search
// 	$.tablesorter.filter.bindSearch( $table, $('.search') );

// 	// Basic search binding, alternate to the above
// 	// bind to search - pressing enter and clicking on "x" to clear (Webkit)
// 	// keyup allows dynamic searching
// 	/*
// 	$(".search").bind('search keyup', function (e) {
// 		$('table').trigger('search', [ [this.value] ]);
// 	});
// 	*/

// 	// Allow changing an input from one column (any column) to another
// 	$('select').change(function(){
// 		// modify the search input data-column value (swap "0" or "all in this demo)
// 		$('.selectable').attr( 'data-column', $(this).val() );
// 		// update external search inputs
// 		$.tablesorter.filter.bindSearch( $table, $('.search'), false );
// 	});

// });


