// get json from local api and populate appropriate divs 
// or else redirect to admin page to insert record

$(document).ready(function() {

  // Adds the specific data to their respective sections
  $.getJSON('http://localhost:5000', function( data ) {
    $('title').text(data.name);
    $('#cover_image').css('background', 'url(' + data.cvrimg + ')');
    $('#profile_picture').css('background', 'url(' + data.propic + ')');
    $('#name').text(data.name);
    $('#status').text(data.status);
    $('#description').text(data.bio);
	const icons = ['phone', 'fb', 'twitter', 'insta', 'email', 'linkedin', 'github', 'medium', 'bechance'];

  }).fail( function() {
    $(location).attr('href', 'admin.html');
  });

});
