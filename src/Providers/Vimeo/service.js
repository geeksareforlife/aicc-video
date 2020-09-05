window.Video = {

	player: "",

	embedVideo: function(videoId, elementId)
	{
		var options = {
			id: videoId,
			width: Math.floor($('#' + elementId).width()),
			loop: false
		};

		console.log(options);

		this.player = new Vimeo.Player(elementId, options);
	},

	getCurrentPosition: function()
	{
		return this.player.getCurrentTime();
	},

	getDuration: function()
	{
		return this.player.getDuration();
	},

	getTitle: function()
	{
		return this.player.getVideoTitle();
	}
};