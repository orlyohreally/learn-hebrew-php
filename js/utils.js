var utils = {}
utils.showNotif = function(notif, msg, type = 'success', t = 500) {
	$(notif).attr('class', 'alert alert-dismissible fade show');
	$(notif).html(msg);
	$(notif).addClass('alert-' + type);
	$(notif).css({'visibility': 'visible'});
	if(t > 0) {
		setTimeout(function(){
			$(notif).removeClass('alert-' + type).html('');
			$(notif).css({'visibility': 'hidden'});
		}, t);
	}
}
utils.deloader = function(obj) {
	$(obj).html($(obj).html().replace('<span class="fas fa-spinner fa-spin"></span>', ''));
}
utils.loader = function(obj) {
	utils.deloader(obj);
	$(obj).html("<span class='fas fa-spinner fa-spin'></span> " + $(obj).html());
}
utils.scrollerUp = function (el) {
	$(window).on('scroll', function() {
		if($(window).scrollTop() > 1000) {
			$(el).show();
		}
		else {
			$(el).hide();
		}
	});

	$(el).on('click', function(){
		$(document).scrollTop(0);
	})
}
utils.scrollerDown = function (el) {
	$(window).on('scroll', function() {
		if($(window).scrollTop() < $(window).height() - 1000) {
			$(el).show();
		}
		else {
			$(el).hide();
		}
	});

	$(el).on('click', function(){
		$(document).scrollTop($(window).height());
	})
}