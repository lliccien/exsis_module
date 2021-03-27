(function ($) {
  'use strict';
  $(document).ready(function () {

    $('#edit-exsis-name').focus();

    $("#edit-exsis-name, #edit-exsis-identification").on("change paste keyup", function () {
      if ($("#edit-exsis-name").val() != '' && $("#edit-exsis-identification").val() != '') {
        $('#edit-exsis-submit').attr('disabled', false);
        $('#edit-exsis-submit').removeClass('is-disabled');
      } else {
        $('#edit-exsis-submit').attr('disabled', true);
        $('#edit-exsis-submit').addClass('is-disabled');
      }
    });

  });

})(jQuery);
