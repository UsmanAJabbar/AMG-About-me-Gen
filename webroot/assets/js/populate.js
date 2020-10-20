// This JS file handles the necessary processes
// such as handling the light/dark mode, and filling
// in the dynamic data retrived by the database

// For faster load times, loads JS only when the HTML/CSS have been rendered
$(document).ready(function() {
  // Adds the specific data to their respective sections
  $.getJSON('assets/data.json', function( data ) {
    $('title').text(data.name);
    $('#cover_image').css('background', 'url(' + data.cvrimg + ')');
    $('#profile_picture').css('background', 'url(' + data.propic + ')');
    $('#name').text(data.name);
    $('#status').text(data.stat);
    $('#description').text(data.desc);
  }).fail( function() {
    $(location).attr('href', 'admin.html');
  });
});
