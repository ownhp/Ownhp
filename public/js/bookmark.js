/**
 * @todo : Optimize the templating to set the foreach in templating instead of
 *       using jquery $.each as it complies the template each and every time
 * 
 * @param bookmarkFetchUrl
 * @param container
 * @param template
 */
window.bookmarkHeight = 120;
window.bookmarkWidth = 140;
window.bookmarks = false;
window.previousBookmarksLimit = 0;
function loadBookmarks(bookmarkFetchUrl, container, template) {
	var promptus = false;
	$(document).queue(
			function(next) {
				promptus = new prompt({
					reference : this,
					element : "#content",
					onUnblock : function() {
						$(window).trigger("resize");
					},
					beforeShow : function() {
						this.alternateMessage = this
								.showLoadingMessage("Loading Bookmarks...");
					}
				});
				next();
			}).queue(function(next) {
		$.ajax({
			url : bookmarkFetchUrl,
			cache : false,
			dataType : "json",
			success : function(data) {
				window.bookmarks = data;
			}
		}).complete(next);
	}).queue(function(next) {
		promptus.close();
		next();
	});
}
function rearrangeBookmarks(data, container, template) {
	if(data && data.bookmarks){
		var bookmarksAdded = 0;
		// Compute new Window Height
		var windowComputedHeight = $(window).height() - 80;
		var heightMultiplier = Math.floor(windowComputedHeight
				/ window.bookmarkHeight);

		// Leave one level of bookmarks as there needs to be adds there
		heightMultiplier--;
		windowComputedHeight = heightMultiplier * window.bookmarkHeight;

		// Compute new Window Width
		var windowComputedWidth = $(window).width();
		var widthMultiplier = Math
				.floor(windowComputedWidth / window.bookmarkWidth);
		windowComputedWidth = widthMultiplier * window.bookmarkWidth;

		var bookmarksLimit = Math.floor((windowComputedHeight)
				* (windowComputedWidth)
				/ (window.bookmarkHeight * window.bookmarkWidth));
		if (window.previousBookmarksLimit != bookmarksLimit) {
			var promptus = false;
			var self = this;
			$(document).queue(function(next) {
				promptus = new prompt({
					reference : self,
					element : "#content",
					beforeShow : function() {
						this.alternateMessage = this
								.showLoadingMessage("Rearranging Bookmarks..");
					}
				});
				container.html("");
				next();
			}).queue(function(next) {
				var viewPort = $("<div></div>", {
					style : " width: " + windowComputedWidth
							+ "px;height:" + windowComputedHeight
							+ "px ; overflow:hidden",
					"class" : "touchslider-viewport"
				});
				var compiledTemplate;
				var divWrapper = $("<div></div>");
				var div = $("<div class='touchslider-item'></div>");
				var customStyle = "height:" + windowComputedHeight
									+ "px;width:" + windowComputedWidth + "px;";
				var myDiv = $("<div></div>", {
					style : customStyle
				});
				$.each(
					data.bookmarks,
					function(index, bookmark) {
						if (bookmarksAdded == bookmarksLimit) {
							div.append(myDiv);
							divWrapper.append(div);
							div = $("<div class='touchslider-item'></div>");
							myDiv = $("<div></div>", {
								style : customStyle
							});
							bookmarksAdded = 0;
						}
						compiledTemplate = _
								.template(template);
						myDiv
								.append(compiledTemplate(bookmark));
						bookmarksAdded++;
					});
				div.append(myDiv);
				divWrapper.append(div);
				viewPort.append(divWrapper);
				container.append(viewPort);
				container.touchSlider({
					mouseTouch : true
				});
				window.previousBookmarksLimit = bookmarksLimit;
				next();
			}).queue(function(next) {
				promptus.close();
				next();
			});
		}
	} else {
		
		var promptus = new prompt({
			reference : this,
			element : "#content",
			beforeShow : function() {
				this.alternateMessage = this
						.showErrorMessage("No bookmarks..");
			}
		});
	}
}