// Gestion de l'animation sur la page Filtre Pathologie

document.addEventListener('DOMContentLoaded', (event) => {

    const input = document.getElementById('input');
    const affichetype = document.getElementById('type');
    const affichemeridien = document.getElementById('meridien');
    const affichecaract = document.getElementById('caract');


    input.addEventListener('change', function handleChange(event) {
        if (event.target.value === 'affichertype') {
            affichetype.style.display = 'block';
            affichecaract.style.display = 'block';
            affichemeridien.style.display = 'none';

        } else if (event.target.value === 'affichermeridien') {
            affichetype.style.display = 'none';
            affichemeridien.style.display = 'block';
            affichecaract.style.display = 'none';

        } else if (event.target.value === 'affichercaract') {
            affichetype.style.display = 'none';
            affichemeridien.style.display = 'none';
            affichecaract.style.display = 'block';
        }
    });
});