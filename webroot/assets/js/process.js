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

});
