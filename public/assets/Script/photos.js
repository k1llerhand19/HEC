$(document).ready(function(){
        let imagesDejaAjoutees = [];

        {% for showImage in showImages %}
            if (!imagesDejaAjoutees.includes('{{ showImage.nomPhoto }}')) {
                let colonneLaPlusCourte = null;
                let nombreImagesColonneLaPlusCourte = Infinity;

                for (let j = 1; j <= 3; j++) {
                    let colonne = $(`#colonne-${j}`);
                    let nombreImagesColonne = colonne.find('img').length;

                    if (nombreImagesColonne < nombreImagesColonneLaPlusCourte) {
                        colonneLaPlusCourte = colonne;
                        nombreImagesColonneLaPlusCourte = nombreImagesColonne;
                    }
                }

                colonneLaPlusCourte.append(`<img src="{{ asset('assets/Images/photos/' ~ showImage.nomPhoto) }}" class="w-100 p-1" id="gallerie">`);

                imagesDejaAjoutees.push('{{ showImage.nomPhoto }}');
            }
        {% endfor %}
    });