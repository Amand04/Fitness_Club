//users

function filtrer() {
  let filtre, table, ligne, cellule, i, texte;

  filtre = document.getElementById("maRecherche").value.toUpperCase();
  table = document.getElementById("myTable");
  ligne = table.getElementsByTagName("tr");

  for (i = 0; i < ligne.length; i++) {
    cellule = ligne[i].getElementsByTagName("td")[0];
    if (cellule) {
      texte = cellule.innerText;
      if (texte.toUpperCase().indexOf(filtre) > -1) {
        ligne[i].style.display = "";
      } else {
        ligne[i].style.display = "none";
      }
    }
  }
}
