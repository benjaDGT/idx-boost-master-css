jQuery(document).ready(function($) {
	$('#dgt_extra_address-description').on('click', function(event) {
		event.preventDefault();
		var address = $('#dgt_extra_address').val();
		$.ajax({
			url: dgtCredential.ajaxUrl,
			type: 'POST',
			data:{address: address, action:'dgt_get_geocode_communities' },
			dataType: 'json',
			success: function( geocode ) {
				$('#dgt_extra_lat').val(geocode['lat']);
				$('#dgt_extra_lng').val(geocode['lng']);
				return false;
			}
		});
	});
});
