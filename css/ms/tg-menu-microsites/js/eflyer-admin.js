jQuery( document ).ready(function() {
    console.log( "ready!" );

var meta_gallery_frame;
var meta_footer_gallery_frame;
var meta_image_frame;


// Runs when the image button is clicked.
jQuery('#eflyer_gallery_button').click(function(e){

    //Attachment.sizes.thumbnail.url/ Prevents the default action from occuring.
    e.preventDefault();
console.log('gallery add');
    // If the frame already exists, re-open it.
    if ( meta_gallery_frame ) {
        meta_gallery_frame.open();
        return;
    }

    // Sets up the media library frame
    meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
        title: eflyer_gallery.title,
        button: { text:  eflyer_gallery.button },
        library: { type: 'image' },
        multiple: true
    });

    // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
    meta_gallery_frame.states.add([
        new wp.media.controller.Library({
            id:         'shift8-portfolio-gallery',
            title:      'Select Images for Gallery',
            priority:   20,
            toolbar:    'main-gallery',
            filterable: 'uploaded',
            library:    wp.media.query( meta_gallery_frame.options.library ),
            multiple:   meta_gallery_frame.options.multiple ? 'reset' : false,
            editable:   true,
            allowLocalEdits: true,
            displaySettings: true,
            displayUserSettings: true
        }),
    ]);

    meta_gallery_frame.on('open', function() {
        var selection = meta_gallery_frame.state().get('selection');
        var library = meta_gallery_frame.state('gallery-edit').get('library');
        var ids = jQuery('#eflyer_gallery').val();
        if (ids) {
            idsArray = ids.split(',');
            idsArray.forEach(function(id) {
                attachment = wp.media.attachment(id);
                attachment.fetch();
                selection.add( attachment ? [ attachment ] : [] );
            });
        }
    });

    meta_gallery_frame.on('ready', function() {
        jQuery( '.media-modal' ).addClass( 'no-sidebar' );
    });

    // When an image is selected, run a callback.
    //meta_gallery_frame.on('update', function() {
    meta_gallery_frame.on('select', function() {
        var imageIDArray = [];
        var imageHTML = '';
        var metadataString = '';
        images = meta_gallery_frame.state().get('selection');
        imageHTML += '<ul class="eflyer_gallery_list">';
        images.each(function(attachment) {
            imageIDArray.push(attachment.attributes.id);
            imageHTML += '<li><div class="eflyer_gallery_container"><span class="eflyer_gallery_close">' +
                '<img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'">' +
                '</span></div></li>';
        });
        imageHTML += '</ul>';
        metadataString = imageIDArray.join(",");
        if (metadataString) {
            jQuery("#eflyer_gallery").val(metadataString);
            jQuery("#eflyer_gallery_src").html(imageHTML);
            setTimeout(function(){
               /* ajaxUpdateTempMetaData();*/
            },0);
        }
    });

    // Finally, open the modal
    meta_gallery_frame.open();

});
//Run for the  image field to load gallery
    jQuery('.eflyer_image_button').on('click', function(e){

        //Attachment.sizes.thumbnail.url/ Prevents the default action from occuring.
        e.preventDefault();
        console.log('image add');

        // If the frame already exists, re-open it.
       if ( meta_image_frame ) {
            meta_image_frame.open();
           // return;
        }
        //var admin_fieldID = jQuery(this).data('fieldid');
        var admin_fieldID = jQuery(this).attr('data-fieldid');
        var tempname = 'eflyer_image_'+admin_fieldID;

        console.log(admin_fieldID);
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_gallery_frame = wp.media({
            title: tempname.title,
            button: { text:  tempname.button },
            library: { type: 'image' },
            multiple: false
        });

        // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
        meta_image_frame.states.add([
            new wp.media.controller.Library({
                id:         'shift8-portfolio-image',
                title:      'Select an Image',
                priority:   20,
                toolbar:    'main-image',
                filterable: 'uploaded',
                library:    wp.media.query( meta_image_frame.options.library ),
                multiple:   meta_image_frame.options.multiple ? 'reset' : false,
                editable:   true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);

        meta_image_frame.on('open', function() {
            var selection = meta_image_frame.state().get('selection');
            var library = meta_image_frame.state('gallery-edit').get('library');
            var ids = jQuery('#eflyer_image_'+admin_fieldID).val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function(id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
                });
            }
        });

        meta_image_frame.on('ready', function() {
            jQuery( '.media-modal' ).addClass( 'no-sidebar' );
        });

        // When an image is selected, run a callback.
        //meta_gallery_frame.on('update', function() {
        meta_image_frame.on('select', function() {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            images = meta_image_frame.state().get('selection');
            //console.log(images);
           // imageHTML += '<ul class="eflyer_image_list">';
            images.each(function(attachment) {

                imageIDArray.push(attachment.attributes.id);
                imageHTML += '<span class="eflyer_image_close">' +
                    '<img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'">' +
                    '</span>';

               // imageHTML = attachment.attributes.sizes.thumbnail.url;
            });
            //imageHTML += '</ul>';
            metadataString = imageIDArray.join(",");
            if (metadataString) {
                console.log(imageHTML);
                console.log(admin_fieldID);
                jQuery("#eflyer_image_"+admin_fieldID).val(metadataString);
                jQuery("#eflyer_image_container_"+admin_fieldID ).html(imageHTML);
                setTimeout(function(){
                    /* ajaxUpdateTempMetaData();*/
                },0);
            }
        });

        // Finally, open the modal
        meta_image_frame.open();

    });
// Runs when the image button is clicked.
    jQuery('#eflyer_footer_gallery_button').click(function(e){

        //Attachment.sizes.thumbnail.url/ Prevents the default action from occuring.
        e.preventDefault();
        console.log('gallery footer add');
        // If the frame already exists, re-open it.
        if ( meta_footer_gallery_frame ) {
            meta_footer_gallery_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_footer_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
            title: eflyer_gallery.title,
            button: { text:  eflyer_gallery.button },
            library: { type: 'image' },
            multiple: true
        });

        // Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
        meta_footer_gallery_frame.states.add([
            new wp.media.controller.Library({
                id:         'shift8-portfolio-gallery',
                title:      'Select Images for Gallery',
                priority:   20,
                toolbar:    'main-gallery',
                filterable: 'uploaded',
                library:    wp.media.query( meta_footer_gallery_frame.options.library ),
                multiple:   meta_footer_gallery_frame.options.multiple ? 'reset' : false,
                editable:   true,
                allowLocalEdits: true,
                displaySettings: true,
                displayUserSettings: true
            }),
        ]);

        meta_footer_gallery_frame.on('open', function() {
            var selection = meta_footer_gallery_frame.state().get('selection');
            var library = meta_footer_gallery_frame.state('gallery-edit').get('library');
            var ids = jQuery('#eflyer_footer_gallery').val();
            if (ids) {
                idsArray = ids.split(',');
                idsArray.forEach(function(id) {
                    attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
                });
            }
        });

        meta_footer_gallery_frame.on('ready', function() {
            jQuery( '.media-modal' ).addClass( 'no-sidebar' );
        });

        // When an image is selected, run a callback.
        //meta_gallery_frame.on('update', function() {
        meta_footer_gallery_frame.on('select', function() {
            var imageIDArray = [];
            var imageHTML = '';
            var metadataString = '';
            images = meta_footer_gallery_frame.state().get('selection');
            imageHTML += '<ul class="eflyer_footer_gallery_list">';
            images.each(function(attachment) {
                imageIDArray.push(attachment.attributes.id);
                imageHTML += '<li><div class="eflyer_footer_gallery_container"><span class="eflyer_footer_gallery_close">' +
                    '<img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'">' +
                    '</span></div></li>';
            });
            imageHTML += '</ul>';
            metadataString = imageIDArray.join(",");
            if (metadataString) {
                jQuery("#eflyer_footer_gallery").val(metadataString);
                jQuery("#eflyer_footer_gallery_src").html(imageHTML);
                setTimeout(function(){
                    /* ajaxUpdateTempMetaData();*/
                },0);
            }
        });

        // Finally, open the modal
        meta_footer_gallery_frame.open();

    });
    /*Run to remove the image item from gallery*/
    jQuery(document.body).on('click', '.eflyer_gallery_close', function(event){

        event.preventDefault();

       // if (confirm('Are you sure you want to remove this image?')) {

            var removedImage = jQuery(this).children('img').attr('id');
            var oldGallery = jQuery("#eflyer_gallery").val();
            var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');
            jQuery(this).parents().eq(1).remove();
            jQuery("#eflyer_gallery").val(newGallery);
      //  }

    });
    /*Run to remove the image item from image field*/
    jQuery(document.body).on('click', '.eflyer_image_close', function(event){

        event.preventDefault();
        var fieldID = jQuery(this).attr('data-fieldid');
       // if (confirm('Are you sure you want to remove this image?')) {
            console.log(fieldID);
            var removedImage = jQuery(this).children('img').attr('id');
            var oldGallery = jQuery("#eflyer_image_"+fieldID ).val();
            var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');
           // jQuery(this).parents().eq(1).remove();
            jQuery('#eflyer_image_container_'+fieldID).html('');
            jQuery("#eflyer_image_"+fieldID ).val(newGallery);
      //  }

    });

    /*Run to remove the image item from gallery*/
    jQuery(document.body).on('click', '.eflyer_footer_gallery_close', function(event){

        event.preventDefault();

      //  if (confirm('Are you sure you want to remove this image?')) {

            var removedImage = jQuery(this).children('img').attr('id');
            var oldGallery = jQuery("#eflyer_footer_gallery").val();
            var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');
            jQuery(this).parents().eq(1).remove();
            jQuery("#eflyer_footer_gallery").val(newGallery);
       // }

    });
});
