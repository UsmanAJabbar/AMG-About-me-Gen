// get json from local api and populate appropriate divs 
// or else redirect to admin page to insert record

$(document).ready(function() {

  // Adds the specific data to their respective sections
  $.getJSON('http://localhost:5000', function( data ) {
    $('title').text(data.name);
    $('#cover_image').css('background', 'url(' + data.cvrimg + ') center / cover no-repeat');
    $('#profile_picture').css('background', 'url(' + data.propic + ') center / cover no-repeat');
    $('#name').text(data.name);
    $('#status').text(data.status);
    $('#description').text(data.bio);
    const icons = ['phone', 'facebook', 'twitter', 'instagram', 'email', 'linkedin', 'github', 'medium'];
    $.each(icons, function( index, value ) {
    if (isNaN(data[value])) { 
        $('#contact_details').append('<a href=' + data[value] + '><img src=assets/img/icons/' + value + '.png height=32px></img></a>');
      };
    });
  }).fail( function() {
    $(location).attr('href', 'admin.html');
  });

});
