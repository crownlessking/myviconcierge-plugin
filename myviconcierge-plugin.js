
// filepath: /c:/Users/rivie/Dropbox/Projects/myviconcierge.local/wp-content/plugins/myviconcierge-plugin/myviconcierge-plugin.js
jQuery(document).ready(function($) {
  var input = document.querySelector("#restaurant_phone");
  var iti = window.intlTelInput(input, {
    initialCountry: "auto",
    geoIpLookup: function(callback) {
      $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "us";
        callback(countryCode);
      });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    formatOnDisplay: true
  });

  // Format the number on blur
  input.addEventListener('blur', function() {
    var formattedNumber = iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
    input.value = formattedNumber;
  });
});