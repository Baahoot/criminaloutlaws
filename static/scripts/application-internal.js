function CO_init() {
		if (typeof jQuery == 'undefined') {
			alert('Cannot connect to 2.0 Motherboard. Refresh page.');
			return;
		}
		
		document.onkeypress = CO_close;
		
		if ($("input.error:eq(0)").length > 0) {
			$("input.error:eq(0)").focus();
		}
		$("input > div.error").keyup(function () {
			$(this).removeClass('error');
		});
		CO_embed();
		$(".cb-enable").click(function () {
			var a = $(this).parents(".switch");
			$(".cb-disable", a).removeClass("selected");
			$(this).addClass("selected");
			$(".checkbox", a).attr("checked", !0)
		});
		$(".cb-disable").click(function () {
			var a = $(this).parents(".switch");
			$(".cb-enable", a).removeClass("selected");
			$(this).addClass("selected");
			$(".checkbox", a).attr("checked", !1);
		});
		
		if ($("div.app-notice").html().length > 0) {
			$("body").animate({ 'padding-top': '62px' }, 400);
			
			var closeNotice = setTimeout(function(){ 
				$("body").animate({ 'padding-top': '0px' }, 400);
				$("div.app-notice").slideUp(400, function(){ $(this).remove(); });
			}, 5000);
			
			$("div.app-notice").slideDown(400).css("cursor", "pointer").click(function () {
				$("body").animate({ 'padding-top': '0px' }, 400);
				$(this).slideUp(400, function(){ $(this).remove(); });
				clearTimeout(closeNotice);
			});
			
			
		}
	}

	function CO_close(e) {
		if (!e) {
			e = window.event;
		}
		var valid = 0; /* This applies to the ESC button */
		if ((e.keyCode && e.keyCode == 27) || (e.which && e.which == 27) || (e.charCode && e.charCode == 27)) {
			valid = 1;
			if (window.query) {
				window.query = '';
				$("input#query").val('').focus();
				$("div#search-suggestions").empty().hide();
			} else {
				clearTimeout(window.notice);
				if ($("div.app-notice").length > 0) {
					$("div.app-notice").slideUp(4000).remove();
				} else {
					$("div.l").fadeOut(1000);
					window.location.reload();
				}
			}
		} /* Up button */
		if (window.query && $("div#search-suggestions").html() && ((e.keyCode && e.keyCode == 38) || (e.which && e.which == 27) || (e.charCode && e.charCode == 38))) {
			valid = 1;
			$("div#search-suggestions a p").css('background', '#fff');
			if ($("div#search-suggestions a:focus").length > 0) {
				if ($("div#search-suggestions a:focus").not(":first-child").length == 0) {
					$("div#search-suggestions a:last-child").focus().find('p').css('background', '#eee');
				} else {
					$("div#search-suggestions a:focus").prev().focus().find('p').css('background', '#eee');
				}
			} else {
				$("div#search-suggestions a:first-child").focus().find('p').css('background', '#eee');
			}
			return false;
		} /* Down button */
		if (window.query && $("div#search-suggestions").html() && ((e.keyCode && e.keyCode == 40) || (e.which && e.which == 27) || (e.charCode && e.charCode == 40))) {
			valid = 1;
			$("div#search-suggestions a p").css('background', '#fff');
			if ($("div#search-suggestions a:focus").length > 0) {
				if ($("div#search-suggestions a:focus").not(":last-child").length == 0) {
					$("div#search-suggestions a:first-child").focus().find('p').css('background', '#eee');
				} else {
					$("div#search-suggestions a:focus").next().focus().find('p').css('background', '#eee');
				}
			} else {
				$("div#search-suggestions a:last-child").focus().find('p').css('background', '#eee');
			}
			return false;
		}
	}

	function CO_embed() {
		$("[rel=logout]").unbind().click(function () {
			return confirm("Are you sure you want to logout of your account?");
		});
		$("input[rel='lottery-num']").unbind().blur(function () {
			if ($(this).val() > 10 || $(this).val() < 1) {
				mknotice('Sorry, you can only select numbers between 1-10 for your lottery ticket.');
				$(this).val('1');
			} else {
				$(this).css('background', '#E6FCE6');
			}
		});
		$("[rel='search']").keyup(function () {
			if ($("div#search-suggestions").length == 0) {
				$('body').append('<br /><div id="search-suggestions"></div>');
				$("div#search-suggestions").hide();
			}
			if ($("div#search-suggestions").html() == "") {
				$("div#search-suggestions").hide();
			}
			if ($(this).val() == '') {
				$("div#search-suggestions").hide().empty();
			}
			if (window.query == $(this).val() || (window.searching == 1)) {
				return;
			}
			window.query = $(this).val().toLowerCase();
			clearTimeout(window.search);
			window.searching = 1;
			$.getJSON(CO_DIR + 'search/suggestions?q=' + $(this).val(), function (data) {
				window.searching = 0;
				if (data.count == 0) {
					return;
				}
				$("div#search-suggestions").show();
				var results = '';
				$.each(data.users, function (userid, userdata) {
					var format_username = userdata.username;
					format_username = format_username.replace(window.query, '<span style="background:yellow;">' + window.query + '</span>');
					var format_background = 'CF4E4E';
					if (userdata.online == 1) {
						var format_background = '59C26E';
					}
					results += '<a href="' + CO_URL + 'user/' + userdata.username + '" rel="ajax" class="search-result"><p>' + format_username + ' <span style="float:right; background:#' + format_background + '; width:12%; border-radius:30px;">&nbsp;</span></p></a>';
				});
				$("div#search-suggestions").html(results);
			});
		});
		$("[rel='event-delete']").click(function () {
			$.get($(this).attr('href'));
			if ($(this).parent().parent().hasClass('row-end')) {
				$(this).parent().parent().parent().find('tr:last-child').prev().prev().addClass('row-end');
			}
			$(this).parent().parent().toggle(500, function () {
				$(this).remove();
			});
			return false;
		});

		if ($("[rel='send-money']").length > 0 && $("[rel='send-money']").val() == $("[rel='send-money']").attr('transfer-limit')) {
			$("[rel='send-money']").css('color', 'darkgreen').css('background', '#F1FFED');
		}

		$("[rel='send-money']").unbind().bind('keyup', function () {
			this.value = this.value.replace(/[^0-9\.]/g, '');
			if (isNaN(this.value)) {
				mknotice('Sorry, you can only enter numeric values in this field.');
				return;
			}
			if (this.value <= 0 || this.value * 100 > $(this).attr('transfer-limit') * 100) {
				$(this).css('color', 'darkred').css('background', '#FFEDED');
				$(this).parent().parent().find('button[type=submit]').attr('disabled', true).addClass('disabled-button');
			} else {
				$(this).css('color', 'darkgreen').css('background', '#F1FFED');
				$(this).parent().parent().find('button[type=submit]').removeAttr('disabled').removeClass('disabled-button');
			}
			return false;
		}).blur(function () {
			this.value = parseFloat(this.value).toFixed(2);
		});

		if ($("[rel='send-gold']").length > 0 && $("[rel='send-gold']").val() == $("[rel='send-gold']").attr('transfer-limit')) {
			$("[rel='send-gold']").css('color', 'darkgreen').css('background', '#F1FFED');
		}

		$("[rel='send-gold']").unbind().bind('keyup', function () {
			this.value = this.value.replace(/[^0-9\.]/g, '');
			if (isNaN(this.value)) {
				mknotice('Sorry, you can only enter numeric values in this field.');
				return;
			}
			if (this.value < 1 || this.value * 100 > $(this).attr('transfer-limit') * 100) {
				$(this).css('color', 'darkred').css('background', '#FFEDED');
				$(this).parent().parent().find('button[type=submit]').attr('disabled', true).addClass('disabled-button');
			} else {
				$(this).css('color', 'darkgreen').css('background', '#F1FFED');
				$(this).parent().parent().find('button[type=submit]').removeAttr('disabled').removeClass('disabled-button');
			}
			return false;
		});

		$("[rel='manage-contact']").unbind().click(function () {
			$.get($(this).attr('href'));
			if ($(this).html().indexOf("Add") > -1) {
				$(this).find('button').html("Remove Contact");
				$(this).attr('href', $(this).attr('href').replace('create', 'remove'));
				if ($(this).attr('href').indexOf("&profile=1") == -1) {
					$(this).attr('href', $(this).attr('href') + '&profile=1');
				}
			} else {
				$(this).find('button').html("Add Contact");
				$(this).attr('href', $(this).attr('href').replace('remove', 'create').replace('&profile=1', ''));
			}
			return false;
		});

		$("#search-suggestions a").click(function () {
			$("div#search-suggestions").hide();
		});

		$("input[rel='gym-workout']").click(function () {
			$("form#gym").submit();
		});

		var minutes = new Array();
		var seconds = new Array();
		var unique = new Array();
		var element = new Array();
		for (var i = 0; i < unique.length; i++) {
			clearInterval(unique[i]);
		}

		$("[rel=time]").each(function (i, r) {
			$(this).attr('rel', '');
			var times = $(this).html().split(/\:/g);
			if (times.length - 1 == 0) {
				return;
			}
			minutes[i] = times[0];
			seconds[i] = times[1];
			element[i] = $(this);
			if (minutes[i] > 0 || seconds[i] > 0) {
				unique[i] = setInterval(function () {
					var this_element = element[i];
					if (minutes[i] == 0 && seconds[i] == 0) {
						this_element.attr('rel', 'time').html('0:00');
						clearInterval(unique[i]);
						return;
					} else if (minutes[i] > 0 && seconds[i] == 0) {
						minutes[i] = minutes[i] - 1;
						seconds[i] = 60;
					} else if (minutes[i] > 0 && seconds[i] > 0) {} else if (minutes[i] == 0 && seconds[i] > 0) {}
					seconds[i] = seconds[i] - 1;
					if (seconds[i] >= 0 && seconds[i] < 10) {
						this_element.html(minutes[i] + ':0' + seconds[i]);
					} else {
						this_element.html(minutes[i] + ':' + seconds[i]);
					}
				}, 1000);
			} else {
				$(this).attr('rel', 'time').html('0:00');
			}
		});
	}
	
window.onload = CO_init;

/* Minified engine for Criminal Outlaws - User AJAX code - Last updated: 17th September 2011 */