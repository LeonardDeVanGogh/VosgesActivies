import './styles/activities.css';

let i;
let j;
let filteredElements = document.getElementsByClassName('filter');
let formData = new FormData();
let selectedCategories = [];
let categories = document.getElementsByClassName('option');

/* map section */

var mymap = L.map('mapid').setView([48.07220, 6.87284], 13);
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
}).addTo(mymap);


for(j=0;j<filteredElements.length;j++){
    filteredElements[j].classList.contains('selected')?formData.append(filteredElements[j].dataset.filter, 1):formData.append(filteredElements[j].dataset.filter, 0);
}

for(i=0;i<categories.length;i++){
    if(categories[i].classList.contains('selected')){
        selectedCategories.push(categories[i].dataset.filter)
    }
}

formData.append('selectedCategories', selectedCategories);
formData.append('categories', categories);

let request = new XMLHttpRequest();

request.open('POST', '/api/activitiesToJson');
request.addEventListener('load', function () {
    let activitiesJson = JSON.parse(request.response);

    for(i=0;i<activitiesJson.length;i++){
        let elementAdded = document.createElement('div');
        elementAdded.className = "col-md-4 activity activityDisplayed displayed";
        elementAdded.innerHTML = '' +
            '<div class="col-md-12">\n' +
            '\t\t\t\t\t\t<div class="card mb-4 product-wap rounded-0">\n' +
            '\t\t\t\t\t\t\t<div class="card rounded-0">\n' +
            '\t\t\t\t\t\t\t\t<img class="card-img rounded-0 img-fluid" src="/images/' + activitiesJson[i].picture + ' " alt=" ' + activitiesJson[i].name + ' " class="img-fluid">\n' +
            '\t\t\t\t\t\t\t\t<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">\n' +
            '\t\t\t\t\t\t\t\t\t<a class="btn btn-success text-white mt-2" href="/activity/read/ ' + activitiesJson[i].id + ' "><i class="far fa-eye"></i></a>\n' +
            '\t\t\t\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t\t\t<div class="card-body row">\n' +
            '\t\t\t\t\t\t\t\t<a href="/activity/read/ ' + activitiesJson[i].id + ' " class="h3 text-decoration-none text-center col-lg-12 text-truncate">' + activitiesJson[i].name + '</a>\n' +
            '\t\t\t\t\t\t\t\t<p class="w-100 list-unstyled d-flex justify-content-center mb-0 col-lg-12">' + activitiesJson[i].city + ' </p>\n' +
            '\t\t\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t\t</div>\n' +
            '\t\t\t\t\t</div>'
        ;
        document.body.getElementsByClassName('articles')[0].appendChild(elementAdded);
        let isHandicaped = activitiesJson[i].isHandicaped===true?'<i class="fas fa-wheelchair fa-2x"></i>':'';
        let animals = activitiesJson[i].isAnimalsFriendly===true?'<i class="fas fa-paw fa-2x"></i>':'';
        let indoor = activitiesJson[i].isIndoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        let outdoor = activitiesJson[i].isOutdoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        let marker = new L.marker([activitiesJson[i].latitude,activitiesJson[i].longitude], {
            title: activitiesJson[i].name,
        }).addTo(mymap)
            .bindPopup('<h6>' + activitiesJson[i].name + '</h6>' +
                '</p>' +
                '<span> Intérieur : </span>' +
                '<span> ' + indoor + '</span>' +
                '<span>     Extérieur : </span>' +
                '<span>' + outdoor + '</span>' +
                '</p>' +
                '</p>' +
                '<span title="Accessible aux personnes à mobilité réduite">' + isHandicaped + '</span>' +
                '<span title="animaux acceptés">' + animals + '</span></p>' +
                '<p>' +
                '<a class="btn btn-transparent" title="voir l\'activité" href="/activity/read/' + activitiesJson[i].id + '">' +
                '<i class="fas fa-info"></i>' +
                '<span> détails</span>' +
                '</a>' +
                '</p>'
            )
    }
});

request.send(formData);

/* filter section */

for(i = 0; i < filteredElements.length;i++){
    filteredElements[i].addEventListener('click',updateFilter);
}

function updateFilter(){
    if (this.classList.contains('selected')){
        this.classList.remove("selected");
        this.classList.add("unselected");
    }
    else{
        this.classList.remove("unselected");
        this.classList.add("selected");
    }

    mymap.eachLayer((layer) => {
        layer.remove();
    });
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
    }).addTo(mymap);
    for(j=0;j<filteredElements.length;j++){
        filteredElements[j].classList.contains('selected')?formData.append(filteredElements[j].dataset.filter, 1):formData.append(filteredElements[j].dataset.filter, 0);
    }
    let selectedCategories = [];
    let categories = document.getElementsByClassName('option');
    for(i=0;i<categories.length;i++){
        if(categories[i].classList.contains('selected')){
            selectedCategories.push(categories[i].dataset.filter)
        }
    }
    formData.append('selectedCategories', selectedCategories);
    let request = new XMLHttpRequest();

    request.open('POST', '/api/activitiesToJson');
    request.addEventListener('load', function () {
        let activitiesJson = JSON.parse(request.response);
        document.getElementsByClassName('articles')[0].innerHTML = '';

        for(i=0;i<activitiesJson.length;i++){
            let elementAdded = document.createElement('div');
            elementAdded.className = "col-lg-4 activity activityDisplayed displayed";
            elementAdded.innerHTML = '' +
                '<div class="col-md-12">\n' +
                '\t\t\t\t\t\t<div class="card mb-4 product-wap rounded-0">\n' +
                '\t\t\t\t\t\t\t<div class="card rounded-0">\n' +
                '\t\t\t\t\t\t\t\t<img class="card-img rounded-0 img-fluid" src="/images/' + activitiesJson[i].picture + ' " alt=" ' + activitiesJson[i].name + ' " class="img-fluid">\n' +
                '\t\t\t\t\t\t\t\t<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">\n' +
                '\t\t\t\t\t\t\t\t\t<a class="btn btn-success text-white mt-2" href="/activity/read/ ' + activitiesJson[i].id + ' "><i class="far fa-eye"></i></a>\n' +
                '\t\t\t\t\t\t\t\t</div>\n' +
                '\t\t\t\t\t\t\t</div>\n' +
                '\t\t\t\t\t\t\t<div class="card-body row">\n' +
                '\t\t\t\t\t\t\t\t<a href="/activity/read/ ' + activitiesJson[i].id + ' " class="h3 text-decoration-none text-center col-lg-12 text-truncate">' + activitiesJson[i].name + '</a>\n' +
                '\t\t\t\t\t\t\t\t<p class="w-100 list-unstyled d-flex justify-content-center mb-0 col-lg-12">' + activitiesJson[i].city + ' </p>\n' +
                '\t\t\t\t\t\t\t</div>\n' +
                '\t\t\t\t\t\t</div>\n' +
                '\t\t\t\t\t</div>'
            ;
            document.body.getElementsByClassName('articles')[0].appendChild(elementAdded);
            let isHandicaped = activitiesJson[i].isHandicaped===true?'<i class="fas fa-wheelchair fa-2x"></i>':'';
            let animals = activitiesJson[i].isAnimalsFriendly===true?'<i class="fas fa-paw fa-2x"></i>':'';
            let indoor = activitiesJson[i].isIndoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
            let outdoor = activitiesJson[i].isOutdoor===true?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
            let marker = new L.marker([activitiesJson[i].latitude,activitiesJson[i].longitude], {
                title: activitiesJson[i].name,
            }).addTo(mymap)
                .bindPopup('<h6>' + activitiesJson[i].name + '</h6>' +
                    '</p>' +
                    '<span> Intérieur : </span>' +
                    '<span> ' + indoor + '</span>' +
                    '<span>     Extérieur : </span>' +
                    '<span>' + outdoor + '</span>' +
                    '</p>' +
                    '</p>' +
                    '<span title="Accessible aux personnes à mobilité réduite">' + isHandicaped + '</span>' +
                    '<span title="animaux acceptés">' + animals + '</span></p>' +
                    '<p>' +
                    '<a class="btn btn-transparent" title="voir l\'activité" href="/activity/read/' + activitiesJson[i].id + '">' +
                    '<i class="fas fa-info"></i>' +
                    '<span> détails</span>' +
                    '</a>' +
                    '</p>'
                )
        }
    });
    request.send(formData);
}


/* switch list/map rendering */

let viewsOptions = document.getElementsByClassName("viewsOptions");
for(i = 0; i < viewsOptions.length;i++){
    viewsOptions[i].addEventListener('click',updateView);
}

function updateView(){
    let views = document.getElementsByClassName("activitiesViews");
    for(i=0;i<views.length;i++){
        views[i].classList.remove('displayed');
        views[i].classList.add('hidden');
    }
    if(this.classList.contains('isList')){
        document.getElementById('isList').classList.remove('hidden');
        document.getElementById('isList').classList.add('displayed');

    }else{
        document.getElementById('mapid').classList.remove('hidden');
        document.getElementById('mapid').classList.add('displayed');
    }
}




