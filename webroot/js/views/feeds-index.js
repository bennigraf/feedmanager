
$(document).bind('ready', function () {
	
	// feed filtering function:
	// step through elements, show all that match the title with a value from the select
	function filterFeeds (titles) {
		if(titles != null) {
			$("#content .item").each(function(){
				var title = $(this).data("title");
				if(titles.indexOf(title)>=0) {
					$(this).css("display", "block");
				} else {
					$(this).css("display", "none");
				}
			});
		} else {
			$("#content .item").each(function(){
				$(this).css("display", "block");
			});
		}
	}
	
	
	// init the filter by getting all the data, adding the titles to the select as options, and 
	// calling .chosen on the select...
	var feedFilterSelect = $("select#FeedFilter");

	$("#content .item").each(function(index){
		// $(this) is the current object...
		// $(this).
		var h3 = $("h3", this).clone();
		h3.find('span').remove();
		var title = h3.text();
		feedFilterSelect.append('<option>'+title+'</option>');
		
		// store title in element to make it "searchable"...
		$(this).data("title", title);
	});
	
	
	// init chosen...
	var chzn = $("select#FeedFilter").chosen({
		search_contains: true,
		allow_single_deselect: true
	});
	
	
	// set up the event handler aka. "big filter"
	chzn.change(function(){
		var titles = $(this).val();
		
		// store content into local storage
		if(hasStorage()) {
			localStorage['feedsFilter'] = JSON.stringify(titles);
		}
		
		filterFeeds(titles);
	});
	
	
	// check local storage for previous searches and mark those options as selected
	if(hasStorage()) {
		var titles = JSON.parse(localStorage["feedsFilter"] || null);
		if(titles!=null) {
			// filterFeeds(JSON.parse(localStorage["feedsFilter"]));
			$("select#FeedFilter option").each(function(){
				for (var i=0; i < titles.length; i++) {
					if($(this).val() == titles[i]) {
						$(this).attr('selected', 'selected');
					}
				};
			})
		}
	}
	// call this handler once in case anything was preselected
	chzn.trigger("chosen:updated");
	chzn.change();
	

});
