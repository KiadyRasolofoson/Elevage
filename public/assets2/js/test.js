// Sélectionnez tous les éléments .glyphicon.glyphicon-heart-empty
const likes = document.querySelectorAll(".glyphicon.glyphicon-heart-empty");

// Ajoutez un gestionnaire d'événements à chaque icône "like"
likes.forEach((like) => {
    like.addEventListener('click', () => {
        if(like.style.color != "red")
        {
            like.style.color = "red"; // Modifie la couleur de l'icône "like" en rouge
        }
        else{
            like.style.color="black";
        }
        
    });
});

//Synchronisation publication
