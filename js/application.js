const setupForms = () => {
  $('form').each((_, form) => {
    const $form = $(form);

    $form.on('submit', (evt) => {
      const isValid = evt.target.checkValidity();

      evt.preventDefault();
      evt.stopPropagation();

      if ($form.hasClass('needs-validation')) {
        $form.addClass('was-validated');
      }

      console.log('form is valid?', isValid)
    });
  });
};

$(function () {
  setupForms();
});
