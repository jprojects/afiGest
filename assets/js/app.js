var domain   = location.origin+location.pathname;

function setCookie(c_name,value,exdays) {
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays===null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name) {
    var name = c_name + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name)===0) return c.substring(name.length,c.length);
    }
    return "";
}

function sendNotification(body, title) {
  	var options = {
      	body: body,
      	icon: domain+'/assets/img/logo.png'
  	}
  	var n = new Notification(title, options);
  	setTimeout(n.close.bind(n), 5000);
}

$(document).ready(function() {

  Messenger.options = {
      extraClasses: 'messenger-fixed messenger-on-top  messenger-on-right',
      theme: 'flat',
      messageDefaults: {
        showCloseButton: true
      }
  }

	// Comprobamos si el navegador soporta las notificaciones
  	if (!("Notification" in window)) {
    	console.log("Este navegador no soporta las notificaciones del sistema");
  	}
  	// Si no, tendremos que pedir permiso al usuario
  	else if (Notification.permission !== 'denied') {
		Notification.requestPermission(function (permission) {
			// Si el usuario acepta, lanzamos la notificación
		  	if (permission === "granted") {
		    	$.get(domain+"?view=home&task=checkMessages&mode=raw", function(data, status) {
		    		if(data > 0) {
						//sendNotification('', 'Tens '+data+' missatges per llegir');
					}
				});
		  	}
		});
  	}

	//tooltips
	$(".hasTip").tooltip();

	//colorpickers
	if ($('#color').length) {
		$('#color').colorpicker();
	}

	//save cookie with language
	$('.lang').click(function() {
		var lang = $(this).attr('data-lang');
		setCookie('language', lang, 10);
  });

  $('#readMessages').click(function(e) {
    e.preventDefault();
    $.get(domain+'?view=home&task=readMessages&mode=raw');
    $('.badge').html('0');
    $('.messages').empty();
    Messenger().post({message: "Eureka! no hi han més missatges", type: 'success', hideAfter: 10});
	});

  $('.readMessage').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var href = $(this).attr('href');
    $.get(domain+'?view=home&task=readMessages&mode=raw&id='+id);
    document.location.href = domain+href;
	});

  $('.saveandclose').click(function(e) {
    e.preventDefault();
    $('#sortir').val(1);
    $('.submit').click();
	});

	//select all checkbox
	$('#selectAll').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		checkboxes.prop('checked', $(this).is(':checked'));
	});

	//facture list
	$('.facturar').click(function(e) {

		e.preventDefault();
		var items = [];
		var view = $(this).attr('data-view');
		var pageURL = $(this).attr("href");
		var id = $(this).attr("data-id");

		if(!id){
			$(':checkbox').each(function() {
				if(this.checked) {
					var id    = $(this).attr('data-id');
					if(id != null) items.push(id);
				}
			});
		}else
			items.push(id);

		if(items == 0) { alert('Please check one item at least'); return false; } else { if(!confirm('Are you sure you want to billed this item?')) return false; }

		var list = JSON.stringify(items);

		$.ajax({
				url: pageURL,
				type: "post",
				datatype: 'json',
				data: {'items': list},
				success: function(data){
					Messenger().post({message: "Eureka! tot ha estat facturat", type: 'success', hideAfter: 10});
					setTimeout(function(){
						window.history.go(0);
					}, 1000);
				},
				error: function(data){
					Messenger().post({message: "Sembla que tenim algun problema", type: 'error', hideAfter: 10});
				}
		});
	});


	//delete
	$('#btn_delete').click(function(e) {

		e.preventDefault();
		var items = [];

		$(':checkbox').each(function() {
		if(this.checked) {
				var id    = $(this).attr('data-id');
				items.push(id);
			}
		});

		var view = $(this).attr('data-view');
		var pageURL = $(this).attr("href");

		if(items == 0) { alert('Please check one item at least'); return false; } else { if(!confirm('Are you sure you want to delete this item?')) return false; }

		var list = JSON.stringify(items);

		$.ajax({
			url: pageURL,
			type: "post",
			datatype: 'json',
			data: {'items': list},
			success: function(data){
				Messenger().post({message: view+' success deleted', type: 'success', hideAfter: 10});
					items.forEach(item => {
						$(`tr[data-id="${item}"]`).remove();
					})
			},
			error: function(data){
				Messenger().post({message: 'Sembla que tenim algun problema', type: 'error', hideAfter: 10});
			}
			});
		 });

	//new
	$('#btn_new').click(function(e) {

		e.preventDefault();

		var pageURL = $(this).attr("href");
		var projId = getParameterByName('filter_equal_projecteId');

		if(projId == ''){
			document.location.href = domain+'/'+pageURL;
		} else {
			document.location.href = domain+'/'+pageURL+'&projecteId='+projId;
		}
 	});

	function deleteAccount(username, domain) {
		if($('#proceed').val().toLowerCase() == username) {
			document.location.href = domain+'?view=config&task=deleteAccount';
		} else {
			return false;
		}
	}

	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

});
