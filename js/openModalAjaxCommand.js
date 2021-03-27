/**
* @file
*/

(function ($, Drupal) {
Drupal.AjaxCommands.prototype.exsis = function (ajax, response, status) {
  $('#usersModal').modal('show');
  $('#modalMessage').text(`Name: ${response.name}
                                 Identification: ${response.identification}
                                 Birthday: ${response.birthday}
                                 Position: ${response.position}
                                 Status: ${response.status}
                                 `)
}

})(jQuery, Drupal);
