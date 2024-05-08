document.addEventListener('DOMContentLoaded', () => {
  setTimeout(() => {
    const images = document.querySelectorAll('img');
    for (let i = 0; i < images.length; i++) {
      const img = images[i];
      const src = img.getAttribute('src');
      fetch(ajax_object.ajax_url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          action: 'remi_remote_image',
          src,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.swapped) {
            img.setAttribute('src', data.swapped);
            console.log('Remi Swapped: ', data.swapped);
          }
          if (data.downloaded) {
            console.log('Remi Downloaded: ', data.downloaded);
          }
        })
        .catch((error) => console.error('Error:', error));
    }
  }, 300);
});
