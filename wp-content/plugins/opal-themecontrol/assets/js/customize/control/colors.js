(function(a){a(window).load(function(){a('div[id^="opal-'+opal_themecontrol_customize_colors.type+'-"]').each(function(){var b=a(this);b.id=b.attr("id").replace("opal-"+opal_themecontrol_customize_colors.type+"-","");b.find('input[type="text"]').each(function(c,d){a(d).spectrum({color:a(d).val(),showInput:true,showInitial:true,allowEmpty:true,showAlpha:true,clickoutFiresChange:true,cancelText:opal_themecontrol_customize_colors.cancel?opal_themecontrol_customize_colors.cancel:"Cancel",chooseText:opal_themecontrol_customize_colors.choose?opal_themecontrol_customize_colors.choose:"Choose",preferredFormat:"hex",show:function(){if(!a(".sp-default").length){a(".sp-cancel").after('<a class="sp-default" href="#">'+(opal_themecontrol_customize_colors["default"]?opal_themecontrol_customize_colors["default"]:"Default")+"</a>")}a(".sp-default").off("click").on("click",function(e){e.preventDefault();a(d).spectrum("set",a(d).attr("default-value"));a(d).parent().children(".color-hex").text(a(d).attr("default-value"));a(d).trigger("change")})},move:function(e){a(d).parent().children(".color-hex").text("");if(e){a(d).parent().children(".color-hex").text(e.getAlpha()==1?e.toHexString():e.toRgbString())}a(d).trigger("change")},change:function(e){a(d).parent().children(".color-hex").text("");if(e){a(d).parent().children(".color-hex").text(e.getAlpha()==1?e.toHexString():e.toRgbString())}},hide:function(e){if(!e){a(this).siblings(".color-hex").text("");a(this).val("").trigger("change")}else{var f=e.getAlpha()==1?e.toHexString():e.toRgbString();a(this).siblings(".color-hex").text(f);a(this).val(f).trigger("change");a(".sp-container:visible").find(".sp-input").val(f)}}})});b.on("change","input[name]",function(){var c={};b.find("input[name]").each(function(f,g){var d=a(g).spectrum("get");if(a(g).attr("name")=="_"){c=d?(d.getAlpha()==1?d.toHexString():d.toRgbString()):""}else{c[a(g).attr("name")]=d?(d.getAlpha()==1?d.toHexString():d.toRgbString()):""}});wp.customize.control(b.id).setting.set(c)})})})})(jQuery);