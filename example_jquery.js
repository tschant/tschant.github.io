// Using the core $.ajax() method
$.ajax({
    // the URL for the request
    url: "eecs_647.php",
 
    // the data to send (will be converted to a query string)
    data: {
        //This is were the data to be stored would be sent in 
        //if we needed to send from js (like a form or something)
    },
 
    // whether this is a POST or GET request
    type: "POST",
 
    // code to run if the request succeeds;
    // the response is passed to the function
    success: function( json ) {
        $( "<h1/>" ).text( "success" ).appendTo( "body" );
    },
 
    // code to run if the request fails; the raw request and
    // status codes are passed to the function
    error: function( xhr, status, errorThrown ) {
        alert( "Sorry, there was a problem!" );
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    },
 
    // code to run regardless of success or failure
    complete: function( xhr, status ) {
        alert( "The request is complete!" );
    }
});
//website I got most of this from
//don't know if it will auto-work with html/php, or if we need to activate it
//http://learn.jquery.com/ajax/jquery-ajax-methods/