$(document).ready(function() {
 	_init_datepicker();
 	_init_datetimepicker();
	_init_select2();
	_init_inputMask();
	calculateOrderItem();
	
	$('.sidebar .nav-item').on('click', function() { 
		if(!$(this).hasClass('menu-open')) { 
			$('.sidebar').animate({ 
				scrollTop: $(this).offset().top 
			}, 'slow'); 
		} 
	});
	
	$('.deleteCms').on('click', function() {

		var title = $(this).attr('data-title');
		var href = $(this).attr('data-href');
		
		bootbox.confirm({
			className: 'bb-danger',            		
			title: 'Usuwanie storny',
	        message: 'Czy na pewno chcesz usunąć stronę: "' + title + '"?',
	        buttons: {
	        	confirm: {
	        		label: 'Tak',
	        		className: 'btn-primary'
	        	},
	        	cancel: {
	        		label: 'Nie',
	        		className: 'btn-secondary'
	        	}
	        },
	        callback: function (result) {
	        	if(result === true) window.location.href = href;
	        },
	        centerVertical: true
	    });
    });
    
    $('.runCommand').on('click', function() {
		var cmd = $(this).attr('data-cmd');
		runArtisanCommand(cmd);
	});
});

function expandRow(rowId)
{
	$('tr[data-row-id=' + rowId + ']').toggleClass('d-none');
}

function showAlert(title, message, className = 'bg-info', icon = 'fa-info') {
	$(document).Toasts('create', {
		class: className,
		body: message,
		title: title,
		icon: 'fas ' + icon + ' fa-lg',
		autohide: true,
		delay: 6000
	});
}

function loader()
{
	$('#loader').modal('toggle');	
}

function _init_inputMask()
{
	//$('.inputmask').inputmask();
}

function _init_datepicker()
{
	$('.datepicker').datetimepicker({
		timePicker: false,
		format: 'DD.MM.YYYY',		
		locale: 'pl',
		icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'far fa-arrow-up',
                down: 'far fa-arrow-down',
                previous: 'far fa-chevron-left',
                next: 'far fa-chevron-right',
                today: 'far fa-calendar-check-o',
                clear: 'far fa-trash',
                close: 'far fa-times'    	
    	}
	}).inputmask("datetime", {
		inputFormat: "dd.mm.yyyy"
	});	
}

function _init_datetimepicker()
{
	$('.datetimepicker').datetimepicker({
		timePicker: true,
		locale: 'pl',
		format: 'DD.MM.YYYY HH:mm:00',
		icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'far fa-arrow-up',
                down: 'far fa-arrow-down',
                previous: 'far fa-chevron-left',
                next: 'far fa-chevron-right',
                today: 'far fa-calendar-check-o',
                clear: 'far fa-trash',
                close: 'far fa-times'
    	}
	});		
}

function _init_select2()
{
	$('.select2').select2();
	setTimeout(function() {
		$('.select2[multiple=multiple]').select2("destroy").select2({ closeOnSelect: false });
		}, 100);
}

function calculateOrderItem()
{
	$('input[data-name=price_gross]').on('blur', function() {
		__calculateItem($(this));
		updateOrderAmount();
	});
	
	$('input[data-name=price_net]').on('blur', function() {
		__calculateItem($(this));

		updateOrderAmount();
	});
	
	$('input[data-name=tax_rate]').on('blur', function() {
		__calculateItem($(this));

		updateOrderAmount();
	});
	
	$('input[data-name=quantity]').on('blur', function() {
		__calculateItem($(this));

		updateOrderAmount();
		
	});
	
	$('input[data-name=discount]').on('blur', function() {
				__calculateItem($(this));

		updateOrderAmount();
	});
	
	$('select[data-name=discount_type]').on('change', function() {
				__calculateItem($(this));

		updateOrderAmount();
	});	
}


function __calculateItem(_this)
{
	//setTimeout(function() {
		var price_net = parseFloat(_this.closest('tr').find('input[data-name=price_net]').val());
		var price_net_old = parseFloat(_this.closest('tr').find('input[data-name=price_net]').attr('data-old'));
		var quantity = parseFloat(_this.closest('tr').find('input[data-name=quantity]').val());
		var price_gross = parseFloat(_this.closest('tr').find('input[data-name=price_gross]').val());
		var vat =  parseFloat(_this.closest('tr').find('input[data-name=tax_rate]').val());
		var discount = parseFloat(_this.closest('tr').find('input[data-name=discount]').val());
		var discount_type = parseFloat(_this.closest('tr').find('select[data-name=discount_type]').val());
		var amount_net;
		var amount_gross;
		
		var price_regular_net = parseFloat(_this.closest('tr').find('input[data-name=price_net]').attr('data-regular-price'));
		var price_regular_gross = parseFloat(_this.closest('tr').find('input[data-name=price_gross]').attr('data-regular-price'));
		
		// let's calculate it

		if(_this.attr('data-name') == 'price_net')
		{
			price_gross = price_net + (price_net * (vat/100));
		}

		if(discount > 0)
		{
			if(discount_type == 'cash')
			{
				price_gross = price_gross - discount;			
			}
			else
			{
				price_gross = price_gross - price_gross * (discount/100);
			}
		}
		else
		{
			if(_this.attr('data-name') == 'discount' || _this.attr('data-name') == 'discount_type') {
				price_gross = price_regular_gross;
			}
		}

		price_net = price_gross / (vat/100 + 1);

		amount_net = price_net * quantity;
		amount_gross = price_gross * quantity;
		
		_this.closest('tr').find('input[data-name=price_net]').val(parseFloat(price_net, 10).toFixed(2));
		_this.closest('tr').find('input[data-name=price_gross]').val(parseFloat(price_gross, 10).toFixed(2));
		_this.closest('tr').find('input[data-name=amount_net]').val(parseFloat(amount_net, 10).toFixed(2));
		_this.closest('tr').find('input[data-name=amount_gross]').val(parseFloat(amount_gross, 10).toFixed(2));
	//}, 500);
}

function updateOrderAmount()
{
	setTimeout(function() {	
		var amount = 0;
		
		$('input[data-name=amount_gross]').each(function() {
			amount = amount + parseFloat($(this).val());
		});
	
		$('#orderAmount').html(amount.toFixed(2) + ' zł');
	}, 500);
}

function setCurrentTab(tab_name)
{
	///$('li[data-tab-name=' + tab_name + ']').find('a').click();
	$('.sidebar > nav > li').removeClass('menu-open').removeClass('menu-is-opening');
	$('li[data-tab-name=' + tab_name + ']').addClass('menu-open').addClass('menu-is-opening');
}

function runArtisanCommand(command)
{
		bootbox.confirm({
			className: 'bb-danger',            		
			title: 'Zadanie automatyczne',
	        message: 'Czy na pewno chcesz wykonać to zadanie?',
	        buttons: {
	        	confirm: {
	        		label: 'Tak',
	        		className: 'btn-primary'
	        	},
	        	cancel: {
	        		label: 'Nie',
	        		className: 'btn-secondary'
	        	}
	        },
	        callback: function (result) {
	        	if(result === true) {
					loader();
					
					setTimeout(function() {
		        	    $.ajax({
		        	        type: "GET",
		        	        dataType: "json",
		        	        url: "/adminsws/automation/" + command,
		        	        success: function (data) {
								loader();
								if(data == 0) {
		        					showAlert('Wykonano', 'Zadanie ' + command + ' zostało zakończone', 'bg-success', 'fa-check');
		        				} else {
									showAlert('Nie ukończono', 'Zadanie ' + command + ' nie zostało zakończone', 'bg-danger', 'fa-exclamation-triangle');
								}
		        	        },
		        	        error: function(data) {         	
		        				showAlert('Wystąpił błąd', 'Operacja nie została zakończona z powodu błędu.', 'bg-danger', 'fa-exclamation-triangle');
		        				loader();
		        	        }
		        	      });
	        	      }, 500);	
				}
	        },
	        centerVertical: true
	    });
}


function generatePassword(len, special = true) {
    var length = (len)?(len):(10);
    var string = "abcdefghijklmnopqrstuvwxyz"; //to upper 
    var numeric = '0123456789';
   	var punctuation = '!@#$%&*';
    
    if(special === false) {
    	var punctuation = '';
    }
    	
    var password = "";
    var character = "";
    var crunch = true;
    while( password.length<length ) {
        entity1 = Math.ceil(string.length * Math.random()*Math.random());
        entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
        entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
        hold = string.charAt( entity1 );
        hold = (password.length%2==0)?(hold.toUpperCase()):(hold);
        character += hold;
        character += numeric.charAt( entity2 );
        character += punctuation.charAt( entity3 );
        password = character;
    }
    password=password.split('').sort(function(){return 0.5-Math.random()}).join('');
    return password.substr(0,len);
}

  /**
   * Create a web friendly URL slug from a string.
   *
   * Requires XRegExp (http://xregexp.com) with unicode add-ons for UTF-8 support.
   *
   * Although supported, transliteration is discouraged because
   *     1) most web browsers support UTF-8 characters in URLs
   *     2) transliteration causes a loss of information
   *
   * @author Sean Murphy <sean@iamseanmurphy.com>
   * @copyright Copyright 2012 Sean Murphy. All rights reserved.
   * @license http://creativecommons.org/publicdomain/zero/1.0/
   *
   * @param string s
   * @param object opt
   * @return string
   */
  function url_slug(s, opt) {
    s = String(s);
    opt = Object(opt);

    var defaults = {
      'delimiter': '-',
      'limit': undefined,
      'lowercase': true,
      'replacements': {},
      'transliterate': (typeof (XRegExp) === 'undefined') ? true : false
    };

    // Merge options
    for (var k in defaults) {
      if (!opt.hasOwnProperty(k)) {
        opt[k] = defaults[k];
      }
    }

    var char_map = {
      // Latin
      'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç': 'C',
      'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I', 'Ï': 'I',
      'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö': 'O', 'Ő': 'O',
      'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U', 'Ý': 'Y', 'Þ': 'TH',
      'ß': 'ss',
      'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c',
      'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i',
      'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o',
      'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th',
      'ÿ': 'y',

      // Latin symbols
      '©': '(c)',

      // Greek
      'Α': 'A', 'Β': 'B', 'Γ': 'G', 'Δ': 'D', 'Ε': 'E', 'Ζ': 'Z', 'Η': 'H', 'Θ': '8',
      'Ι': 'I', 'Κ': 'K', 'Λ': 'L', 'Μ': 'M', 'Ν': 'N', 'Ξ': '3', 'Ο': 'O', 'Π': 'P',
      'Ρ': 'R', 'Σ': 'S', 'Τ': 'T', 'Υ': 'Y', 'Φ': 'F', 'Χ': 'X', 'Ψ': 'PS', 'Ω': 'W',
      'Ά': 'A', 'Έ': 'E', 'Ί': 'I', 'Ό': 'O', 'Ύ': 'Y', 'Ή': 'H', 'Ώ': 'W', 'Ϊ': 'I',
      'Ϋ': 'Y',
      'α': 'a', 'β': 'b', 'γ': 'g', 'δ': 'd', 'ε': 'e', 'ζ': 'z', 'η': 'h', 'θ': '8',
      'ι': 'i', 'κ': 'k', 'λ': 'l', 'μ': 'm', 'ν': 'n', 'ξ': '3', 'ο': 'o', 'π': 'p',
      'ρ': 'r', 'σ': 's', 'τ': 't', 'υ': 'y', 'φ': 'f', 'χ': 'x', 'ψ': 'ps', 'ω': 'w',
      'ά': 'a', 'έ': 'e', 'ί': 'i', 'ό': 'o', 'ύ': 'y', 'ή': 'h', 'ώ': 'w', 'ς': 's',
      'ϊ': 'i', 'ΰ': 'y', 'ϋ': 'y', 'ΐ': 'i',

      // Turkish
      'Ş': 'S', 'İ': 'I', 'Ç': 'C', 'Ü': 'U', 'Ö': 'O', 'Ğ': 'G',
      'ş': 's', 'ı': 'i', 'ç': 'c', 'ü': 'u', 'ö': 'o', 'ğ': 'g',

      // Russian
      'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh',
      'З': 'Z', 'И': 'I', 'Й': 'J', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O',
      'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'H', 'Ц': 'C',
      'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sh', 'Ъ': '', 'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu',
      'Я': 'Ya',
      'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh',
      'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
      'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
      'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
      'я': 'ya',

      // Ukrainian
      'Є': 'Ye', 'І': 'I', 'Ї': 'Yi', 'Ґ': 'G',
      'є': 'ye', 'і': 'i', 'ї': 'yi', 'ґ': 'g',

      // Czech
      'Č': 'C', 'Ď': 'D', 'Ě': 'E', 'Ň': 'N', 'Ř': 'R', 'Š': 'S', 'Ť': 'T', 'Ů': 'U',
      'Ž': 'Z',
      'č': 'c', 'ď': 'd', 'ě': 'e', 'ň': 'n', 'ř': 'r', 'š': 's', 'ť': 't', 'ů': 'u',
      'ž': 'z',

      // Polish
      'Ą': 'A', 'Ć': 'C', 'Ę': 'e', 'Ł': 'L', 'Ń': 'N', 'Ó': 'o', 'Ś': 'S', 'Ź': 'Z',
      'Ż': 'Z',
      'ą': 'a', 'ć': 'c', 'ę': 'e', 'ł': 'l', 'ń': 'n', 'ó': 'o', 'ś': 's', 'ź': 'z',
      'ż': 'z',

      // Latvian
      'Ā': 'A', 'Č': 'C', 'Ē': 'E', 'Ģ': 'G', 'Ī': 'i', 'Ķ': 'k', 'Ļ': 'L', 'Ņ': 'N',
      'Š': 'S', 'Ū': 'u', 'Ž': 'Z',
      'ā': 'a', 'č': 'c', 'ē': 'e', 'ģ': 'g', 'ī': 'i', 'ķ': 'k', 'ļ': 'l', 'ņ': 'n',
      'š': 's', 'ū': 'u', 'ž': 'z'
    };

    // Make custom replacements
    for (var k in opt.replacements) {
      s = s.replace(RegExp(k, 'g'), opt.replacements[k]);
    }

    // Transliterate characters to ASCII
    if (opt.transliterate) {
      for (var k in char_map) {
        s = s.replace(RegExp(k, 'g'), char_map[k]);
      }
    }

    // Replace non-alphanumeric characters with our delimiter
    var alnum = (typeof (XRegExp) === 'undefined') ? RegExp('[^a-z0-9]+', 'ig') : XRegExp('[^\\p{L}\\p{N}]+', 'ig');
    s = s.replace(alnum, opt.delimiter);

    // Remove duplicate delimiters
    s = s.replace(RegExp('[' + opt.delimiter + ']{2,}', 'g'), opt.delimiter);

    // Truncate slug to max. characters
    s = s.substring(0, opt.limit);

    // Remove delimiter from ends
    s = s.replace(RegExp('(^' + opt.delimiter + '|' + opt.delimiter + '$)', 'g'), '');

    return opt.lowercase ? s.toLowerCase() : s;
  }

  function slug(text) {
    var chars = [' ', '&quot;', 'ą', 'ę', 'ś', 'ć', 'ó', 'ń', 'ż', 'ź', 'ł', 'Ą', 'Ę', 'Ś', 'Ć', 'Ó', 'Ń', 'Ż', 'Ź', 'Ł'];
    var chars_replace = ['-', '', 'a', 'e', 's', 'c', 'o', 'n', 'z', 'z', 'l', 'a', 'e', 's', 'c', 'o', 'n', 'z', 'z', 'l'];

    $.each(chars, function (i, v) {
      text = text.replace(v, chars_replace[i]);
    });

    return text
        .toLowerCase()
        .trim()
        .replace(/[^0-9a-zA-Z\p{L}\-]+/u, '')
        .replace(/[\-]+/, '-')
        .trim('-');
  }
  
function copyContent(el)
{
    var textToCopy = el.text();
    var tempTextarea = $('<textarea>');
    $('body').append(tempTextarea);
    tempTextarea.val(textToCopy).select();
    document.execCommand('copy');
    tempTextarea.remove();
	showAlert('Skopiowano link', 'Link został skopiowany do schowka', 'bg-success', 'fa-info');
    
}