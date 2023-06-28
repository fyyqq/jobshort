
const password = document.querySelectorAll('input[type="password"]');
const eye = document.querySelectorAll('.fa-eye');
const eye_slash = document.querySelectorAll('.fa-eye-slash');

eye.forEach(e => {
    e.addEventListener('click', e => {
        e.preventDefault();

        e.target.style.display = 'none';

        var previousSibling = e.target.previousElementSibling;
        previousSibling.setAttribute('type', 'text');

        const eye_slash = previousSibling.nextElementSibling.nextElementSibling;
        eye_slash.style.display = 'block';

    });
});

eye_slash.forEach(e => {
    e.style.display = 'none';

    e.addEventListener('click', e => {
        e.preventDefault();

        e.target.style.display = 'none';
        
        var previousSiblings = e.target.previousElementSibling.previousElementSibling;
        previousSiblings.setAttribute('type', 'password');
        
        const eye = previousSiblings.nextElementSibling;
        eye.style.display = 'block';
    });
});
