!function(){var t={ele:"body",type:"info",offset:{from:"top",amount:110},align:"right",width:250,delay:6e3,allow_dismiss:!0,stackup_spacing:10};$.simplyToast=function(s,e,a){var i,o,n;switch(a=$.extend({},t,a),i=$('<div class="simply-toast alert alert-'+s+'"></div>'),a.allow_dismiss&&i.append('<span class="close" data-dismiss="alert">&times;</span>'),i.append(e),a.top_offset&&(a.offset={from:"top",amount:a.top_offset}),n=a.offset.amount,$(".simply-toast").each(function(){return n=Math.max(n,parseInt($(this).css(a.offset.from))+$(this).outerHeight()+a.stackup_spacing)}),(o={position:"body"===a.ele?"fixed":"absolute",margin:0,"z-index":"9999",display:"none","box-shadow":"2px 2px 4px 4px rgb(0 0 0 / 20%)"})[a.offset.from]=n+"px",i.css(o),"auto"!==a.width&&i.css("width",a.width+"px"),$(a.ele).append(i),a.align){case"center":i.css({left:"50%","margin-left":"-"+i.outerWidth()/2+"px"});break;case"left":i.css("left","20px");break;default:i.css("right","20px")}function f(){i.fadeOut(function(){return i.remove()})}return i.fadeIn(),a.delay>0&&setTimeout(f,a.delay),i.find('[data-dismiss="alert"]').click(f),i}}();