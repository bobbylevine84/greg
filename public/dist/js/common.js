//alert('from common...');
function confirmAction(url, msg, lms) {
	url = typeof url !== 'undefined' ? url : '';
	msg = typeof msg !== 'undefined' ? msg : '';
	lms = typeof lms !== 'undefined' ? lms : 'working...';
	if(confirm(msg)) {
		//showLoader(lms);
		window.location.href = url;
	}
	else return false;
}

function act(url, msg) {
	msg = typeof msg !== 'undefined' ? msg : 'working...';
	//showLoader(msg);
	window.location.href = url;
}

function submitForm(frm) {
    var form = '#' + frm.attr('id');
    var url  = frm.attr('action');
    var data = frm.serialize();
    resetVErrors(form);
    //showActivity();
    $.post(url, data, function(data) {
    	fillMessages(data.payload);
		if(data.status == 'success') {
			showFormMsg('success');
			checkAndRedirect(form);
		}
		else showVErrors();
    });
}

function checkAndRedirect(f) {
	if (typeof(f)==='undefined' || typeof(f) == undefined ) f = '';
	else f = f + ' ';

	var el = $(f + 'input[name="redirectroute"]');

	if( typeof(el.val())==='undefined' || typeof(el.val()) == undefined ) {}
	else if(el.val() != '') window.location.href = el.val();

	// setTimeout(function() {
	// 	//alert(f);
	// 	var el = $('input[name="redirectroute"]');
	// 	if(el && el.val()!='') window.location.href = el.val();
 //    }, 7000);


}

function showVErrors(ac) {
	if (typeof(f)==='undefined') ac = true;

	$('.validation-error').show();

	showFormMsg('error', ac);
}

function fillMessages(m, f) {
	if (typeof(f)==='undefined') f = '';
	else f = f + ' ';
	$.each(m, function( i, v ) {
		var el = $(f + 'span[name="emsg-'+i+'"]');
		if(el) el.html(v);
	});
}

function resetVErrors(f) {
	if (typeof(f)==='undefined') f = '';
	else f = f + ' ';
   	$(f + '.validation-error').hide().html('');
   	$('.frm-msg').html('');
}

function autoclose() {
	setTimeout(function() {
    	$('.autoclose').slideUp('slow');
    }, 6000);
}

function showActivity(msg) {
	if (typeof(msg)==='undefined' || msg == undefined) msg = 'please wait...';
    $.blockUI({ 
    	message: '<h4 style="color:#fff;">' + msg + '</h4>',
    	//message: $('#bu-loader'),
    	css: {
	        border: 'none', 
	        padding: '15px', 
	        backgroundColor: '#000', 
	        '-webkit-border-radius': '10px', 
	        '-moz-border-radius': '10px', 
	        opacity: .8, 
	        color: '#fff'
	    }
	}); 
}

function resetActivity() {
	$.unblockUI;
}

function updateui(h, u) {
	var container = $('.content-' + h);
    showActivity();
    $.get(u, function(data) {
		container.html(data);
		resetActivity();
    });
}

// valid 'cl' values - error, warning, success, info
function showFormMsg(cl, ac) {
	if (typeof(f)==='undefined') ac = true;
	if (typeof(cl)==='undefined' || cl == undefined) cl = 'error';

	if($('span[name="emsg-frm-'+cl+'"]').html() != '') $('.msg-' + cl ).slideDown();
	if(ac) autoclose();
}

function markSortOrder() {

	var orb = $('#srchOBy').val();
	var otp = $('#srchOTp').val();

	var col = $('.orderable[data-field="' + orb + '"]');

	col.html(col.html() + ' <span class="pull-right fa fa-sort-alpha-' + otp + '"></span>');
}

jQuery(document).ready(function() {

    // Sidebar Menu Selection Option 1
    // var path = '{{{ Request::path() }}}';
    // var el = $('ul.nav a[href*="'+path+'"]');
    // el.parentsUntil('ul.nav', 'li').addClass('active');

    // Sidebar Menu Selection Option 2
    // var menu = '{{{ $menu }}}';
    // var el = $('div.custopmmenu li.' + menu);
    // //alert(el.size());
    // el.addClass('active');
    // el.parentsUntil('div.custopmmenu', 'li').addClass('active');


	$(document).ajaxStop($.unblockUI);

	autoclose();

	$('.orderable').click(function() {
		var fld = $(this).data('field');

		// judging order type
		var otp = $('#srchOTp').val();
		var orb = $('#srchOBy').val();
		if(orb == fld) otp = otp == 'asc' ? 'desc' : 'asc';
		else otp = 'asc';

		// assigning values to fields
		$('#srchOBy').val(fld);
		$('#srchOTp').val(otp);

		//alert(fld);
		$('#btnSearch').click();
	});

	if($('#srchOBy').length && $('#srchOTp').length) markSortOrder();

});
