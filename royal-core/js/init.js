jQuery(function($) {
 
$('#upload_image_button').click(function() {
	formfield = $('#upload_image').attr('name');
	tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	return false;
});
 
window.send_to_editor = function(html) {
	imgurl = $('img',html).attr('src');
	$('#upload_image').val(imgurl);
	tb_remove();
}
 
});