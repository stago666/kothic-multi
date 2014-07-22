/*

Author: Matt Mayers	http://mattmayers.com/
Update by Garou http://custom.simplemachines.org/mods/index.php?mod=1633

*/

function wowheadLinks(){

	$('.wowhead').each(function(){

		var el = $(this)

		$.ajax({

			type: "GET",

			url: el.attr('href'),

			dataType: "xml",

			success: function(data){

				el.attr('href',$('link',data).text())

				el.addClass('q'+$('quality',data).attr('id'))

				el.text('[' + $('name', data).text() + ']');

			}

		})

	})

}

$(document).ready(wowheadLinks)