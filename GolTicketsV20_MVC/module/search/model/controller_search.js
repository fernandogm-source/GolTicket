 const typeIcon = {
    partido:     'sports_soccer',
    equipo:      'shield',
    ciudad:      'location_on',
    competicion: 'emoji_events',
};
 
const typeLabel = {
    partido:     'Partidos',
    equipo:      'Equipos',
    ciudad:      'Ciudades',
    competicion: 'Competiciones',
};
 
function showDropdown(results) {
    const $dropdown = $('#header-search-dropdown');
    $dropdown.empty();
 
    if (!results.length) {
        $dropdown.hide();
        return;
    }
 
    const groups = {};
    results.forEach(function (r) {
        if (!groups[r.type]) groups[r.type] = [];
        groups[r.type].push(r);
    });
 
    Object.keys(groups).forEach(function (type) {
        $('<div class="search-group-label"></div>')
            .text(typeLabel[type] || type)
            .appendTo($dropdown);
 
        groups[type].forEach(function (item) {
            $('<div class="search-item"></div>')
                .html(`
                    <span class="material-symbols-outlined search-item-icon">
                        ${typeIcon[type] || 'search'}
                    </span>
                    <span class="search-item-text">${item.label}</span>
                `)
                .on('click', function () {
                    selectResult(item);
                })
                .appendTo($dropdown);
        });
    });
 
    $dropdown.show();
}
 
function selectResult(item) {
    $('#header-search-dropdown').hide();
    $('#header-search-input').val(item.label);
 
    if (item.type === 'partido') {
        window.location.href = 'index.php?page=controller_shop&op=view&detalle=' + item.filter_val;
        return;
    }
 
    const filter = [[item.filter_key, item.filter_val]];
    localStorage.setItem('filter', JSON.stringify(filter));
    window.location.href = 'index.php?page=controller_shop&op=view';
}
 
function doSearch(term) {
    if (term.length < 2) {
        $('#header-search-dropdown').hide();
        return;
    }
 
    ajaxPromise(
        'module/search/controller/controller_search.php?op=autocomplete',
        'POST',
        'JSON',
        { term: term }
    )
    .then(function (data) {
        showDropdown(Array.isArray(data) ? data : []);
    })
    .catch(function () {
        $('#header-search-dropdown').hide();
    });
}
 
function searchInput() {
    let debounce = null;
 
    $('#header-search-input').on('input', function () {
        clearTimeout(debounce);
        const term = $(this).val().trim();
        debounce = setTimeout(function () { doSearch(term); }, 250);
    });
}
 
function searchClickOutside() {
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-wrapper').length) {
            $('#header-search-dropdown').hide();
        }
    });
}
 
// ─── Ready ────────────────────────────────────────────────────────────────────
 
$(document).ready(function () {
    searchInput();
    searchClickOutside();
});