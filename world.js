'use strict';
const controls = document.querySelector('#controls');
const country = document.querySelector('#country');
const result = document.querySelector('#result');
const buttons = controls.querySelectorAll('button');
async function lookup(mode) {
    const parameters = new URLSearchParams({country: country.value.trim(), lookup: mode});
    buttons.forEach(button => button.disabled = true);
    result.setAttribute('aria-busy', 'true');
    result.textContent = 'Loading results…';
    try {
        const response = await fetch('world.php?' + parameters.toString());
        if (!response.ok) {
            throw new Error('Lookup failed');
        }
        result.innerHTML = await response.text();
    } catch (error) {
        result.textContent = 'Unable to load results. Please check the server and database, then try again.';
    } finally {
        buttons.forEach(button => button.disabled = false);
        result.setAttribute('aria-busy', 'false');
    }
}
controls.addEventListener('submit', event => {
    event.preventDefault();
    lookup('countries');
});
document.querySelector('#lookup-cities').addEventListener('click', () => lookup('cities'));
