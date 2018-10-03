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