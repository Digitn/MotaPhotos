document.addEventListener('DOMContentLoaded', function() {
    // Bouton pour ouvrir la médiathèque
    var uploadButton = document.getElementById('upload-favicon-button');
    
    if (uploadButton) {
        uploadButton.addEventListener('click', function(e) {
            e.preventDefault();
            var image_frame;
            if (image_frame) {
                image_frame.open();
                return;
            }

            // Création de la fenêtre de la médiathèque
            image_frame = wp.media({
                title: 'Sélectionnez un Favicon',
                button: {
                    text: 'Utiliser ce favicon'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });

            // Lorsqu'une image est sélectionnée dans la médiathèque
            image_frame.on('select', function() {
                // On récupère les informations de l'image sélectionnée
                var image_data = image_frame.state().get('selection').first().toJSON();
                var imageField = document.querySelector('input[name="motaphotos_favicon_url"]');
                
                if (imageField) {
                    imageField.value = image_data.url;
                }
            });

            // Ouverture de la fenêtre de la médiathèque
            image_frame.open();
        });
    }
});
