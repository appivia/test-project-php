/**
 * Creates an alert inside a placeholder
 *
 * @param {jQuery} $placeholder the placeholder to add the alert to
 * @param {String} message the alert message
 * @param {String} variant the bootstrap alert variant
 */
const createAlert = ($placeholder, message, variant='success') => {
  const $alert = $(`<div class="alert alert-${variant}" role="alert" />`).text(message);
  $placeholder.prepend($alert);

  // Remove the alert after 3 seconds
  setTimeout(() => $alert.hide(() => { $alert.remove() }), 3000);
};

/**
 * Resets a field's state by removing the error messages and related classes
 *
 * @param {jQuery} $input the input element
 */
const resetField = ($input) => {
  $input.removeClass('is-invalid');
  $input.next('.invalid-feedback').remove();
};

/**
 * Clears all errors for a form
 *
 * @param {jQuery} $form the form to clear the errors for
 */
const clearFormErrors = ($form) => {
  $form.find(':input').each((_, elem) => resetField($(elem)));
  $form.find('div[role="alert"]').remove();
};

/**
 * Renders the error messages for a given form
 *
 * @param {jQuery} $form the form to render error messages for
 * @param {String} errorMessage the form's overall errormessage
 * @param {Object} errors the field's error messages
 */
const renderErrorMessages = ($form, errorMessage, errors) => {
  if (errorMessage) {
    createAlert($('.js-add-user-form'), errorMessage, 'danger');
  }

  Object.entries(errors || {}).forEach(([name, msg]) => {
    const $input = $form.find('input[name="' + name);
    const $error = $('<div class="invalid-feedback"></div>').text(msg);

    $input.addClass('is-invalid');
    $input.after($error);

    $input.one('input paste', () => resetField($input));
  });
};

/**
 * Submits a form via AJAX
 *
 * @param {jQuery} $form the form to submit
 */
const submitForm = ($form) => {
  const $buttons = $form.find('button');

  $.ajax({
    url: $form.attr('action'),
    method: $form.attr('method'),
    data: $form.serialize(),
    beforeSend: () => {
      $buttons.prop('disabled', true);
    },
    complete: () => {
      $buttons.prop('disabled', false);
    },
    success: (data) => {
      clearFormErrors($form);
      $form.trigger('form:success', [data]).trigger('reset');
    },
    error: (response) => {
      const { responseJSON: { message = '', errors = {} } = {} } = response;
      $form.trigger('form:error', [message, errors]);
      renderErrorMessages($form, message, errors);
    },
  });
};

/**
 * Makes all forms submittable via AJAX and provides error handling
 */
const setupForms = () => {
  $('.js-ajax-form').each((_, form) => {
    const $form = $(form);

    $form.on('submit', (evt) => {
      evt.preventDefault();
      evt.stopPropagation();

      clearFormErrors($form);
      submitForm($form);
    });
  });
};

$(function () {
  setupForms();
});
