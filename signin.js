document.addEventListener('DOMContentLoaded', () => {
  const forms = document.querySelectorAll('form');

  forms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form),
        });

        
        const textResponse = await response.text();
        console.log('Response:', textResponse);

        
        const result = JSON.parse(textResponse);

        if (result.success && result.redirect) {
          window.location.href = result.redirect;
        } else if (result.error) {
          alert(result.error);
        }
      } catch (error) {
        console.error('Error parsing response:', error);
        alert("An error occurred while processing the form.");
      }
    });
  });
});

