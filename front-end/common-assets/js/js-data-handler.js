var setDataCallback = function(data) {
    jQuery('#data_url').html(data.url).attr('href',data.url);       
    jQuery('#data_view').html(data.content);
};
    
jQuery.cachedScript = function(url, options) {
    // allow user to set any option except for dataType, cache, and url
    options = $.extend(options || {}, {
        dataType: "script",
        cache: true,
        url: url,
        error: function() {               
            jQuery('#data_view').html('Resource is not found!').show();  
        }
    });
    // Use $.ajax() since it is more flexible than $.getScript
    // Return the jqXHR object so we can chain callbacks
    return jQuery.ajax(options);
};