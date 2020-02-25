$(document).ready(function() {
    if ($('.set_custom_images').length > 0) {
        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
            $('.set_custom_images').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                var id = button.prev();
                wp.media.editor.send.attachment = function(props, attachment) {
                    id.val((attachment.url).substring((attachment.url).indexOf("/wp-content"), (attachment.url).length));
                };
                wp.media.editor.open(button);
                return false;
            });
        }
    }
});