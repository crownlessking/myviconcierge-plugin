
// filepath: /c:/Users/rivie/Dropbox/Projects/myviconcierge.local/wp-content/plugins/myviconcierge-plugin/myviconcierge-plugin.js
jQuery(document).ready(function($) {
  var restaurantInput = document.querySelector("#restaurant_phone");

  if (restaurantInput) {
    var iti = window.intlTelInput(restaurantInput, {
      initialCountry: "auto",
      geoIpLookup: function(callback) {
        $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.country) ? resp.country : "us";
          callback(countryCode);
        });
      },
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", // Ensure utilsScript is included
      formatOnDisplay: true
    });

    // Format the number on blur
    restaurantInput.addEventListener('blur', function() {
      var countryCode = iti.getSelectedCountryData().dialCode;
      var formattedNumber = iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
      restaurantInput.value = `+${countryCode} ${formattedNumber}`;
    });
  }

  var beachInput = document.querySelector("#beach_phone");

  if (beachInput) {
    var beachIti = window.intlTelInput(beachInput, {
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
    beachInput.addEventListener('blur', function() {
      var countryCode = beachIti.getSelectedCountryData().dialCode;
      var formattedNumber = beachIti.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
      beachInput.value = `+${countryCode} ${formattedNumber}`;
    });
  }

  var accommodationInput = document.querySelector("#accommodation_phone");

  if (accommodationInput) {
    var accommodationIti = window.intlTelInput(accommodationInput, {
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
    accommodationInput.addEventListener('blur', function() {
      var countryCode = accommodationIti.getSelectedCountryData().dialCode;
      var formattedNumber = accommodationIti.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
      accommodationInput.value = `+${countryCode} ${formattedNumber}`;
    });
  }
});
