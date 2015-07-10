// Delete for confirmation box..
$(document).ready(function() {
	// Delete record on Id
	$('.deleteLinkButton').click(function() {
		var recordId = $(this).attr('id');
		var anchor_tag_html = $('#anchor_' + recordId).html();
		$('#delete_anchor_tag_content').html(anchor_tag_html);
	});
});