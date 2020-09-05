$(document).ready(function() {
	Video.embedVideo(videoId, "video-player");

	$('#checkpoints').select2();

	$('#add-checkpoint').click(addCheckpoint);
});

function showTitleAndDuration()
{
	$(document).ready(function() {
		title = Video.getTitle().then(function(title) {
			$("#videoTitle").val(title);
		});

		duration = Video.getDuration().then(function(duration) {
			$("#video-duration").html(formatDuration(duration))
		});
	});
}

function addCheckpoint()
{
	Video.getCurrentPosition().then(function (seconds) {
		var seconds = Math.floor(seconds);
		var displayTime = formatDuration(seconds);

		if ($('#checkpoints').find("option[value='" + seconds + "']").length == 0) {
			// Create a DOM Option and pre-select by default
			var newOption = new Option(displayTime, seconds, true, true);
			// Append it to the select
			$('#checkpoints').append(newOption).trigger('change');
		} 
	})
}

function formatDuration(seconds)
{
	if (seconds < 60) {
		return "00:" + seconds.toString().padStart(2, "0");
	}

	var minutes = Math.floor(seconds / 60);
	var seconds = seconds % 60;

	if (minutes < 60) {
		return minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0");
	} else {
		hours = Math.floor(minutes / 60);
		minutes = minutes % 60;

		return hours + ":" + minutes.toString().padStart(2, "0") + ":" + seconds.toString().padStart(2, "0");
	}
}