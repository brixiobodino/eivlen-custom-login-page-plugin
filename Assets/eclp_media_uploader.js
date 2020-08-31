jQuery(document).ready(function($){
    $('.select_logo').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Logo',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#logo_url').val(image_url);
        });
    });
    $('.select_bg_image').click(function(e) {
        e.preventDefault();
        var image2 = wp.media({ 
            title: 'Upload Background Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image2 = image2.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image2);
            var image_url2 = uploaded_image2.toJSON().url;
            // Let's assign the url value to the input field
           
            $('#eclp_bg_image').val(image_url2);
        });
    });
});