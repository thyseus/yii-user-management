/*!
 * pStrength jQuery Plugin v1.0.3
 * http://accountspassword.com/pstrength-jquery-plugin
 *
 * Created by AccountsPassword.com
 * Released under the GPL General Public License (Feel free to copy, modify or redistribute this plugin.)
 *
 */
 
(function($){
  
	var numbers_array = new Array(),
		upper_letters_array = new Array(),
		lower_letters_array = new Array(),
		special_chars_array = new Array(),
		$pStrength = 0,
		$pStrengthElement = null;
	
	var methods = {
		init : function( options, callbacks) {
		
			var settings = $.extend({
				'bind': 'keyup change',
				'changeBackground': true,
				'backgrounds'     : [['#cc0000', '#FFF'], ['#cc3333', '#FFF'], ['#cc6666', '#FFF'], ['#ff9999', '#FFF'],
									['#e0941c', '#FFF'], ['#e8a53a', '#FFF'], ['#eab259', '#FFF'], ['#efd09e', '#FFF'],
									['#ccffcc', '#FFF'], ['#66cc66', '#FFF'], ['#339933', '#FFF'], ['#006600', '#FFF'], ['#105610', '#FFF']],
				'passwordValidFrom': 60, // 60%
				'onValidatePassword': function(percentage) { },
				'onPasswordStrengthChanged' : function(passwordStrength, percentage) { }
			}, options);
					 
			for(var i = 48; i < 58; i++)
				numbers_array.push(i);
			for(i = 65; i < 91; i++)
				upper_letters_array.push(i);
			for(i = 97; i < 123; i++)
				lower_letters_array.push(i);
			for(i = 32; i < 48; i++)
				special_chars_array.push(i);
			for(i = 58; i < 65; i++)
				special_chars_array.push(i);
			for(i = 91; i < 97; i++)
				special_chars_array.push(i);
			for(i = 123; i < 127; i++)
				special_chars_array.push(i);
			
			return this.each(function(){
			 
				$pStrengthElement = $(this);
				
				var text  = $(this).val();
				 
				methods.calculatePasswordStrength(text, settings);
						 
				$pStrengthElement.bind(settings.bind, function(){
					methods.calculatePasswordStrength($(this).val(), settings);
				});
			 
			});
		},
	 
		onPasswordStrengthChanged: function(passwordStrength, settings) {
			var percentage;
			percentage = Math.ceil(passwordStrength * 100 / 12);
			
			if(percentage > 100)
				percentage = 100;
				
			settings.onPasswordStrengthChanged(passwordStrength, percentage);
			
			methods.onValidatePassword(passwordStrength, percentage, settings);
			
			if(settings.changeBackground) {
				methods.changeBackground(passwordStrength, settings.backgrounds);
			}
		},
		
		onValidatePassword: function(passwordStrength, percentage, settings) {
			if(percentage >= settings.passwordValidFrom) {
				settings.onValidatePassword(percentage);	
			}
		},
		
		changeBackground: function(passwordStrength, backgrounds) {			
			
			var background = passwordStrength;
										
			if(background > 12)
				background = 12;
							
			$pStrengthElement.css({'background-color':backgrounds[background][0],
								   'color': backgrounds[background][1]});
		},
		calculatePasswordStrength: function(text, settings){
		
			var passwordStrength = 0,
				numbers_found    = 0,
				upper_letters_found = 0,
				lower_letters_found = 0,
				special_chars_found = 0;
							
			passwordStrength += 2 * Math.floor(text.length / 8);
			
			for(var i = 0; i < text.length; i++) {
				if($.inArray(ord(text.charAt(i)), numbers_array) != -1 && numbers_found < 2) {
					passwordStrength++;
					numbers_found++;
					continue;
				}
				if($.inArray(ord(text.charAt(i)), upper_letters_array) != -1 && upper_letters_found < 2) {
					passwordStrength++;
					upper_letters_found++;
					continue;
				}
				if($.inArray(ord(text.charAt(i)), lower_letters_array) != -1 && lower_letters_found < 2) {
					passwordStrength++;
					lower_letters_found++;
					continue;
				}
				if($.inArray(ord(text.charAt(i)), special_chars_array) != -1 && special_chars_found < 2) {
					passwordStrength++;
					special_chars_found++;
					continue;
				}
			}
					
			methods.onPasswordStrengthChanged(passwordStrength, settings);
			 
		 }
  	};
  
  	function ord(string) {
		var str = string + '',
			code = str.charCodeAt(0);
		if (0xD800 <= code && code <= 0xDBFF) {
			var hi = code;
			if (str.length === 1) {
			  return code;
			}
			var low = str.charCodeAt(1);
			return ((hi - 0xD800) * 0x400) + (low - 0xDC00) + 0x10000;
		}
		
		if (0xDC00 <= code && code <= 0xDFFF) {
			return code;
		}
		  return code;
	}

	$.fn.pStrength = function(method) {
    	if ( methods[method] ) {
      		return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    	} else if ( typeof method === 'object' || ! method ) {
      		return methods.init.apply( this, arguments );
    	} else {
      		$.error( 'Method ' +  method + ' does not exist on jQuery.pStrength' );
    	}
  	};

})(jQuery);
