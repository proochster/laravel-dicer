(function(){

    // Theme slector
    let selector = document.querySelector('#theme_selector');

    selector.addEventListener("change", function(){
        localStorage.theme = this.value;
        loadTheme(this.value);
    });

    // Load theme
    if (localStorage.theme) {
        loadTheme(localStorage.theme);

        let options = Array.from(selector.options);
        let optionToSelect = options.find(item => item.value === localStorage.theme);
        optionToSelect.selected = true;

    }

    function loadTheme(theme_id){
        var link = document.querySelector('link[rel="stylesheet"]');
        link.href = `/css/app_${theme_id}.css`;
    }



})();
