
function showField(field) {
    document.getElementById('field').value = field;
    document.getElementById('fieldName').textContent = field.charAt(0).toUpperCase() + field.slice(1);
    document.getElementById('newValue').type = (field === 'password') ? 'password' : (field === 'pdp' ? 'file' : 'text');
    document.getElementById('form').style.display = 'block';
}

function updateProfile(event) {
    event.preventDefault();
    const formData = new FormData(document.getElementById('form'));

    fetch("<?= base_url('profile/updateProfile') ?>", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const msgBox = document.getElementById('msgBox');
        msgBox.innerText = data.message;
        msgBox.style.backgroundColor = data.success ? 'lightgreen' : 'lightcoral';
        msgBox.style.display = 'block';
    })
    .catch(error => {
        const msgBox = document.getElementById('msgBox');
        msgBox.innerText = "Erreur de communication avec le serveur.";
        msgBox.style.backgroundColor = 'lightcoral';
        msgBox.style.display = 'block';
    });
}
