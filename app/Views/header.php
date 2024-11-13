
<?php $session = session(); ?>
<header>
<link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>">
    <div class="logo">TextMe</div>
    <nav>
        <a href="<?= base_url('page-acceuil') ?>">Accueil</a>
        <a href="<?= base_url('listeamis') ?>">Demandes d'amis</a>
        <a href="<?= base_url('poste') ?>">Poste</a>
        <a href="<?= base_url('Mescontacts') ?>">Contact</a>
        <div class="dropdown">
            <a href="#" onclick="toggleDropdown()">Paramètre &#9662;</a>
            <div id="dropdown-content" class="dropdown-content">
                <a href="<?= base_url('modifier_profil') ?>">Modifier le profil</a>
            </div>
        </div>
        <a href="<?= base_url('deconnexion') ?>">Déconnexion</a>
    </nav>
    <div class="search-container">
        <input type="text" id="search-bar" placeholder="Rechercher un utilisateur..." onkeyup="searchUser()">
        <div id="search-results" class="search-results"></div>
    </div>
</header>


<script>
    
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

    
</script>