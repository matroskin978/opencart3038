const custom_cart = {
	'change': function(key, {target}) {
		this.update(key, Number(target.value.replace(/[^\d]/g, '')));
	},
	'update': function(key, quantity) {
		if (quantity < 1) quantity = 1;
		$.ajax({
			url: 'index.php?route=extension/module/custom/cart/update',
			type: 'post',
			data: 'key=' + key + '&quantity=' + quantity + '&event=update',
			dataType: 'json',
			beforeSend: function(){
				$('.alert').remove();
				$('[role="tooltip"]').remove();
			},
			success: function(json) {

				if (json['empty']){
					location.reload();
				}

				custom_block.render('cart');
				custom_block.render('total');
				custom_block.render('shipping');
				custom_block.render('payment');

				if (json['total']){
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}

				if (json['error']){

					json['error'].forEach(function(error){
						$('.breadcrumb').after('<div class="alert alert-warning">' + error + '</div>')
					});

				}

				$('#custom-cart [data-cart-id=' + key + ']').focus();

			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=extension/module/custom/cart/update',
			type: 'post',
			data: 'key=' + key + '&event=remove',
			dataType: 'json',
			beforeSend: function(){
				$('.alert').remove();
				$('[role="tooltip"]').remove();
			},
			success: function(json) {

				if (json['empty']){
					location.reload();
				}

				custom_block.render('cart');
				custom_block.render('total');
				custom_block.render('shipping');
				custom_block.render('payment');

				if (json['total']){
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}

				if (json['error']){
					json['error'].forEach(function(error){
						$('.breadcrumb').after('<div class="alert alert-warning">' + error + '</div>')
					});
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'clear': function () {
		$.ajax({
			url: 'index.php?route=extension/module/custom/cart/clear',
			type: 'post',
			dataType: 'json',
			beforeSend: function () {
				$('.alert').remove();
				$('[role="tooltip"]').remove();
			},
			success: function (json) {
				if (json['empty']) {
					location.reload();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}
