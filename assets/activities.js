import './styles/activities.css';

let i;
let j;
let filteredElements = document.getElementById('filterDashboard').getElementsByClassName('filter');
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
        console.log(document.getElementsByClassName('articles')[0].childElementCount);
        let elementAdded = document.createElement('div');
        elementAdded.className = "col-lg-4 activity activityDisplayed displayed";
        elementAdded.innerHTML = '' +
            '<article class="col-lg-12 text-truncate ">' +
            '<h2 class="text-truncate">' + activitiesJson[i].name + '</h2>' +
            '<img src="/images/' + activitiesJson[i].picture + ' " alt=" ' + activitiesJson[i].name + ' " class="img-fluid">' +
            '<p class="text-center">' + activitiesJson[i].city + ' </p>' +
            '<a href="/activity/read/ ' + activitiesJson[i].id + ' " class="col-lg-12 btn btn-primary">détails de l\'activité</a>' +
            '</article>'
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
                '<article class="col-lg-12 text-truncate ">' +
                '<h2 class="text-truncate">' + activitiesJson[i].name + '</h2>' +
                '<img src="/images/' + activitiesJson[i].picture + ' " alt=" ' + activitiesJson[i].name + ' " class="img-fluid">' +
                '<p class="text-center">' + activitiesJson[i].city + ' </p>' +
                '<a href="/activity/read/ ' + activitiesJson[i].id + ' " class="col-lg-12 btn btn-primary">détails de l\'activité</a>' +
                '</article>'
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




