
$(document).bind('ready', function () {
	
	// feed filtering function:
	// step through elements, show all that match the title with a value from the select
	function filterItems (titles) {
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
	var itemsFilterSelect = $("select#ItemsAssignFilter");

	$("#content .item").each(function(index){
		// $(this) is the current object...
		// $(this).
		var h3 = $("h3", this).clone();
		h3.find('span').remove();
		var title = h3.text();
		itemsFilterSelect.append('<option>'+title+'</option>');
		
		// store title in element to make it "searchable"...
		$(this).data("title", title);
	});
	
	// init chosen... important that this happens after loading local storage!
	var chzn = itemsFilterSelect.chosen({
		search_contains: true,
		allow_single_deselect: true
	});
	
	
	// set up the event handler aka. "big filter"
	chzn.change(function(){
		var titles = $(this).val();
		
		// store content into local storage
		if(hasStorage()) {
			localStorage['itemsAssignFilter'] = JSON.stringify(titles);
		}
		
		filterItems(titles);
	});
	
	// check local storage for previous searches and mark those options as selected
	if(hasStorage()) {
		var titles = JSON.parse(localStorage['itemsAssignFilter'] || null);
		if(titles!=null) {
			// filterFeeds(JSON.parse(localStorage["feedsFilter"]));
			$("option", itemsFilterSelect).each(function(){
				for (var i=0; i < titles.length; i++) {
					if($(this).val() == titles[i]) {
						$(this).attr('selected', 'selected');
					}
				};
			})
		}
	}
	// call this handler once in case anything is preselected
	chzn.trigger("chosen:updated");
	chzn.change();
	
	
	////////////// THE SAME FOR EVERY ITEM AND IT'S FEEDS /////////////////////
	$(".item .actions select, .item .actions .saveassglink").css('display', 'none');
	$(".item").each(function(){
		var item = this;
		var itemid = $(this).attr('data-itemid');
		var select = $(".actions select", item);
		$(".editassglink", item).click(function(){
			$(this).css('display', 'none');
			select.css('display', 'inline');
			select.chosen({
				search_contains: true,
				allow_single_deselect: true,
				width: "100%"
			});
			$(".actions .saveassglink", item).css('display', 'block');
			return false;
		});
		$(".saveassglink", item).click(function(){
			var feedids = select.val();
				// console.log(feedids);
			var ajdata = {itemid: itemid, feedids: feedids};
			$.ajax('', {
				dataType: 'json',
				data: ajdata,
				type: 'GET',
				success: function(res, status){
					// console.log(res);
					$(".actions select", item).chosen('destroy');
					// $(".actions .chosen-container").remove();
					$(".actions select", item).css('display', 'none');
					$(".saveassglink", item).css('display', 'none').find('img').remove();
					$(".editassglink", item).css('display', 'inline');
					$(".assignedTo", item).html('Assigned to: '+res['assignedTo'].join(', '));
				}
			});
			$(this).append(' <img src="/img/icons/loader.gif" alt="Lädt...">');
			
			return false;
		});
	});
	
	//////// loader gif preloading...
	$("body").append('<img src="/img/icons/loader.gif" style="display: none">');

});
