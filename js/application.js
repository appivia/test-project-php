const submitForm = ($form) => {
  const $buttons = $form.find('button');

  $.ajax({
    url: $form.attr('action'),
    beforeSend: () => {
      $buttons.prop('disabled', true);
    },
    complete: () => {
      $buttons.prop('disabled', false);
    },
  });
};

const resetForm = ($form) => {
};

const renderErrorMessages = () => {
};

const renderSuccessMessage = () => {
};

const setupForms = () => {
  $('.js-ajax-form').each((_, form) => {
    const $form = $(form);

    $form.on('submit', (evt) => {
      evt.preventDefault();
      evt.stopPropagation();

      $form.addClass('was-validated');
      submitForm($form);
    });
  });
};

$(function () {
  setupForms();
});
