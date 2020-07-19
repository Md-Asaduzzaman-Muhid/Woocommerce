/* 
 * author : fang yongbao
 * data : 2014.12.24
 * model : 垂直多级导航
 * info ：知识在于积累，每天一小步，成功永远属于坚持的人。
 * blog : http://www.best-html5.net
 */

/*
 *
 * @param {type} option
 * {
 *   @param Speed: num,//动画收缩时间
 *   @param autostart: ture/false,//初次加载是否将菜单全部展开
 *   @param autohide: true/false,//同级菜单是否隐藏
 * }
 * return obj
 *   none
 *
 *
 */
(function($) {
	$.fn.vmenuModule = function(option) {
		var obj,
			item;
		var options = $.extend({
				Speed: 220,
				autostart: true,
				autohide: 1
			},
			option);
		obj = $(this);

		item = obj.find("ul").parent("li");
		// item = obj.find("ul").parent("li").children("a");
		//item.attr("data-option", "off");
		item.prepend('<span class="has-sub" data-option="off"><i class="fa fa-angle-down" aria-hidden="true"></i></span>');
		item = obj.find("ul").parent("li").children("span");

		item.unbind('click').on("click", function() {
			var a = $(this);
			console.log(a);
			if (options.autohide) {
				a.parent().parent().find("span[data-option='on']").parent("li").children("ul").slideUp(options.Speed / 1.2,
					function() {
						$(this).parent("li").children("span").attr("data-option", "off");
					})
					console.log('autohide')
			}
			if (a.attr("data-option") == "off") {
				a.parent("li").children("ul").slideDown(options.Speed,
					function() {
						a.attr("data-option", "on");
					});
			}
			if (a.attr("data-option") == "on") {
				a.attr("data-option", "off");
				a.parent("li").children("ul").slideUp(options.Speed)
			}
		});
		if (options.autostart) {
			obj.find("span").each(function() {

				$(this).parent("li").parent("ul").slideDown(options.Speed,
					function() {
						$(this).parent("li").children("span").attr("data-option", "on");
					})
			})
		}

	}
})(window.jQuery || window.Zepto);