function addFactToList(list, key, value){
	if(typeof value === "object" && !value.length)
		return;
	var item = [];
	var label = $("<dt></dt>").html(key);
	item.push(label);
	if(typeof value === "string" || typeof value === "int")				//  @todo fix this incorrect type check
		value = [value];
	for(var i in value)
		item.push($("<dd></dd>").html(value[i]));
	list.append(item);
}

function bindSprites(){
	$("#category-sprites div.tab-content div.tab-pane span.sprite").bind("click", function(){
		var key = $(this).data('key');
		var emoji = emojies[key];
		var content = $("<div></div>");
		var facts = $("<dl></dl>").addClass("dl-horizontal");
		addFactToList(facts, "Name", emoji.name);
		addFactToList(facts, "Shortname", emoji.shortname);
		addFactToList(facts, "Aliases", emoji.aliases);
		addFactToList(facts, "Category", emoji.category);
		addFactToList(facts, "Order", '<small class="not-muted">#</small>'+emoji.emoji_order);
		addFactToList(facts, "Unicode", '<div class="unicode"><span class="unicode">&#x'+emoji.unicode+';</span> <span>('+emoji.unicode+')</span></div>');
		addFactToList(facts, "ASCII", emoji.aliases_ascii);
		addFactToList(facts, "Keywords", emoji.keywords);
		var image = emojione.shortnameToImage(emoji.shortname);
		content.append(image);
		content.append(facts);
//		content.append($("<pre></pre>").html(JSON.stringify(emoji)));
		$("#emoji-details").html(content);
	}); 
}

$(document).ready(function(){
	emojione.imageType = 'svg';
	bindSprites();
});
