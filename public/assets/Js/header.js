

    function toggleDropdown() {
        const dropdownContent = document.getElementById("dropdown-content");
        dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
    }
    function searchUser() {
    const query = document.getElementById('search-bar').value;
    console.log('Recherche:', query);

    if (query.length === 0) {
        document.getElementById('search-results').style.display = 'none';
        return;
    }

    fetch(`<?= base_url('searchUser') ?>?search=${query}`)
        .then(response => response.json())
        .then(data => {
            let resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';
            if (data.length > 0) {
                data.forEach(user => {
                    let div = document.createElement('div');
                    div.innerHTML = `
                        <a href="<?= base_url('profil') ?>/${user.iduser}" style="text-decoration: none; color: inherit;">
                            <img src="<?= base_url('images') ?>/${user.pdp}" alt="Photo de profil" width="30" height="30">
                            ${user.name} ${user.lastname}
                        </a>
                    `;
                    resultsContainer.appendChild(div);
                });
                resultsContainer.style.display = 'block';
            } else {
                resultsContainer.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Erreur de recherche:', error);
        });
}

    