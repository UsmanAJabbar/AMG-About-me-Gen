// This JS file handles the necessary processes
// such as handling the light/dark mode, and filling
// in the dynamic data retrived by the database

// For faster load times, loads JS only when the HTML/CSS have been rendered
$(document).ready(() => {

  // Toggle between light/dark mode if the button's pressed
  $('#light_dark_toggle').click(() => {
    // Switch between preset light/dark CSS
    $('body').toggleClass('light dark');
    // Update the light/dark button clipart
    $('#light_dark_toggle').toggleClass('sun moon');
  });

  // Adds the specific data to their respective sections
  $.getJSON('data.json', function( data ) {
    $('title').text(data['name']);
    $('#cover_image').css('background', 'url($data[cover_image])')
    $('#profile_picture').css('background', 'url($data[profile_picture])');
    $('#name').text(data['name']);
    $('#status').text(data['status']);
    $('#description').text(data['description'])
  };

});
