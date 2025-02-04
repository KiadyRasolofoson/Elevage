<style>
    /* Footer */
   body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* 100% de la hauteur de l'écran */
    margin: 0;
}
/* Correction pour Bootstrap */
html, body {
    height: 100% !important !important;
}
.container.mt-4 {
    flex: 1; /* Le contenu principal prend tout l'espace disponible */
    padding-bottom: 60px; /* Marge pour le footer */
}

.site-footer {
    background-color: #343a40;
    color: #fff;
    padding: 2rem 0;
    margin-top: auto; /* Pousse le footer vers le bas */
    border-top: 3px solid #B22222;
    width: 100%;
}
.site-footer {
    background-color: #343a40;
    color: #fff;
    padding: 2rem 0;
    margin-top: 3rem;
    border-top: 3px solid #B22222;
    position: ;

}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-section {
    display: flex;
    gap: 1.5rem;
}

.footer-section a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-section a:hover {
    color: #B22222;
}


</style>
<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <p>&copy; <?= date('Y') ?> Gestion d'élevage</p>
            </div>
            <div class="footer-section">
                <p>ETU003356</p>
                <p>ETU003365</p>
                <p>ETU003304</p>
            </div>
        </div>
    </div>
</footer>